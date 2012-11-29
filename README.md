Uploader
========

A class to make the uploading of files less painful.

The class provides an interface you need to implement if you want to make custom filters :

<code>
<?php
interface IFilter
{
	public bool check(array $fileInfo);
	public string getError();
}
</code>

The first parameter of the check() method nothing more than the array inside the $_FILES superglobal. The process() method of the Uploader class will pass the correct parameter so you just need to write the method with that in mind.
getError() should return a descriptive message that will be displayed in case check() returns false. Check the Filters/ directory for a few examples on how to write filters, and test.php on how to use them.

<code>
<?php
class Uploader
{
	public string process(string $file, array $files);
}
</code>
The process() method is to be called after setting up all the needed filters and options. It will run them one by one and throw an UploaderException containing all the error messages that are returned by the getError() method of the filters. In case there were no errors, the temporary file will be moved to the directory specified by the setLandingPath() method and a full path will be returned.
