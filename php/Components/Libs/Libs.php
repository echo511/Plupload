<?php

namespace Plupload\Components;

/**
 * This file is a part of Plupload component for Nette Framework.
 *
 * @author     Nikolas Tsiongas
 * @package    Plupload component
 * @license    New BSD License
 */
class Libs extends \Nette\Application\UI\Control
{

    // Where js etc. will be stored for browser to load (WWW_DIR)
    private $tempLibsDir;

    // Array of already loaded Js (uses paths relative to tempLibsDir)
    public $loadedJs = array();

    // Array of already loaded Css (uses paths relative to tempLibsDir)
    public $loadedCss = array();


    /*********** Setters ***********/
    public function setTempLibsDir($tempLibsDir)
    {
        $this->tempLibsDir = $tempLibsDir;
        return $this;
    }


    /*********** Magic loading ***********/
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