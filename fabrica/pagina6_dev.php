<?
//---- consulta la forma de pago
if(empty($formaPago)){
	$sql = "SELECT * FROM ".tablaFormaPago;
	//echo '<BR>'.$sql;
	$con				= mysql_query($sql);
	while($campos		= mysql_fetch_array($con)){
		$formaPago		= $campos["forma_pago"];
	}
}

require_once dirname(__FILE__).'/classes/class.Metodologia.php';
$Metodologia = new Metodologia( $idPropuesta );


$idDivSubTotal	= 'divSubTotal';
$idDivIVA		= 'divIVA';
$idDivGranTotal	= 'divGranTotal';
$contItems		= 1;


$subTotal = $vbVrDirEstudio;
$vbVrDirEstudio	= number_format($vrDirEstudio);



$nomObjVrTotalItem	= nameObjVrTotalItem.'[]';
$idObjVrUnit		= nameObjVrDirEstudio;
$idObjVrTotalItem	= 'objVrTotalItem'.$contItems;
$idObjCantidad		= nameObjVrDirEstudio.'cant';
$objCantidad	= "<INPUT type='text' name='".$idObjCantidad."' id='".$idObjCantidad."' value='1' class='txt' style='width:60px; text-align:center; border:none;' readonly='readonly' />";
			
$fxVrUnit			= "fxInversion('$idObjCantidad','".porcentajeIVA."','$idObjVrUnit','$nomObjVrTotalItem','$idObjVrTotalItem','$idDivSubTotal','$idDivIVA','$idDivGranTotal')";

$objPrecioUnit	= "<INPUT type='text' name='".$idObjVrUnit."' id='".$idObjVrUnit."' maxlength='10' value='$vbVrDirEstudio' class='txt' style='width:80px; text-align:right;' onkeypress='return esNumero(event);' onkeyup=\"$fxVrUnit;\" />";			
//----
$objVrTotalItem	= "<INPUT type='text' name='".$nomObjVrTotalItem."' id='".$idObjVrTotalItem."' value='$vbVrDirEstudio' style='width:90px; text-align:right; border:none;' readonly='readonly' />";			

// Valor tipo estudio
$filasInversion	= "
     <TR>
      <TD align='right' class='borderBR'><div class='padding5'>$contItems</TD>
      <TD align='left' class='borderBR'><div class='padding5'>Direcci&oacute;n de estudios</div></TD>
      <TD align='center' class='borderBR'><div class='padding5'>$objCantidad</div></TD>
      <TD align='right' class='borderBR'><div class='padding5'>$objPrecioUnit</div></TD>
      <TD align='right' class='borderBR'><div class='padding5'>$objVrTotalItem</div></TD>
     </TR>";

