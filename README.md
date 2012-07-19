Plupload component for Nette
============================

Implementation:
---------------

Don't forget to load jQuery and jQuery UI manually.

There is no need for including any extra JS or Css in head. Everything is done automatically. If you prefer to do it by yourself then disable magic.


Usage
-----

    public function createComponentPlupload()
    {
        // Main object
        $uploader = new Echo511\Plupload\Rooftop();

        // Use magic for loading Js and Css?
        // $uploader->disableMagic();

        // Configuring paths
        $uploader->setWwwDir(WWW_DIR) // Full path to your frontend directory
                 ->setBasePath($this->template->basePath) // BasePath provided by Nette
                 ->setTempLibsDir(WWW_DIR . '/plupload511/test'); // Full path to the location of plupload libs (js, css)

        // Configuring plupload
        $uploader->createSettings()
                 ->setRuntimes(array('html5')) // Available: gears, flash, silverlight, browserplus, html5
                 ->setMaxFileSize('1000mb')
                 ->setMaxChunkSize('1mb'); // What is chunk you can find here: http://www.plupload.com/documentation.php

        // Configuring uploader
        $uploader->createUploader()
                 ->setTempUploadsDir(WWW_DIR . '/plupload511/tempDir') // Where should be placed temporaly files
                 ->setToken("ahoj") // Resolves file names collisions in temp directory
                 ->setOnSuccess(array($this, 'tests')); // Callback when upload is successful: returns Nette\Http\FileUpload

        return $uploader->getComponent();
    }

See the code for more intel...