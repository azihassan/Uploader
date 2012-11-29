<?php
namespace Uploader;
use \Uploader\Exceptions\UploaderException;
use \Uploader\IFilter;

class Uploader
{
	protected $_landingPath;
	protected $_filters;
	protected $_errors;

	public function __construct(array $filters = array())
	{
		foreach($filters as $f)
		{
			if(!($f instanceof IFilter))
			{
				throw new UploaderException(get_class($f).' does not implement the IFilter interface.');
			}
		}

		$this->_filters = $filters;
	}

	/* Specifies the directory to which the temporary file will be moved.
	 * It will throw an UploaderException if the given path isn't writable.
	 *
	 * @param string $path
	 * @throws UploaderException
	 * @return Uploader $this
	 */
	public function setLandingPath($path)
	{
		if(!is_writable($path))
		{
			throw new UploaderException($path.' is not writable, check the permissions of the directory.');
		}
		$this->_landingPath = $path;
		return $this;
	}

	/*
	 * @param IFilter $filter
	 * @return Uploader $this
	 */
	public function addFilter(IFilter $filter)
	{
		$this->_filters[] = $filter;
		return $this;
	}

	/* Processes the upload and returns the final path, or throws an UploaderException if errors occur during the upload.
	 *
	 * @param string $file
	 * @param array $_FILES
	 * @throws UploaderException
	 * @return string $path
	 */
	public function process($file, array $files)
	{
		if(!array_key_exists($file, $files) || $files[$file]['error'] > 0)
		{
			throw new UploaderException('Le fichier n\'a pas été uploadé correctement, veuillez réessayer.');
		}

		$final = $this->_landingPath.DIRECTORY_SEPARATOR.time();
		
		foreach($this->_filters as $f)
		{
			if($f->check($files[$file]) === FALSE)
			{
				$this->_errors[] = $f->getError();
			}
		}
		if(!empty($this->_errors))
		{
			throw new UploaderException(implode('<br />', $this->_errors));
		}
		if(!move_uploaded_file($files[$file]['tmp_name'], $final))
		{
			throw new UploaderException('Impossible de déplacer le fichier temporaire.');
		}

		return $final;
	}
}