//---- consulta las metodologías de la propuesta
/* $sql = "SELECT *
 FROM ".tablaMetodologia." M INNER JOIN ".tablaMetodologiaRTA." R USING(id_metodologia)
  WHERE R.id_propuesta=$idPropuesta
   ORDER BY 1";
  // echo '<BR>'.$sql;
$subTotal				= 0;
$cont					= 0;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	++$cont;
	$id_metodologia		= $campos["id_metodologia"];
	$nom_metodologia	= $campos["nom_metodologia"];
	$idTipoMetodologia	= $campos["id_tipo_metodologia"];
	$idRowMetodologia	= $campos["id_row_metodologia"];
	$titulo				= $campos["titulo"];
	$temas				= $campos["temas"];
	$universo			= $campos["universo"];
	$marco_estadistico	= $campos["marco_estadistico"];


//	if($idTipoMetodologia==3){
	if(!empty($idTipoMetodologia)){

		// krumo($Propuesta->calcInversion( $idRowMetodologia ));

		//---- consulta los segmentos de la metodología
		$sqlR = "SELECT *
		 FROM ".tablaSegmentoMetodologiaRTA." R
		  WHERE R.id_row_metodologia=$idRowMetodologia
		   ORDER BY 1";
		   '<BR>'.$sqlR;
		// krumo($sqlR);
		$filasSegmentos			= NULL;
		$conR					= mysql_query($sqlR);
		while($camposR			= mysql_fetch_array($conR)){
			++$contItems;
			$id_row_segmento	= $camposR["id_row_segmento"];
			$id_pob_objetivo	= $camposR["id_pob_objetivo"];
			$id_duracion		= $camposR["id_duracion"];
			$id_nivel_aceptacion= $camposR["id_nivel_aceptacion"];
			$id_cobertura		= $camposR["id_cobertura"];
			$id_origen_db		= $camposR["id_origen_db"];
			$nom_segmento		= $camposR["nom_segmento"];
			$universo			= $camposR["universo"];
			$muestra			= $camposR["muestra"];
			$precioUnitario		= $camposR["precio_unitario"];

			$cond				= NULL;
			$vrUnitario			= 0;
			$vrTotal			= 0;
			if(!empty($muestra) && empty($precioUnitario)){
				if(!empty($id_pob_objetivo)){
					$cond	.= " AND id_pob_objetivo='$id_pob_objetivo'";
				}
				if(!empty($id_duracion)){
					$cond	.= " AND id_duracion='$id_duracion'";
				}
				if(!empty($id_nivel_aceptacion)){
					$cond	.= " AND id_nivel_aceptacion='$id_nivel_aceptacion'";
				}
				if(!empty($id_cobertura)){
					$cond	.= " AND id_cobertura='$id_cobertura'";
				}
				if(!empty($id_origen_db)){
					$cond	.= " AND id_origen_db='$id_origen_db'";
				}

				//----
				$sqlT = "SELECT * FROM ".tablaTarifario."
				 WHERE id_tipo_metodologia='$idTipoMetodologia' $cond";
				'<BR>'.$sqlT;
				$conT					= mysql_query($sqlT);
				while($camposT			= mysql_fetch_array($conT)){
					$precio				= $camposT["precio"];
					$operador_muestra	= $camposT["operador_muestra"];
					$valor_muestra		= $camposT["valor_muestra"];
					//echo '<BR>cond: '.$operador_muestra.$valor_muestra;
					if($operador_muestra=='<'){
						if($muestra < $valor_muestra){
							$vrUnitario	= $precio;
							//echo "<BR>menor que: $muestra < $valor_muestra";
						}
					}
					elseif($operador_muestra=='<='){
						if($muestra <= $valor_muestra){
							$vrUnitario	= $precio;
							//echo "<BR>menor que: $muestra < $valor_muestra";
						}
					}
					elseif($operador_muestra=='>'){
						if($muestra > $valor_muestra){
							$vrUnitario	= $precio;
							//echo "<BR>mayor que: $muestra > $valor_muestra";
						}
					}
					elseif($operador_muestra=='BETWEEN'){
						$arrayValor	= explode(',',$valor_muestra);
						if($muestra >= $arrayValor[0] && $muestra <= $arrayValor[1]){
							$vrUnitario	= $precio;
							//echo "<BR>BETWEEN: $muestra BETWEEN $arrayValor[0] AND $arrayValor[1]";
						}
					}
				}
				if($muestra*$vrUnitario){
					$vrTotal	= $muestra*$vrUnitario;
					$subTotal	+= $vrTotal;
				}
				//echo '<BR>vrUnitario: '.$vrUnitario;
			}//---- Si tiene definido muestra
			elseif(!empty($muestra) && !empty($precioUnitario)){
				$vrUnitario	= $precioUnitario;
				$vrTotal	= $muestra*$vrUnitario;
				$subTotal	+= $vrTotal;
			}
			$vbMuestra		= number_format($muestra);
			$vbVrUnitario	= number_format($vrUnitario);
			$vbVrTotal		= number_format($vrTotal);

			$idObjVrUnit		= nameObjVrUnitario.$id_row_segmento;
			$idObjVrTotalItem	= 'objVrTotalItem'.$id_row_segmento;

			$idObjCantidad		= nameObjVrUnitario.'cant'.$id_row_segmento;;
			$objCantidad	= "<INPUT type='text' name='".$idObjCantidad."' id='".$idObjCantidad."' value='$vbMuestra' class='txt' style='width:60px; text-align:center; border:none;' readonly='readonly' />";
			
			$fxVrUnit			= "fxInversion('$idObjCantidad','".porcentajeIVA."','$idObjVrUnit','$nomObjVrTotalItem','$idObjVrTotalItem','$idDivSubTotal','$idDivIVA','$idDivGranTotal')";

			$objPrecioUnit	= "<INPUT type='text' name='".$idObjVrUnit."' id='".$idObjVrUnit."' maxlength='10' value='$vbVrUnitario' class='txt' style='width:80px; text-align:right;' onkeypress='return esNumero(event);' onkeyup=\"$fxVrUnit;\" onchange=\"$fxVrUnit;\" />";			
			//----
			$objVrTotalItem	= "<INPUT type='text' name='".$nomObjVrTotalItem."' id='".$idObjVrTotalItem."' value='$vbVrTotal' style='width:90px; text-align:right; border:none;' readonly='readonly' />";			
			




			// segmentos
			/*$filasInversion		.= "
			 <TR>
			  <TD align='right' class='borderBR'><div class='padding5'>$contItems</TD>
			  <TD align='left' class='borderBR'><div class='padding5'>$nom_metodologia - $nom_segmento</div></TD>
			  <TD align='center' class='borderBR'><div class='padding5'>$objCantidad</div></TD>
			  <TD align='right' class='borderBR'><div class='padding5'>$objPrecioUnit <br /></div></TD>
			  <TD align='right' class='borderBR'><div class='padding5'>$objVrTotalItem</div></TD>
			 </TR>";
		}//---- consulta de segmentos de la metodología
	}
}*/

