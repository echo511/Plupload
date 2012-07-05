<?php

namespace Plupload;

/**
 * This file is a part of Plupload component for Nette Framework.
 *
 * @author     Nikolas Tsiongas
 * @package    Plupload component
 * @license    New BSD License
 */
class Rooftop extends \Nette\Object
{

    // Full path to front directory
    private $wwwDir;

    // Browser path to front directory
    private $basePath;

    // Where js etc. will be stored for browser to load (WWW_DIR)
    private $tempLibsDir;

    // Settings for js component
    private $pluploadSettings;

    // IUploader handles upload request
    private $uploader;

    // Js and Css will be loaded automatically
    private $useMagic = true;

    public function getComponent($class = 'Plupload\Components\JQueryUIWidget')
    {
        return new $class($this);
    }


    /*********** Magic ***********/
    public function isMagical()
    {
        return $this->useMagic;
    }

    public function disableMagic()
    {
        $this->useMagic = false;
        return $this;
    }


    /*********** Setters ***********/
    public function setWwwDir($dir)
    {
        $this->wwwDir = $dir;
        return $this;
    }

    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
        return $this;
    }

    public function setTempLibsDir($dir)
    {
        $this->tempLibsDir = $this->returnDir($dir);
        return $this;
    }

    public function setPluploadSettings(PluploadSettings $settings)
    {
        $this->pluploadSettings = $settings;
        return $this;
    }

    public function setUploader(Uploaders\IUploader $uploader)
    {
        $this->uploader = $uploader;
        return $this;
    }


    /*********** Getters ***********/
    public function getTempLibsDir()
    {
        if($this->isMagical()) {
            if(!file_exists($this->tempLibsDir . '/copied.txt'))
                self::copy(__DIR__ . '/../front', $this->tempLibsDir);
        }

        return $this->basePath.str_replace($this->wwwDir, '', $this->tempLibsDir);
    }

    public function getPluploadSettings()
    {
        return $this->pluploadSettings;
    }


    /*********** Shortcuts ***********/
    public function createSettings($class = 'Plupload\PluploadSettings')
    {
        $settings = new $class;
        $this->setPluploadSettings($settings);
        return $settings;
    }

    public function createUploader($class = 'Plupload\Uploaders\Defaults')
    {
        $uploader = new $class;
        $this->setUploader($uploader);
        return $uploader;
    }

    /*********** Upload ***********/
    public function upload()
    {
        $this->uploader->upload();
    }


    /*********** Helpers ***********/
    private function returnDir($dir)
    {
        if( is_dir($dir) ) {
            return $dir;
        } else {
            if($this->isMagical())
                mkdir($dir, 0, true);
            return $dir;
        }
    }

    static function copy($source, $dest, $overwrite = true) {
        $dir = opendir($source);
        @mkdir($dest);
        while(false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if(is_dir($source . '/' . $file)) {
                    self::copy($source . '/' . $file, $dest . '/' . $file);

                } else {
                    if($overwrite || !file_exists($dest . '/' . $file)) {
                        copy($source . '/' . $file, $dest . '/' . $file);
                    }
                }
            }
        }
        closedir($dir);
    }

}