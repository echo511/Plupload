Plupload for Nette Framework
============================

Installation
------------

Install using composer:
```sh
$ composer require echo511/plupload:2.0.*
```

Register compiler extension: Echo511\Plupload\DI\PluploadExtension

Load javascript and css files required by plupload. Required javascript libraries are *jQuery, jQueryUI, plupload.full.js, jquery.ui.plupload.js*. Load corresponding css or style as you wish. Snapshots of required javascript, css assets can be found in assets folder.

If you wish to use ajax and Nette snippets, use extension: http://addons.nette.org/cs/nette-ajax-js If you prefer your solution then you need to adjust the latte file.


Usage
-----

In presenter like this:

```php
<?php

use Nette\Application\UI\Presenter;
use Echo511\Plupload\Entity\UploadQueue;

class HomePresenter extends Presenter
{

	/** @var \Echo511\Plupload\Control\IPluploadControlFactory @inject */
	public $controlFactory;

	public function createComponentPlupload()
	{
		$plupload = $this->controlFactory->create();
		$plupload->onFileUploaded[] = function(UploadQueue $uploadQueue) {
			...
		};
		$plupload->onUploadComplete[] = function(UploadQueue $uploadQueue) {
			...
		};
		return $plupload;
	}

}
```