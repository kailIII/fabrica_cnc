<?php

require_once dirname(__FILE__).'/krumo/class.krumo.php';
require_once dirname(__FILE__).'/classes/class.Propuesta.php';
require_once dirname(__FILE__).'/classes/class.Metodologia.php';

$Propuesta = new Propuesta( 104 );
$Propuesta->setFechasCalendario();