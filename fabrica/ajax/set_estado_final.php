<?php

require_once dirname(__FILE__).'/../classes/class.Propuesta.php';
$Propuesta = new Propuesta( $_POST['id_propuesta'] );

$Propuesta->setEstadoFinal( $_POST['estado_final'] );