<?
//----
$sql = "SELECT A.id_metodologia,A.nom_metodologia
 FROM ".tablaMetodologia." A INNER JOIN ".tablaMetodologiaRTA." B USING (id_metodologia)
  WHERE id_propuesta=".$idPropuesta."
   ORDER BY A.id_metodologia";
//echo '<BR>'.$sql;
$filasEntregable		= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_metodologia		= $campos["id_metodologia"];
	$nom_metodologia	= $campos["nom_metodologia"];

	$filasEntregable	.= "
	<TABLE width='98%' border='0' cellspacing='0' cellpadding='0' align='center'>
	 <TR>
	  <TD width='1%' align='right' class='bb divInstruccion'>&nbsp;</TD>
	  <TD width='40%' align='left' class='bb divInstruccion'><div class='padding5'><B>Productos</B></div></TD>
	  <TD width='20%' align='center' class='bb divInstruccion'><div class='padding5'><B>$nom_metodologia</B></div></TD>
	  <TD align='right' class='bb divInstruccion'>&nbsp;</TD>
	 </TR>";

	//----
	$sqlP = "SELECT * FROM ".tablaEntregable." ORDER BY 1";
	//echo '<BR>'.$sqlP;
	$conP					= mysql_query($sqlP);
	while($camposP			= mysql_fetch_array($conP)){
		$id_entregable		= $camposP["id_entregable"];
		$nom_entregable		= $camposP["nom_entregable"];
	
		//---- consulta si el proceso aplica para la propuesta activa
		$sqlR = "SELECT * FROM ".tablaEntregableRTA."
		 WHERE id_propuesta=".$idPropuesta." AND id_metodologia=".$id_metodologia." AND id_entregable=".$id_entregable;
		//echo '<BR>'.$sqlR;
		$chObj		= NULL;
		$conR		= mysql_query($sqlR);
		if(mysql_num_rows($conR)){
			$chObj	= "checked='checked'";
		}
		$nameObj	= 'm'.$id_metodologia.'[]';
		$idObj		= 'm'.$id_metodologia.'p'.$id_entregable;
		$objCH		= "<INPUT type='checkbox' name='$nameObj' id='$idObj' value='$id_entregable' $chObj />";

		$filasEntregable	.= "
		 <TR>
		  <TD align='right' class='bb'><div class='padding5'><IMG src='/imagenes/yes.png' height='16' border='0'></div></TD>
		  <TD align='left' class='bb'><div class='padding5 textLabel'>$nom_entregable</div></TD>
		  <TD align='center' class='bb'><div class='padding5'>$objCH</div></TD>
		  <TD align='center' class='bb'>&nbsp;</TD>
		 </TR>";
	}
	$filasEntregable	.= "</TABLE>";
}
?>

	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left" style='border:1px solid #CED7EC;'>
	 <TR>
	  <TD align="center" colspan="2">
	    <div class='padding5'><?=$filasEntregable?></div>
	  </TD>
	 </TR>
	</TABLE>
