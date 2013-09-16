<?php


date_default_timezone_set('America/Bogota');
setlocale(LC_ALL,"es_ES");
set_include_path( dirname(__FILE__).'/../phpPowerPoint/Classes' );

require_once dirname(__FILE__).'/krumo/class.krumo.php';
require_once dirname(__FILE__).'/classes/class.Propuesta.php';
require_once dirname(__FILE__).'/classes/class.Metodologia.php';

echo 'Bogotá '.strftime('%e de %B de %Y');


var_dump( strftime('%e de %B de %Y') );