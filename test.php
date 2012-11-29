<?php
include 'autoload.php';

$uploader = new Uploader\Uploader;

try
{
	$uploader   ->setLandingPath(__DIR__.DS.'files')
				->addFilter(new Uploader\Filters\SizeFilter(2 * 1024 * 1024))
				->addFilter(new Uploader\Filters\ExtensionFilter(array('jpg', 'png', 'jpeg', 'pdf')));

	$path = $uploader->process('fichier', $_FILES);
	echo 'Le fichier figure dans le chemin suivant : '.$path;
}
catch(Uploader\Exceptions\UploaderException $e)
{
	echo 'Il y a eu des erreurs lors de l\'upload : <br />';
	echo $e->getMessage();
}