// NEW VALS SEGMENTO


$metodologias = $Metodologia->getPropMetodologias();

$contItems = 1;
foreach( $metodologias as $met ){
	$id_row_metodologia = $met['id_row_metodologia'];

	$segmentos = $Metodologia->getTableSegmentos($id_row_metodologia);

	foreach( $segmentos as $segmento ){
		$contItems++;
		$nomObjVrTotalItem	= nameObjVrTotalItem.'[]';
		$nom_metodologia = $met['nom_metodologia'];
		$nom_segmento = $segmento['nombre_segmento'];


		
		$vbMuestra = $segmento['total_segmento']; // OK :)

		$vbVrUnitario = $segmento['valor_unitario']; // OK :)
		$vbVrTotal = $vbMuestra * $vbVrUnitario;

		$subTotal+=$vbVrTotal;

		$vbVrUnitario = number_format($vbVrUnitario);
		$vbVrTotal = number_format($vbVrTotal);

		$idObjVrUnit = nameObjVrUnitario.$segmento['id_segmento'];
		$idObjVrTotalItem = 'objVrTotalItem'.$segmento['id_segmento'];

		$idObjCantidad	= nameObjVrUnitario.'cant'.$segmento['id_segmento'];
		$nameFieldSeg = 'valor_unit_seg['. $segmento['id_segmento'] .']';

		$objCantidad	= "<INPUT type='text' name='".$idObjCantidad."' id='".$idObjCantidad."' value='$vbMuestra' class='txt' style='width:60px; text-align:center; border:none;' readonly='readonly' />";

		$fxVrUnit		= "fxInversion('$idObjCantidad','".porcentajeIVA."','$idObjVrUnit','$nomObjVrTotalItem','$idObjVrTotalItem','$idDivSubTotal','$idDivIVA','$idDivGranTotal')";

		$objPrecioUnit	= "<INPUT type='text' name='".$nameFieldSeg."' id='".$idObjVrUnit."' maxlength='10' value='$vbVrUnitario' class='txt' style='width:80px; text-align:right;' onkeypress='return esNumero(event);' onkeyup=\"$fxVrUnit;\" onchange=\"$fxVrUnit;\" />";			
				//----
		$objVrTotalItem	= "<INPUT type='text' name='".$nomObjVrTotalItem."' id='".$idObjVrTotalItem."' value='$vbVrTotal' style='width:90px; text-align:right; border:none;' readonly='readonly' />";

		$filasInversion	.= "
			<TR>
			<TD align='right' class='borderBR'><div class='padding5'>$contItems</TD>
			<TD align='left' class='borderBR'><div class='padding5'>$nom_metodologia - $nom_segmento</div></TD>
			<TD align='center' class='borderBR'><div class='padding5'>$objCantidad</div></TD>
			<TD align='right' class='borderBR'><div class='padding5'>$objPrecioUnit <br /></div></TD>
			<TD align='right' class='borderBR'><div class='padding5'>$objVrTotalItem</div></TD>
		</TR>";
	} // fin each segmentos

}

