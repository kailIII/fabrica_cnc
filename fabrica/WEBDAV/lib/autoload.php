<?php

function simple_autoload($className) 
{
	include dirname(__FILE__) . '/' . str_replace('_','/',$className) . '.php';
}

spl_autoload_register('simple_autoload');
?>