<?php

namespace Plupload\Components;

class Libs extends \Nette\Application\UI\Control
{

    private $tempLibsDir;

    public $loadedJs = array();

    public $loadedCss = array();

    public function setTempLibsDir($tempLibsDir)
    {
        $this->tempLibsDir = $tempLibsDir;
        return $this;
    }

    public function registerJs($shortPath)
    {
        if(!in_array($shortPath, $this->loadedJs)) {
            $this->loadedJs[] = $shortPath;
            $string = '<script type="text/javascript" src="'.$this->tempLibsDir.$shortPath.'"></script>';
            return $string;
        }
    }

    public function registerCss($shortPath)
    {
        if(!in_array($shortPath, $this->loadedJs)) {
            $this->loadedJs[] = $shortPath;
            return '<link rel="stylesheet" type="text/css" href="'.$this->tempLibsDir.$shortPath.'" />';
        }
    }

}