//---- consulta los productos adicionales de la factura
 $sql = "SELECT *
 FROM ".tablaInversion."
  WHERE id_propuesta=$idPropuesta
   ORDER BY 1";
//echo '<BR>'.$sql;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	++$contItems;
	$id_producto		= $campos["id_producto"];
	$producto			= $campos["producto"];
	$cantidad			= $campos["cantidad"];
	$vr_unitario		= $campos["vr_unitario"];

	$vrTotal		= $cantidad*$vr_unitario;
	$subTotal		+= $vrTotal;
	$cantidad		= number_format($cantidad);
	$vr_unitario	= number_format($vr_unitario);
	$vbVrTotal		= number_format($vrTotal);

	$objIdProducto	= "<INPUT type='hidden' name='IdProducto[]' value='$id_producto'>";

	$nameObj	= 'productos[]';
	$idObj		= 'producto'.$contItems;
	$obj		= "<INPUT type='text' name='".$nameObj."' id='".$idObj."' value='$producto' class='txt' style='width:96%;' />";			

	//----
	$nameObjVrUnit		= 'vrUnit[]';
	$idObjVrUnit		= 'vrUnit'.$contItems;
	//----
	$idObjVrTotalItem	= 'vrTotalItem'.$contItems;
	//----
	$nameObjCant	= 'cantidad[]';
	$idObjCant		= 'item'.$contItems;
	$fxVrUnit		= "fxInversion('".$idObjCant."','".porcentajeIVA."','".$idObjVrUnit."','".$nomObjVrTotalItem."','".$idObjVrTotalItem."','".$idDivSubTotal."','".$idDivIVA."','".$idDivGranTotal."')";

	$objCantidad	= "<INPUT type='text' name='".$nameObjCant."' id='".$idObjCant."' maxlength='10' value='$cantidad' class='txt' style='width:60px; text-align:center;' onkeypress='return esNumero(event);' onkeyup=\"$fxVrUnit\" onchange=\"$fxVrUnit\" />";
	
	$objPrecioUnit	= "<INPUT type='text' name='".$nameObjVrUnit."' id='".$idObjVrUnit."' maxlength='10' value='$vr_unitario' class='txt' style='width:80px; text-align:right;' onkeypress='return esNumero(event);' onkeyup=\"$fxVrUnit\" onchange=\"$fxVrUnit\" />";
	//----
	$objVrTotalItem	= "<INPUT type='text' name='".$nomObjVrTotalItem."' id='".$idObjVrTotalItem."' value='$vbVrTotal' style='width:90px; text-align:right; border:none;' readonly='readonly' />";			
	
	// estos son los custom

	//----
	/*$filasInversion		.= "
	 <TR>
	  <TD align='right' class='borderBR'><div class='padding5'>$contItems</TD>
	  <TD align='left' class='borderBR'><div class='padding5'>$obj</div>$objIdProducto</TD>
	  <TD align='center' class='borderBR'><div class='padding5'>$objCantidad</div></TD>
	  <TD align='right' class='borderBR'><div class='padding5'>$objPrecioUnit</div></TD>
	  <TD align='right' class='borderBR'><div class='padding5'>$objVrTotalItem</div></TD>
	 </TR>";*/
}



