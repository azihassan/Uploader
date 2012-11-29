<?php
namespace Uploader;
use \Uploader\Exceptions\UploaderException;
use \Uploader\IFilter;

class Uploader
{
	protected $_landingPath;
	protected $_filters;
	protected $_errors;

	public function setLandingPath($path)
	{
		if(!is_writable($path))
		{
			throw new UploaderException('Impossible d\'écrire dans '.$path.', veuillez vérifier les permissions du répertoire.');
		}
		$this->_landingPath = $path;
		return $this;
	}

	public function addFilter(IFilter $filter)
	{
		$this->_filters[] = $filter;
		return $this;
	}

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
