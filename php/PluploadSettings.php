<?php

namespace Plupload;

/**
 * This file is a part of Plupload component for Nette Framework.
 *
 * @author     Nikolas Tsiongas
 * @package    Plupload component
 * @license    New BSD License
 */
class PluploadSettings extends \Nette\Object
{

    // Runtimes we want to use
    private $runtimes = array('html5');

    // Max size of upload file
    private $maxFileSize = '10mb';

    // Max size of single chunk
    private $maxChunkSize = '5mb';


    /*********** Setters ***********/
    function setRuntimes(array $runtimes)
    {
        $possible = array('gears', 'flash', 'silverlight', 'browserplus', 'html5');
        foreach($runtimes as $runtime) {
            if(!in_array($runtime, $possible)) {
                throw new Exception('There is no runtime called: '.$runtime);
            }
        }
        $this->runtimes = $runtimes;
        return $this;
    }

    public function setMaxFileSize($expr)
    {
        $this->maxFileSize = $expr;
        return $this;
    }

    public function setMaxChunkSize($expr)
    {
        $this->maxChunkSize = $expr;
        return $this;
    }


    /*********** Getters ***********/
    public function getRuntimes()
    {
        return implode(",", $this->runtimes);
    }

    public function getMaxFileSize()
    {
        return $this->maxFileSize;
    }

    public function getMaxChunkSize()
    {
        return $this->maxChunkSize;
    }

}