<?php 


class MagicZip {
	private $zip;
	
	/*
	- Constructor for MagicZipNew
	- Creates a zip file
	
	$fileName     - The name and location relative to the location of this script
	                for the new zip file to have.
	$overwrite    - Optional, default is true, whether or not to overwrite the zip
	                file if it already exists in this location and with this name.
	*/
	
	public function __construct($fileName, $overwrite = true) {
		$this->zip = new ZipArchive();
		$allow = true;
		
		if (file_exists($fileName)) {
			if ($overwrite)
				unlink($fileName);
			else {
				$allow = false;
				echo "Zip already exists here and overwrite is set to false.";
			}
		}
		
		if ($allow) {
			if ($this->zip->open($fileName, ZipArchive::CREATE) == TRUE) {
				return true;
			}
		}
		
		return false;
	}
	
	/*
	- Add Files
	- Use for more than one file to be added.
	
	$files (single array) - Single array containing the files to be added to the ZIP
	                        uses the same name and location as defined.
	$files (double array) - First index is the location and name of the file to be added
	                        Second index is the new name and location of the file when
							placed into the ZIP.
							eg. $zip->addFiles(array(
								 array('path/to/file.txt', 'file.txt'),
								 array('path/to/image.png', 'images/image.png')
								));
	*/	             
	
	public function addFiles($files) {
		$success = true;
		
		foreach ($files as $file) {
			if (is_array($file))
				$success = $this->zip->addFile($file[0], $file[1]);
			else
				$success = $this->zip->addFile($file);
		}
		
		return $success;
	}
	
	/*
	- Add File
	- Use for just one file to be added.
	
	$file         - The file to be added to the ZIP and uses the same name and location as defined.
	$file (array) - First index is the location and name of the file to be added
	                Second index is the new name and location of the file when placed into the ZIP.
					eg. $zip->addFile(array('path/to/file.txt', 'file.txt'));
	*/
	
	public function addFile($file) {
		$success = true;
		
		if (is_array($file))
			$success = $this->zip->addFile($file[0], $file[1]);
		else
			$success = $this->zip->addFile($file);
		
		return $success;
	}
	
	/*
	- Add Empty Directory
	- Adds an empty directory in the ZIP folder given a specific name and location.
	
	$dirName      - The name (and location) of the new empty directory to be added.
	                eg. $zip->addEmptyDir("uploads");
					    $zip->addEmptyDir("uploads/moreuploads");
	*/
	
	public function addEmptyDir($dirName) {
		return $this->zip->addEmptyDir($dirName);
	}
	
	/*
	- Add Directory
	- Adds existing directory and all of its children to the ZIP folder.
	
	$dirName    - The name (and location) of the directory to be added.
	*/
	
	public function addDir($dirName) {
		if (file_exists($dirName)) {
			if (substr($dirName, -1) != '/')
				$dirName .= '/';
			
			foreach (glob($dirName . '*') as $file) {
				$this->zip->addFile($file);	
			}
		}
	}
	
	/*
	- Delete File
	- Allows you to delete a file in the ZIP.
	
	$fileName     - The name (and location) of the file to be deleted.
					eg. $zip->deleteFile("images/image.png");
	*/
	
	public function deleteFile($fileName) {
		return $this->zip->deleteName($fileName);	
	}
	
	/*
	- Close Zip Creation
	- Use when you are done adding to or modifying the new ZIP file.
	- The Zip will only be created when this is called.
	*/
	
	public function close() {
		$this->zip->close();	
	}
};

?>