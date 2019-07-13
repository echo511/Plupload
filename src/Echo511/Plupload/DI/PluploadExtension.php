<?php

/**
 * This class is part of Echo511\Plupload. Licence free.
 */

namespace Echo511\Plupload\DI;

use Nette\DI\CompilerExtension;

/**
 * Register extension in DI container.
 * 
 * @author Nikolas Tsiongas
 */
class PluploadExtension extends CompilerExtension
{

	/**
	 * Load services, register factories.
	 */
	public function loadConfiguration()
	{
		$config = $this->loadFromFile(__DIR__ . '/../config/plupload.neon');
		$this->compiler->loadDefinitionsFromConfig($config['services']);
	}



}
