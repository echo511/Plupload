<?php

/**
 * This class is part of Echo511\Plupload. Licence free.
 * 
 * The upload-handle part of the file was used from the original example provided with Plupload.
 */

namespace Echo511\Plupload\Service;

use Echo511\Plupload\Entity\IUploadFactory;
use Exception;

/**
 * Service handeling upload.
 */
class Uploader
{

	/** @var string */
	private $tempDir;

	/** @var int */
	private $maxTempFileAge = 150;

	/** @var IUploadFactory */
	private $uploadFactory;

	public function __construct($tempDir, IUploadFactory $uploadFactory)
	{
		if (!is_dir($tempDir)) {
			mkdir($tempDir);
		}
		$this->tempDir = $tempDir;
		$this->uploadFactory = $uploadFactory;
	}



	/**
	 * Handle upload.
	 * @param string $id Id of widget performing upload.
	 * @param callable $onSuccess
	 * @throws Exception
	 */
	public function upload($id, $onSuccess)
	{
		/**
		 * upload.php
		 *
		 * Copyright 2013, Moxiecode Systems AB
		 * Released under GPL License.
		 *
		 * License: http://www.plupload.com/license
		 * Contributing: http://www.plupload.com/contributing
		 */
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		// 5 minutes execution time
		@set_time_limit(5 * 60);

		// Settings
		$targetDir = $this->tempDir;

		// Get a file name
		if (isset($_REQUEST["name"])) {
			$fileName = $_REQUEST["name"];
		} elseif (!empty($_FILES)) {
			$fileName = $_FILES["file"]["name"];
		} else {
			$fileName = uniqid("file_");
		}

		$filePath = $targetDir . DIRECTORY_SEPARATOR . $id . $fileName;

		// Chunking might be enabled
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

		// Open temp file
		if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
			throw new Exception('Failed to open output stream.', 102);
		}

		if (!empty($_FILES)) {
			if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
				throw new Exception('Failed to move uploaded file.', 101);
			}

			// Read binary input stream and append it to temp file
			if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
				throw new Exception('Failed to move uploaded file.', 101);
			}
		} else {
			if (!$in = @fopen("php://input", "rb")) {
				throw new Exception('Failed to move uploaded file.', 101);
			}
		}

		while ($buff = fread($in, 4096)) {
			fwrite($out, $buff);
		}

		@fclose($out);
		@fclose($in);

		// Check if file has been uploaded
		if ((!$chunks || $chunk == $chunks - 1) && filesize("{$filePath}.part") > 0){
			rename("{$filePath}.part", $filePath);
			$this->cleanTempDir();
			$onSuccess($this->uploadFactory->create($filePath, $fileName));
		}
	}



	/**
	 * Clean temp dirictory from old files, unfinished uploads.
	 */
	public function cleanTempDir()
	{
		$targetDir = $this->tempDir;

		if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
			die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
		}

		while (($file = readdir($dir)) !== false) {
			$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

			// Remove temp file if it is older than the max age and is not the current file
			if ((filemtime($tmpfilePath) < time() - $this->maxTempFileAge)) {
				@unlink($tmpfilePath);
			}
		}
		closedir($dir);
	}



}

class UploaderException extends Exception
{
	
}
