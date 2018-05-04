<?php

/**
 * This class is part of Echo511\Plupload. Licence free.
 */

namespace Echo511\Plupload\Entity;


/**
 * Uploaded file envelope.
 * 
 * @author Nikolas Tsiongas
 */
class Upload
{

	/** @var string */
	private $filename;

	/** @var string */
	private $name;

	public function __construct($filename, $name = null)
	{
		$this->filename = $filename;
		$this->name = $name;
	}



	/**
	 * Get filename.
	 * @return string
	 */
	public function getFilename()
	{
		return $this->filename;
	}



	/**
	 * Get name provided by client.
	 * @return string
	 */
	public function getName()
	{
		return isset($this->name) ? $this->name : basename($this->filename);
	}



	/**
	 * Move file to another location.
	 * @param string $location
	 * @return Upload
	 */
	public function move($location)
	{
		@mkdir(dirname($location), 0777, TRUE); // @ - dir may already exist
		@unlink($location); // @ - file may not exists
		if (!call_user_func(is_uploaded_file($this->filename) ? 'move_uploaded_file' : 'rename', $this->filename, $location)) {
			throw new Nette\InvalidStateException("Unable to move uploaded file '$this->filename' to '$location'.");
		}
		chmod($location, 0666);
		$this->filename = $location;
		return $this;
	}



}

interface IUploadFactory
{

	/** @return Upload */
	function create($filename, $name);
}
