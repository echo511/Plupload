<?php

namespace Plupload\Components;

class JQueryUIWidget extends \Nette\Application\UI\Control
{

	private $rooftop;
	private $template;

    private $libsComponent;

    public function attached($presenter)
    {
        $components = $presenter->getComponents(true, 'Plupload\Components\Libs');
        foreach($components as $component) {
            $this->libsComponent = $component;
            break;
        }

        if($this->libsComponent === null) {
            $this->libsComponent = new \Plupload\Components\Libs($this, 'libs');
            $this->libsComponent->setTempLibsDir($this->rooftop->tempLibsDir);
        }

    }

	public function __construct(\Plupload\Rooftop $rooftop)
	{
		$this->rooftop = $rooftop;
		$this->_createTemplate();

        if($this->rooftop->isMagical())
            $this->monitor('Nette\Application\UI\Presenter');
	}

    public function render($token = 'test')
    {
        $this->template->token = $token;
        $this->template->libsComponent = $this->libsComponent;
        $this->template->render();
    }

    private function _createTemplate()
    {
        $template = $this->createTemplate();
        $template->registerFilter(new \Nette\Latte\Engine);

        $template->tempLibsDir = $this->rooftop->tempLibsDir;
        $template->pluploadSettings = $this->rooftop->pluploadSettings;

        $template->isMagical = $this->rooftop->isMagical();

        $template->setFile(__DIR__ . '/templates/default.latte');
        $this->template = $template;
    }

    public function handleUpload()
    {
        $this->rooftop->upload();
    }

}