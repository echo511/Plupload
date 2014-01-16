<?php

/**
 * This class is part of Echo511\Plupload. Licence free.
 */

namespace Echo511\Plupload\Entity;

use Nette\Object;

/**
 * Queue of already uploaded files by unique widget. On page refresh id refreshes.
 * 
 * @author Nikolas Tsiongas
 */
class UploadQueue extends Object
{

	/** @var string */
	private $id;

	/** @var Upload[] */
	private $uploads = array();

	public function __construct($id)
	{
		$this->id = $id;
	}



	/**
	 * Id of queue/widget.
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}



	/**
	 * Add uploaded file.
	 * @param Upload $upload
	 */
	public function addUpload(Upload $upload)
	{
		$this->uploads[] = $upload;
	}



	/**
	 * Get last uploaded file.
	 * @return Upload
	 */
	public function getLastUpload()
	{
		return $this->uploads[count($this->uploads) - 1];
	}



	/**
	 * Get all uploaded files.
	 * @return Upload[]
	 */
	public function getAllUploads()
	{
		return $this->uploads;
	}



}

interface IUploadQueueFactory
{

	/** @return UploadQueue */
	function create($id);
}
