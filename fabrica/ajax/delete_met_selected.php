<?php

require_once dirname( __FILE__ ).'/../classes/class.Metodologia.php';

$Metodologia = new Metodologia( $_POST['id_propuesta'] );
$Metodologia->cleanTable( $_POST['id_met'] );
$Metodologia->deletePropMet( $_POST['id_met'] );