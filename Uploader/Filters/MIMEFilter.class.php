<?php
namespace Uploader\Filters;
use \Uploader\IFilter;

class MIMEFilter implements IFilter
{
	protected $_allowedMIMETypes;

	public function __construct(array $allowedMIMETypes = array())
	{
		$this->_allowedMIMETypes = $allowedMIMETypes;
	}

	public function getAllowedMIMETypes()
	{
		return $this->_allowedMIMETypes;
	}

	public function addMIMEType($type)
	{
		$this->_allowedMIMETypes[] = $type;
		return $this;
	}

	public function check(array $fileInfo)
	{
		return in_array($fileInfo['type'], $this->_allowedMIMETypes);
	}

	public function getError()
	{
		return 'The MIME type of this file isn\'t allowed.';
	}
}
