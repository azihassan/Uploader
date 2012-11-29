<?php
namespace Uploader;

interface IFilter
{
	public function check(array $fileInfo);
	public function getError();
}
