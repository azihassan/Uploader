<?php
namespace Uploader\Filters;
use \Uploader\IFilter;

class SizeFilter implements IFilter
{
	protected $_maxSize;

	public function __construct($maxSize = 1048576)
	{
		$this->setMaxSize($maxSize);
	}

	public function getMaxSize()
	{
		return $this->_maxSize;
	}

	public function setMaxSize($maxSize)
	{
		$this->_maxSize = $maxSize;
		return $this;
	}

	public function check(array $fileInfo)
	{
		return filesize($fileInfo['tmp_name']) < $this->_maxSize;
	}

	public function getError()
	{
		return 'Le fichier est trop gros.';
	}
}
