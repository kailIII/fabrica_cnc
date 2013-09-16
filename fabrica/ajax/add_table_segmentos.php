<?
header('Content-Type: text/html; charset=iso-8859-1');
include("../../libreria.php");
include("../../connection.php");
$nroRows	= $_POST['nroRows'];
$nroCols	= $_POST['nroCols'];
//echo '<BR>nroRows: '.$nroRows.' nroCols: '.$nroCols;

$rows		= NULL;
for($nRows = 0; $nRows <= $nroRows; $nRows++){
	//echo '<BR>ind: '.$ind.' vbObjetivo: '.$vbObjetivo;
	$cols	= NULL;
	$styleRow	= NULL;
	$vbTotal	= NULL;
	$bgObj		= "#FFFFFF";
	if($nRows == 0){
		$styleRow	= "style='background-color:#EBEBEB'";
		$bgObj		= "#EBEBEB";
		$vbTotal	= 'TOTAL';
	}
	for($nCol = 0; $nCol <= $nroCols; $nCol++){
		//echo '<BR>ind: '.$ind.' vbObjetivo: '.$vbObjetivo;
		$textAlign	= 'left';
		if($nCol > 0){
			$textAlign	= 'center';
		}
		$onkeypress	= NULL;
		$maxlength	= NULL;
		if($nRows > 0 && $nCol > 0){
			$onkeypress	= "onkeypress='return esNumero(event);'";
			$maxlength	= "maxlength='5'";
		}
		$obj	= "<INPUT type='text' name='' id='' class='borderBlue' style='width:95%; padding:4px 5px; background-color:$bgObj; text-align:$textAlign;' value='' $maxlength $onkeypress />";

		$cols	.= "<TD align='left' class='bb'><div class='padding5'>$obj</div></TD>";
	}
	$obj	= "<INPUT type='text' name='' id='' class='borderBlue' style='width:95%; padding:4px 5px; background-color:#EBEBEB; text-align:center;' value='$vbTotal' readonly='readonly' />";
	$cols	.= "<TD align='center' class='borderR' style='background-color:#EBEBEB'><div class='padding5'>$obj</div></TD>";
	$rows	.= "
	 <TR $styleRow>
	  $cols
	 </TR>";
}
?>
<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="">
 <?=$rows?>
</TABLE>