//---- IVA
$vrIVA			= $subTotal * porcentajeIVA;
$vbVrIVA		= number_format($vrIVA);
//---- sub total
$vbSubTotal		= number_format($subTotal);
//---- gran total
$granTotal		= $subTotal + $vrIVA;
$vbGranTotal	= number_format($granTotal);
?>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left" style="display:none">
	 <TR>
	  <TD align="left" colspan="2" style="background-color:#FFE6CC; font-size:12px;">
	  <?php
	  echo "<OL>";
	  echo "<LI>";
	  echo utf8_decode("Considerar algunos sobre-costos de acuerdo a la ruralidad que se maneje, por ejemplo la ruralidad de Choco es mucho más costosa que la ruralidad del Cundinamarca en cuanto a desplazamientos.");
	  echo "</LI>";
	  echo "<LI>";
	  echo utf8_decode("Si hay solicitudes específicas del cliente en términos de formatos de entrega de base de datos, tipos de procesamiento adicionales, forma de captura de la información, entre otros, por favor tenerlo en cuenta en los costos.");
	  echo "</LI>";
	  echo "<LI>";
	  echo utf8_decode("Desapeguese del resultado... hay algo que se deba comunicar aquí que influencie tiempos, costos y otros que el cliente deba saber que afecte a CNC, al Clientes o que interfiera con el desarrollo del estudio y que no se haya mencionado.");
	  echo "</LI>";
	  ?>
	  </TD>
	 </TR>
    </TABLE>
	<INPUT type='hidden' name='contItems' id='contItems' value='<?=$contItems?>'>
	<TABLE id="tabla_inversion" width="60%" border="0" cellspacing="0" cellpadding="0" align="center" class="borderTL">
	 <TR>
	  <TD align='center' class='borderBR' colspan="5" style="background-color:#369;"><div class='padding5 colorBlanco'><B>INVERSION</B></div></TD>
	 </TR>
	 <TR>
	  <TD width='1%' align='right' class='bb divInstruccion'>&nbsp;</TD>
	  <TD align='left' class='borderBR divInstruccion'><div class='padding5'><B>Descripci&oacute;n</B></div></TD>
	  <TD width='5%' align='center' class='borderBR divInstruccion'><div class='padding5'><B>Cantidad</B></div></TD>
	  <TD width='5%' align='center' class='borderBR divInstruccion' nowrap="nowrap"><div class='padding5'><B>Valor Unit.</B></div></TD>
	  <TD width='5%' align='center' class='borderBR divInstruccion' nowrap="nowrap"><div class='padding5'><B>Valor Total</B></div></TD>
	 </TR>    	 
		<?=$filasInversion?>
	 <TR>
	  <TD align='right' class='bb'>&nbsp;</TD>
	  <TD align='left' class='borderBR' colspan="3"><div class='padding5'><B>Subtotal</B></div></TD>
      <TD align='right' class='borderBR'><div id="<?=$idDivSubTotal?>" class='padding5'><?=$vbSubTotal?></div></TD>
	 </TR>
	 <TR>
	  <TD align='right' class='bb'>&nbsp;</TD>
	  <TD align='left' class='borderBR' colspan="3"><div class='padding5'><B>IVA</B></div></TD>
      <TD align='right' class='borderBR'><div id="<?=$idDivIVA?>" class='padding5'><?=$vbVrIVA?></div></TD>
	 </TR>
	 <TR>
	  <TD align='right' class='bb'>&nbsp;</TD>
	  <TD align='left' class='borderBR' colspan="3"><div class='padding5'><B>TOTAL</B></div></TD>
      <TD align='right' class='borderBR' nowrap="nowrap"><div id="<?=$idDivGranTotal?>" class='padding5'><B>$ <?=$vbGranTotal?></B></div></TD>
	 </TR>
	</TABLE>
	<TABLE width="60%" border="0" cellspacing="0" cellpadding="0" align="center">
	 <TR>
	  <TD align='left'>
        <div style="padding:5px;"><a href="javascript:add_item_factura('<?=porcentajeIVA?>','<?=$nomObjVrTotalItem?>','<?=$idDivSubTotal?>','<?=$idDivIVA?>','<?=$idDivGranTotal?>');"><img src='/imagenes/ico-feedback.png' height='32' border='0' alt='Adicionar Ítem' title='Adicionar Ítem' /></a></div>
      </TD>
	 </TR>
	 <TR>
	  <TD align='left'>
		<div class='textLabel'><B>Forma de pago:</B><br />
        <TEXTAREA name='forma_pago' id='forma_pago' lang='1' class='borderBlue' style='width:99%; height:80px; padding:5px;'><?=$formaPago?></TEXTAREA></div>
      </TD>
	 </TR>
	 <tr>
	 	<td align="left" >
	 		<?php require_once dirname(__FILE__).'/met_warning.php'; ?>	
	 	</td>
	 </tr>
	</TABLE>
