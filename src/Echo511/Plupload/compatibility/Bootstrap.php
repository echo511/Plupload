<?php

/**
 * This class is part of Echo511\Plupload. Licence free.
 */

namespace Echo511\Plupload\Compatibility;

class Bootstrap
{

	public static function init()
	{
		if (!trait_exists('Echo511\Plupload\SmartObject')) {
			if (trait_exists('Nette\SmartObject')) {
				class_alias('Echo511\Plupload\Compatibility\LegacyObject', 'Echo511\Plupload\LegacyObject');
				class_alias('Nette\SmartObject', 'Echo511\Plupload\SmartObject');
			} else {
				class_alias('Nette\Object', 'Echo511\Plupload\LegacyObject');
				class_alias('Echo511\Plupload\Compatibility\SmartObject', 'Echo511\Plupload\SmartObject');
			}
		}
	}

}
