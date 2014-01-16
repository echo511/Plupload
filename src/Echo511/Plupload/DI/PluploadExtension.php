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
		$builder = $this->getContainerBuilder();
		$config = $this->loadFromFile(__DIR__ . '/../config/plupload.neon');
		$namespace = 'Echo511.Plupload.DI';
		$this->compiler->parseServices($builder, $config, $namespace);
	}



}
