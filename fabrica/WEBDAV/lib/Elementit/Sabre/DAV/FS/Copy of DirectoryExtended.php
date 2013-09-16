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
class Elementit_Sabre_DAV_FS_DirectoryExtended extends Sabre_DAV_FS_Directory{

  
	private $encoding = null;
   
    public function __construct($path) 
	{
		GLOBAl $webdav;
		parent::__construct($path); 
		//echo "construct ".$path;
		$this->encoding = isset($webdav["system_encoding"]) ? $webdav["system_encoding"] : null;; 		
	}
    /**
     * Returns a specific child node, referenced by its name 
     * 
     * @param string $name 
     * @throws Sabre_DAV_Exception_FileNotFound
     * @return Sabre_DAV_INode 
     */
    public function getChild($name) {

		$path = $this->path . '/' . $this->getDecodedStr($name);
		
		/*if($this->encoding != null)							
			$_path = $this->path . '/' .mb_convert_encoding($name, $this->encoding, 'UTF-8');
		else
			$_path = $path;
		*/

        if (!file_exists($path)) throw new Sabre_DAV_Exception_FileNotFound('getChild File with name ' . $path . ' could not be located');

        if (is_dir($path)) {
			//echo "folder ".$path;
            return new Elementit_Sabre_DAV_FS_DirectoryExtended($path);

        } else {			
			//echo "file ".$path;
            return new Elementit_Sabre_DAV_FS_FileExtended($path);
        }

    }
	
	/**
     * Checks if a child exists. 
     * 
     * @param string $name 
     * @return bool 
     */
    public function childExists($name) 
	{		
        return parent::childExists($this->getDecodedStr($name)); 
    }
	
	/**
     * Creates a new file in the directory 
     * 
     * data is a readable stream resource
     *
     * @param string $name Name of the file 
     * @param resource $data Initial payload 
     * @return void
     */
    public function createFile($name, $data = null) {

        parent::createFile($this->getDecodedStr($name), $data); 

    }

    /**
     * Creates a new subdirectory 
     * 
     * @param string $name 
     * @return void
     */
    public function createDirectory($name) {

         parent::createDirectory($this->getDecodedStr($name)); 

    }

    /**
     * Returns an array with all the child nodes 
     * 
     * @return Sabre_DAV_INode[] 
     */
    public function getChildren() {

        $nodes = array();
        foreach(scandir($this->path) as $node) 
			if($node!='.' && $node!='..') 
			{
				try
				{
					try{
						if($this->encoding != null)							
						{	
							$node = @mb_convert_encoding($node, 'UTF-8', $this->encoding);   																									
						}
					}
					catch(Esception $encE)
					{}
					$nodes[] = $this->getChild($node);
				}
				catch(Sabre_DAV_Exception_FileNotFound $e)
				{					
				}
			}
        return $nodes;

    }
	
	/**
     * Returns the name of the node encoded into system encoding (if set)
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
			return @mb_convert_encoding($this->path, 'UTF-8', $this->encoding);
		return $this->path;
	}
	
	private function getDecodedPath()
	{
		if($this->encoding != null)							
			return @mb_convert_encoding($this->path, $this->encoding, 'UTF-8');
		return $this->path;
	}
	
	private function getDecodedStr($str)
	{
		if($this->encoding != null)							
			return @mb_convert_encoding($str, $this->encoding, 'UTF-8');
		return $str;
	}
}

