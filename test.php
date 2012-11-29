<?php
include 'autoload.php';

try
{
	$uploader = new Uploader\Uploader(array(
		new Uploader\Filters\SizeFilter(2 * 1024 * 1024),
		new Uploader\Filters\MIMEFilter(array('image/jpg')),
	));

	$uploader   ->setLandingPath(__DIR__.DS.'files')
				->addFilter(new Uploader\Filters\ExtensionFilter(array('jpg', 'png', 'jpeg', 'pdf')));

	$path = $uploader->process('fichier', $_FILES);
	echo 'The file is available in the following path : '.$path;
}
catch(Uploader\Exceptions\UploaderException $e)
{
	echo 'The following errors occurred during the upload : <br />';
	echo $e->getMessage();
}
