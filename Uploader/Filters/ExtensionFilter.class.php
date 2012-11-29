<?php
namespace Uploader\Filters;
use \Uploader\IFilter;

class ExtensionFilter implements IFilter
{
	protected $_allowedExts;

	public function __construct(array $allowedExts = array())
	{
		$this->_allowedExts = $allowedExts;
	}

	public function addExtension($ext)
	{
		$this->_allowedExts[] = $ext;
		return $this;
	}

	public function getExtensions()
	{
		return $this->_allowedExts;
	}

	public function check(array $fileInfo)
	{
		return in_array(pathinfo($fileInfo['name'], PATHINFO_EXTENSION), $this->_allowedExts);
	}

	public function getError()
	{
		return 'Files with this extension are not allowed.';
	}
}
