<?
include("ctl_login_admin.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>..:: <?=tituloPag?> ::..</TITLE>
<!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
-->
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script language="JavaScript" type="text/javascript" src="/scripts/js.js"></script>
<script language="JavaScript" type="text/javascript" src="ajax/ajax2.js?v=<?=$aleatorio?>"></script>
<LINK rel="stylesheet" href="/css/style.css" type="text/css">
<style>
.textLabel	{
	color:#5F5F5F;
	font-size:14px;
}
.txt	{
	padding:3px 5px;
}
.divInstruccion{
	background-color:#F0F0F0;
	color:#333366;
}
.colorBlanco	{ color:#FFF; }

.linkF	{
	color:#036;
}

.tituloSeccion	{
	background-color:#CCC;	
}
.bgMenuSel	{
	background-color:#C0E3F1;	
}

/*a {
  text-decoration: none;
}
a:hover {
  text-decoration: underline;
}*/
</style>
<!-- Contact Form CSS files -->
<link type='text/css' href='css/contact.css?v=<?=$aleatorio?>' rel='stylesheet' media='screen' />
</head>
<script>
//----
function verLugares(clic){
	if(document.getElementById('<?=idObjLugar?>').value.length == 0 || clic	== 1){
		var divResultado 	= document.getElementById('listLugares');
		if(divResultado.style.display == 'none'){
			showdiv('listLugares');
		}else{
			hidediv('listLugares');
		}
	}
}
//----
function selLugar(idDiv){
	//alert('idDiv: '+idDiv);
	var nomLugar 	= document.getElementById(idDiv).innerHTML;
	document.getElementById('<?=idObjLugar?>').value	= nomLugar;
	hidediv('listLugares');
}


</script>
<body>
<div class='contact-content div_radius8'>
<FORM name="formulario" id="formulario" method="post" action="">
<INPUT type='hidden' name='idPropuesta' id='idPropuesta' value='<?=$idPropuesta?>'>
<INPUT type='hidden' name='idRowMetodologia' id='idRowMetodologia' value='<?=$idRowMetodologia?>'>
<INPUT type='hidden' name='idTipoMetodologia' id='idTipoMetodologia' value='<?=$idTipoMetodologia?>'>
<INPUT type='hidden' name='idMetodologia' id='idMetodologia' value='<?=$idMetodologia?>'>
<INPUT type='hidden' name='idRowSegmento' id='idRowSegmento' value='<?=$idRowSegmento?>'>
<INPUT type='hidden' name='cPagina' id='cPagina' value='<?=$cPagina?>'>
 	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#333333;">
	 <TR>
	  <TD align='left' width="95%"><div style="padding:0px 5px; color:#FFFFFF; font-size:14px;"><B><?=$tituloModal?></B></div></TD>
	  <TD align='right' width="5%"><div style="padding:4px 1px;"><a href="javascript:void(0);"><img src="/imagenes/ico3_error.png" width="22" border="0" alt="Cancelar" title="Cancelar" class="simplemodal-close" /></a></div></TD>
	 </TR>
	</TABLE>
<?
$nroRows	= 4;
$nroCols	= 5;
$rows		= NULL;
	for($nRows = 1; $nRows <= $nroRows; $nRows++){
		//echo '<BR>ind: '.$ind.' vbObjetivo: '.$vbObjetivo;
		$cols	= NULL;
		$styleRow	= NULL;
		$vbTotal	= NULL;
		$bgObj		= "#FFFFFF";
		if($nRows == 1){
			$styleRow	= "style='background-color:#EBEBEB'";
			$bgObj		= "#EBEBEB";
			$vbTotal	= 'TOTAL';
		}
		for($nCol = 1; $nCol <= $nroCols; $nCol++){
			//echo '<BR>ind: '.$ind.' vbObjetivo: '.$vbObjetivo;
			$textAlign	= 'left';
			if($nCol > 1){
				$textAlign	= 'center';
			}
			$onkeypress	= NULL;
			$maxlength	= NULL;
			if($nRows > 1 && $nCol > 1){
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
<INPUT type='text' name='' id='' class='borderBlue' style='width:95%; padding:4px 5px; background-color:$bgObj; text-align:center' value=''  readonly="readonly"/>
	<div style="height:400px; padding:0px; overflow:auto; padding:2px 4px;">
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="borderTL">
     <TR>
      <TD align='left' class="bb"><div class='padding5 textLabel'>Mecanismo de captaci&oacute;n de los participantes:</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='<?=idObjOrigenDB?>' id='<?=idObjOrigenDB?>' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionOrigenDB?>
		</SELECT>
      </div></TD>
     </TR>
     <TR>
      <TD align='left' class="bb" nowrap="nowrap"><div class='padding5 textLabel'>Cantidad de participantes :</div></TD>
      <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='<?=idObjPobObjetivo?>' id='<?=idObjPobObjetivo?>' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionPobObjetivo?>
		</SELECT>
      </div></TD>
     </TR>
	</TABLE>
<br />
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="borderTL">
     <?=$rows?>
	</TABLE>
</FORM>
</div>

</body>
</html>