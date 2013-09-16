/**
* Configuration object
*/
var _data = {	
	/**
	Url to server script wich should return correct JSON data	
	*/
	serverUrl : 'index.php',
	/**
	Url to the root folder of webdav server. Without ending /
	for example http://somedomain.com/webdav	
	*/
	webdavUrl : '',	
	/**
		Url prefix , if asp.net version used.
	*/
	webdavUrlPrefix : 'hcwebdav',	
	/**
	Human readable date format
	*/
	dateFormat: "dd.MM.yyyy HH:mm:ss",
	/**
	Configuration of context menu
	*/		
	contextMenuItems : [ 
		{'Download': { id:'download', onclick: function(menuItem,menu) { downloadFile(getItemByElement(this)); } } }, 		
		{'Edit': { id:'open', onclick:function(menuItem,menu) { openFileMO(getItemByElement(this)); } }},
		{'Edit in MS Office': { id:'openms', onclick:function(menuItem,menu) { openFileMS(getItemByElement(this)); } }},
		{'Edit in OpenOffice': { id:'openoo', onclick:function(menuItem,menu) { openFileOO(getItemByElement(this)); } }}		
	], 		
	
	/**
	Variable store current working directory
	*/
	currentDirectory : '/',	
	/**
	Flag determining if office path was sucessfully detected
	*/
	pathDetected : false,	
	/** 
	File to open when applet will be loaded
	*/
	fileToOpen : null,
	/** 
	Open mode
	*/
	modeToOpen : 0,
	/**
	Collection of files and folders in current directory
	*/
	files : null,
	
	/**
	application type. Asp.NET or php
	*/
	applicationType : "php"
}
