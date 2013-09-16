<?php

/**
 * Extended Directory class to prevent failure on nunicode filenames
 * 
 * @package Sabre
 * @subpackage DAV
 * @copyright Copyright (C) 2007-2010 Rooftop Solutions. All rights reserved.
 * @author Evert Pot (http://www.rooftopsolutions.nl/) 
 * @license http://code.google.com/p/sabredav/wiki/License Modified BSD License
 */
class Elementit_Sabre_DAV_FS_FileExtended extends Sabre_DAV_FS_File{

    private $encoding = null;
   
    public function __construct($path) 
	{
		GLOBAl $webdav;
		parent::__construct($path); 
		$this->encoding = isset($webDav["system_encoding"]) ? $weDdav["system_encoding"] : null;; 		
	} 
	
	/**
     * Returns the name of the node 
     * 
     * @return string 
     */
    public function getName() 
	{
        list(, $name)  = Sabre_DAV_URLUtil::splitPath($this->getEncodedPath());
        return $name;
    }
	
	private function getEncodedPath()
	{
		if($this->encoding != null)							
			return mb_convert_encoding($this->path, 'UTF-8', $this->encoding);
		return $this->path;
	}

}
?>
