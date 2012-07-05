<?php

namespace Plupload\Components;

/**
 * This file is a part of Plupload component for Nette Framework.
 *
 * @author     Nikolas Tsiongas
 * @package    Plupload component
 * @license    New BSD License
 */
class JQueryUIWidget extends \Nette\Application\UI\Control
{

    // Rooftop
    private $rooftop;

    // Template
    private $template;

    // Component for magic loading of Js and Css
    private $libsComponent;


    /*********** Init ***********/
    public function __construct(\Plupload\Rooftop $rooftop)
    {
        $this->rooftop = $rooftop;
        $this->_createTemplate();

        if($this->rooftop->isMagical())
            $this->monitor('Nette\Application\UI\Presenter');
    }


    /*********** Only magic loading purposes ***********/
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


    /*********** Rendering ***********/
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

    public function render($token = 'test')
    {
        $this->template->token = $token;
        $this->template->libsComponent = $this->libsComponent;
        $this->template->render();
    }


    /*********** Upload ***********/
    public function handleUpload()
    {
        $this->rooftop->upload();
    }

}