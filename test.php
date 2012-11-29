<?php
include 'autoload.php';

echo '<pre>';
print_r($_FILES);
echo '</pre>';

$uploader = new Uploader\Uploader;

try
{
	$uploader   ->setLandingPath(__DIR__.DS.'files/')
				->addFilter(new Uploader\Filters\SizeFilter(2 * 1024 * 1024))
				->addFilter(new Uploader\Filters\ExtensionFilter(array('jpg', 'png', 'jpeg', 'pdf')));

	$uploader->process('fichier', $_FILES);
}
catch(Uploader\Exceptions\UploaderException $e)
{
	echo 'Il y a eu des erreurs lors de l\'upload : <br />';
	echo $e->getMessage();
}
