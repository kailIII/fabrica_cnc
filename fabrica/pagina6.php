<?php

//---- consulta la forma de pago
if(empty($formaPago)){
	$sql = "SELECT * FROM " . tablaFormaPago;
	//echo '<BR>'.$sql;
	$con				= mysql_query($sql);
	while($campos		= mysql_fetch_array($con)){
		$formaPago		= $campos["forma_pago"];
	}
}

$info_prop = $Propuesta->getProp();


$idDivSubTotal	= 'divSubTotal';
$idDivIVA		= 'divIVA';
$idDivGranTotal	= 'divGranTotal';
$contItems		= 1;

$vbVrDirEstudio	= number_format($vrDirEstudio);

$nomObjVrTotalItem	= nameObjVrTotalItem.'[]';
$idObjVrUnit		= nameObjVrDirEstudio;
$idObjVrTotalItem	= 'objVrTotalItem'.$contItems;
$idObjCantidad		= nameObjVrDirEstudio.'cant';
$objCantidad	= "<input type='text' name='" . $idObjCantidad . "' id='" . $idObjCantidad . "' value='1' class='txt' style='width:60px; text-align:center; border:none;' readonly='readonly' />";
			
$fxVrUnit			= "fxInversion('$idObjCantidad','" . porcentajeIVA . "','$idObjVrUnit','$nomObjVrTotalItem','$idObjVrTotalItem','$idDivSubTotal','$idDivIVA','$idDivGranTotal')";

$objPrecioUnit	= "<input type='text' name='" . $idObjVrUnit . "' id='" . $idObjVrUnit . "' maxlength='10' value='$vbVrDirEstudio' class='txt' style='width:80px; text-align:right;' onkeypress='return esNumero(event);' onkeyup=\"$fxVrUnit;\" />";			
//----
$objVrTotalItem	= "<input type='text' name='" . $nomObjVrTotalItem . "' id='" . $idObjVrTotalItem . "' value='$vbVrDirEstudio' style='width:90px; text-align:right; border:none;' readonly='readonly' />";


$filasInversion	= "
     <tr>
      <td align='right' class='borderBR'><div class='padding5'>$contItems</td>
      <td align='left' class='borderBR'><div class='padding5'>Direcci&oacute;n de estudios</div></td>
      <td align='center' class='borderBR'><div class='padding5'>$objCantidad</div></td>
      <td align='right' class='borderBR'><div class='padding5'>$objPrecioUnit</div></td>
      <td align='right' class='borderBR'><div class='padding5'>$objVrTotalItem</div></td>
     </tr>";




$idDivSubTotal_2	= 'divSubTotal_2';
$idDivIVA_2			= 'divIVA_2';
$idDivGranTotal_2	= 'divGranTotal_2';
$contItems_2		= 1;

$vbVrDirEstudio		= number_format( $vrDirEstudio_2 );

$nomObjVrTotalItem_2= nameObjVrTotalItem 	. '_2[]';
$idObjVrUnit_2		= nameObjVrDirEstudio 	. "_2";
$idObjVrTotalItem_2	= 'objVrTotalItem_2' 	. $contItems;
$idObjCantidad_2	= nameObjVrDirEstudio 	. '_2cant';
$objCantidad_2		= " <input type='text' " . 
						" name='" . $idObjCantidad_2 . "' " . 
						" id='" . $idObjCantidad_2 . "' " . 
						" value='1' " .
						" class='txt' " .
						" style=' width:60px; 
								text-align:center; 
								border:none;' " . 
						" readonly='readonly' />";

			
$fxVrUnit			= "fxInversion( '$idObjCantidad_2' , " . 
									" '" . porcentajeIVA . "' , " . 
									" '$idObjVrUnit_2' , " . 
									" '$nomObjVrTotalItem_2' , " . 
									" '$idObjVrTotalItem_2' , " . 
									" '$idDivSubTotal_2' , " . 
									" '$idDivIVA_2' , " . 
									" '$idDivGranTotal_2' )";

$objPrecioUnit_2	= "<input type='text' name='" . $idObjVrUnit_2 . "' id='" . $idObjVrUnit_2 . "' maxlength='10' value='$vbVrDirEstudio' class='txt' style='width:80px; text-align:right;' onkeypress='return esNumero(event);' onkeyup=\"$fxVrUnit;\" />";			
$objVrTotalItem_2	= "<input type='text' name='" . $nomObjVrTotalItem_2 . "' id='" . $idObjVrTotalItem_2 . "' value='$vbVrDirEstudio' style='width:90px; text-align:right; border:none;' readonly='readonly' />";			


$filasInversion_2	= " <tr>
      <td align='right' class='borderBR'><div class='padding5'>$contItems_2</td>
      <td align='left' class='borderBR'><div class='padding5'>Direcci&oacute;n de estudios</div></td>
      <td align='center' class='borderBR'><div class='padding5'>$objCantidad_2</div></td>
      <td align='right' class='borderBR'><div class='padding5'>$objPrecioUnit_2</div></td>
      <td align='right' class='borderBR'><div class='padding5'>$objVrTotalItem_2</div></td>
     </tr> ";


//---- consulta las metodologías de la propuesta
 $sql = "SELECT *
 FROM " . tablaMetodologia . " M INNER JOIN " . tablaMetodologiaRTA . " R USING(id_metodologia)
  WHERE R.id_propuesta=$idPropuesta
   ORDER BY 1";
//    echo '<BR>'.$sql;

$subTotal_2 = 0;
 
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
		 FROM " . tablaSegmentoMetodologiaRTA . " R
		  WHERE R.id_row_metodologia=$idRowMetodologia
		   ORDER BY 1";
		    // echo '<BR>'.$sqlR;
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
				$sqlT = "SELECT * FROM " . tablaTarifario . "
				 WHERE id_tipo_metodologia='$idTipoMetodologia' $cond";
				// echo '<BR>'.$sqlT;
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
			$objCantidad	= "<input type='text' name='" . $idObjCantidad . "' id='" . $idObjCantidad . "' value='$vbMuestra' class='txt' style='width:60px; text-align:center; border:none;' readonly='readonly' />";
			
			$fxVrUnit			= "fxInversion('$idObjCantidad','" . porcentajeIVA . "','$idObjVrUnit','$nomObjVrTotalItem','$idObjVrTotalItem','$idDivSubTotal','$idDivIVA','$idDivGranTotal')";

			$objPrecioUnit	= "<input type='text' name='" . $idObjVrUnit . "' id='" . $idObjVrUnit . "' maxlength='10' value='$vbVrUnitario' class='txt' style='width:80px; text-align:right;' onkeypress='return esNumero(event);' onkeyup=\"$fxVrUnit;\" onchange=\"$fxVrUnit;\" />";			
			//----
			$objVrTotalItem	= "<input type='text' name='" . $nomObjVrTotalItem . "' id='" . $idObjVrTotalItem . "' value='$vbVrTotal' style='width:90px; text-align:right; border:none;' readonly='readonly' />";			
			$filasInversion		.= "
			 <tr>
			  <td align='right' class='borderBR'><div class='padding5'>$contItems</td>
			  <td align='left' class='borderBR'><div class='padding5'>$nom_metodologia - $nom_segmento</div></td>
			  <td align='center' class='borderBR'><div class='padding5'>$objCantidad</div></td>
			  <td align='right' class='borderBR'><div class='padding5'>$objPrecioUnit <br /></div></td>
			  <td align='right' class='borderBR'><div class='padding5'>$objVrTotalItem</div></td>
			 </tr>";
		}//---- consulta de segmentos de la metodología
	}
}

//---- consulta los productos adicionales de la factura
 $sql = "SELECT *
 FROM " . tablaInversion . "
  WHERE id_propuesta=$idPropuesta
   ORDER BY 1";

$con				= mysql_query($sql);
$mostrar_tabla_2 	= false;

while($campos = mysql_fetch_array( $con ) ){
	
	++$contItems;
	$id_producto		= $campos["id_producto"];
	$producto			= $campos["producto"];
	$cantidad			= $campos["cantidad"];
	$vr_unitario		= $campos["vr_unitario"];
	$tabla 				= $campos["tabla"];
	
	if( $tabla == "2" ){
		
		$mostrar_tabla_2 = true; 
		$vrTotal_2 		= $cantidad * $vr_unitario;
		$subTotal_2 	+= $vrTotal_2;
		$cantidad 		= number_format( $cantidad );
		$vr_unitario 	= number_format( $vr_unitario );
		$vbVrTotal_2 	= number_format( $vrTotal_2 );
		
		$idObjVrTotalItem	= 'vrTotalItem_2_'.$contItems;
		
		$objIdProducto	= "<input type='hidden' name='IdProducto_2[]' value='$id_producto'>";
		$objVrTotalItem	= "<input type='text' name='" . $nomObjVrTotalItem_2 . "' id='" . $idObjVrTotalItem . "' value='$vbVrTotal_2' style='width:90px; text-align:right; border:none;' readonly='readonly' />";
		
		$nameObj	= 'productos_2[]';
		$idObj		= 'producto_2'.$contItems;
		$obj		= "<input type='text' name='" . $nameObj . "' id='" . $idObj . "' value='$producto' class='txt' style='width:96%;' />";

		$nameObjVrUnit		= 'vrUnit_2[]';
		$idObjVrUnit		= 'vrUnit_2'.$contItems;


		$nameObjCant	= 'cantidad_2[]';
		$idObjCant		= 'item_2'.$contItems;
		$fxVrUnit		= "fxInversion('" . $idObjCant . "','" . porcentajeIVA . "','" . $idObjVrUnit . "','" . $nomObjVrTotalItem_2 . "','" . $idObjVrTotalItem . "','" . $idDivSubTotal . "_2','" . $idDivIVA . "_2','" . $idDivGranTotal . "_2')";
	
		$objCantidad	= "<input type='text' name='" . $nameObjCant . "' id='" . $idObjCant . "' maxlength='10' value='$cantidad' class='txt' style='width:60px; text-align:center;' onkeypress='return esNumero(event);' onkeyup=\"$fxVrUnit\" onchange=\"$fxVrUnit\" />";
		
		$objTabla		= "<input type='hidden' name='tabla_2[]' value='$tabla' />";
		
		$objPrecioUnit	= "<input type='text' name='" . $nameObjVrUnit . "' id='" . $idObjVrUnit . "' maxlength='10' value='$vr_unitario' class='txt' style='width:80px; text-align:right;' onkeypress='return esNumero(event);' onkeyup=\"$fxVrUnit\" onchange=\"$fxVrUnit\" />";
		
		
		
	} else {
		
		$vrTotal 		= $cantidad * $vr_unitario;
		$subTotal 		+= $vrTotal;
		$cantidad 		= number_format( $cantidad );
		$vr_unitario 	= number_format( $vr_unitario );
		$vbVrTotal 		= number_format( $vrTotal );
		
		$idObjVrTotalItem	= 'vrTotalItem'.$contItems;

		$objIdProducto	= "<input type='hidden' name='IdProducto[]' value='$id_producto'>";
		$objVrTotalItem	= "<input type='text' name='" . $nomObjVrTotalItem . "' id='" . $idObjVrTotalItem . "' value='$vbVrTotal' style='width:90px; text-align:right; border:none;' readonly='readonly' />";
		
		$nameObj	= 'productos[]';
		$idObj		= 'producto'.$contItems;
		$obj		= "<input type='text' name='" . $nameObj . "' id='" . $idObj . "' value='$producto' class='txt' style='width:96%;' />";
		
		$nameObjVrUnit		= 'vrUnit[]';
		$idObjVrUnit		= 'vrUnit'.$contItems;

		

		$nameObjCant	= 'cantidad[]';
		$idObjCant		= 'item'.$contItems;
		$fxVrUnit		= "fxInversion('" . $idObjCant . "','" . porcentajeIVA . "','" . $idObjVrUnit . "','" . $nomObjVrTotalItem . "','" . $idObjVrTotalItem . "','" . $idDivSubTotal . "','" . $idDivIVA . "','" . $idDivGranTotal . "')";
	
		$objCantidad	= "<input type='text' name='" . $nameObjCant . "' id='" . $idObjCant . "' maxlength='10' value='$cantidad' class='txt' style='width:60px; text-align:center;' onkeypress='return esNumero(event);' onkeyup=\"$fxVrUnit\" onchange=\"$fxVrUnit\" />";
		
		$objTabla		= "<input type='hidden' name='tabla[]' value='$tabla' />";
		
		$objPrecioUnit	= "<input type='text' name='" . $nameObjVrUnit . "' id='" . $idObjVrUnit . "' maxlength='10' value='$vr_unitario' class='txt' style='width:80px; text-align:right;' onkeypress='return esNumero(event);' onkeyup=\"$fxVrUnit\" onchange=\"$fxVrUnit\" />";
	
		
	} 
	
	
	if( $tabla != "2" ){
		
		$filasInversion	.= " 
			<tr> 
				<td align='right' class='borderBR'><div class='padding5'>$contItems $objTabla </td> 
				<td align='left' class='borderBR'><div class='padding5'>$obj</div>$objIdProducto</td> 
				<td align='center' class='borderBR'><div class='padding5'>$objCantidad</div></td> 
				<td align='right' class='borderBR'><div class='padding5'>$objPrecioUnit</div></td> 
				<td align='right' class='borderBR'><div class='padding5'>$objVrTotalItem</div></td> 
			</tr>";
		
	}else{
		$filasInversion_2	.= " 
			<tr> 
				<td align='right' class='borderBR'><div class='padding5'>$contItems $objTabla </td> 
				<td align='left' class='borderBR'><div class='padding5'>$obj</div>$objIdProducto</td> 
				<td align='center' class='borderBR'><div class='padding5'>$objCantidad</div></td> 
				<td align='right' class='borderBR'><div class='padding5'>$objPrecioUnit</div></td> 
				<td align='right' class='borderBR'><div class='padding5'>$objVrTotalItem</div></td> 
			</tr>";
	}
}



$subTotal		+= $vrDirEstudio;
$subTotal_2 	+= $vrDirEstudio_2;

//---- IVA
$vrIVA			= $subTotal * porcentajeIVA;
$vbVrIVA		= number_format( $vrIVA );

$vrIVA_2		= $subTotal_2 * porcentajeIVA;
$vbVrIVA_2		= number_format( $vrIVA_2 );

//---- sub total
$vbSubTotal		= number_format($subTotal);

//---- gran total
$granTotal		= $subTotal + $vrIVA;
$granTotal_2	= $subTotal_2 + $vrIVA_2;
$vbGranTotal	= number_format( $granTotal );


$vrIVA			= $subTotal_2 * porcentajeIVA;
$vbVrIVA_2		= number_format( $vrIVA );
$granTotal		= $subTotal_2 + $vrIVA;
$vbSubTotal_2 	= number_format( $subTotal_2 );
$vbGranTotal_2 	= number_format( $granTotal_2 );

?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="left" style="display:none">
	 <tr>
	  <td align="left" colspan="2" style="background-color:#FFE6CC; font-size:12px;">
	  <?php
	  echo "<OL>";
	  echo "<LI>";
	  echo utf8_decode("Considerar algunos sobre-costos de acuerdo a la ruralidad que se maneje, por ejemplo la ruralidad de Choco es mucho más costosa que la ruralidad del Cundinamarca en cuanto a desplazamientos." );
	  echo "</LI>";
	  echo "<LI>";
	  echo utf8_decode("Si hay solicitudes específicas del cliente en términos de formatos de entrega de base de datos, tipos de procesamiento adicionales, forma de captura de la información, entre otros, por favor tenerlo en cuenta en los costos." );
	  echo "</LI>";
	  echo "<LI>";
	  echo utf8_decode("Desapeguese del resultado... hay algo que se deba comunicar aquí que influencie tiempos, costos y otros que el cliente deba saber que afecte a CNC, al Clientes o que interfiera con el desarrollo del estudio y que no se haya mencionado." );
	  echo "</LI>";
	  ?>
	  </td>
	 </tr>
    </table>
	<input type='hidden' name='contItems' id='contItems' value='<?php echo $contItems?>'>
	<table id="tabla_inversion" width="60%" border="0" cellspacing="0" cellpadding="0" align="center" class="borderTL">
	 <tr>
	  <td align='center' class='borderBR' colspan="5" style="background-color:#369;"><div class='padding5 colorBlanco'><B>INVERSION</B></div></td>
	 </tr>
	 <tr>
	  <td width='1%' align='right' class='bb divInstruccion'>&nbsp;</td>
	  <td align='left' class='borderBR divInstruccion'><div class='padding5'><B>Descripci&oacute;n</B></div></td>
	  <td width='5%' align='center' class='borderBR divInstruccion'><div class='padding5'><B>Cantidad</B></div></td>
	  <td width='5%' align='center' class='borderBR divInstruccion' nowrap="nowrap"><div class='padding5'><B>Valor Unit.</B></div></td>
	  <td width='5%' align='center' class='borderBR divInstruccion' nowrap="nowrap"><div class='padding5'><B>Valor Total</B></div></td>
	 </tr>
     <?php echo $filasInversion?>
	 <tr>
	  <td align='right' class='bb'>&nbsp;</td>
	  <td align='left' class='borderBR' colspan="3"><div class='padding5'><B>Subtotal</B></div></td>
      <td align='right' class='borderBR'><div id="<?php echo $idDivSubTotal?>" class='padding5'><?php echo $vbSubTotal?></div></td>
	 </tr>
	 <tr>
	  <td align='right' class='bb'>&nbsp;</td>
	  <td align='left' class='borderBR' colspan="3"><div class='padding5'><B>IVA</B></div></td>
      <td align='right' class='borderBR'><div id="<?php echo $idDivIVA?>" class='padding5'><?php echo $vbVrIVA?></div></td>
	 </tr>
	 <tr>
	  <td align='right' class='bb'>&nbsp;</td>
	  <td align='left' class='borderBR' colspan="3"><div class='padding5'><B>TOTAL</B></div></td>
      <td align='right' class='borderBR' nowrap="nowrap"><div id="<?php echo $idDivGranTotal?>" class='padding5'><B>$ <?php echo $vbGranTotal?></B></div></td>
	 </tr> 
	 
	</table>
	
	<table width="60%" border="0" cellspacing="0" cellpadding="0" align="center">
	 <tr>
	  <td align='left'>
        <div style="padding:5px; display: inline;"><a href="javascript:add_item_factura('<?php echo porcentajeIVA?>','<?php echo $nomObjVrTotalItem?>','<?php echo $idDivSubTotal?>','<?php echo $idDivIVA?>','<?php echo $idDivGranTotal?>','');"><img src='/imagenes/ico-feedback.png' height='32' border='0' alt='Adicionar Item' title='Adicionar Item' /></a></div>
        <?php if( $mostrar_tabla_2 === false ): ?>
        	<div style="padding:5px; display: inline;"><a href="javascript:add_table_factura( 'div_tabla_inversion2' );"><img src='/imagenes/new_table.png' height='32' border='0' alt='Adicionar Tabla Inversion' title='Adicionar Tabla Inversion' /></a></div>
        <?php endif ?>
      </td>
	 </tr>
	</table>
	
	<div id="div_tabla_inversion2" <?php if( $mostrar_tabla_2 === false ) : ?>style="display: none; visibility: hidden; " <?php endif?> >
		<table id="tabla_inversion2" width="60%" border="0" cellspacing="0" cellpadding="0" align="center" class="borderTL" >
			<tr> 
				<td align='center' class='borderBR' colspan="5" style="background-color:#369;"><div class='padding5 colorBlanco'><b>INVERSION 2</b></div></td> 
			</tr>
			<tr> 
				<td width='1%' align='right' class='bb divInstruccion'>&nbsp;</td> 
				<td align='left' class='borderBR divInstruccion'><div class='padding5'><b>Descripci&oacute;n</b></div></td> 
				<td width='5%' align='center' class='borderBR divInstruccion'><div class='padding5'><b>Cantidad</b></div></td> 
				<td width='5%' align='center' class='borderBR divInstruccion' nowrap="nowrap"><div class='padding5'><b>Valor Unit.</b></div></td> 
				<td width='5%' align='center' class='borderBR divInstruccion' nowrap="nowrap"><div class='padding5'><b>Valor Total</b></div></td> 
			</tr> 
			<?php echo $filasInversion_2 ?> 
			
			<tr> 
				<td align='right' class='bb'>&nbsp;</td> 
				<td align='left' class='borderBR' colspan="3"><div class='padding5'><b>Subtotal</b></div></td> 
				<td align='right' class='borderBR'><div id="<?php echo $idDivSubTotal_2 ?>" class='padding5'><?php echo $vbSubTotal_2 ?></div></td> 
			</tr> 
			<tr> 
				<td align='right' class='bb'>&nbsp;</td> 
				<td align='left' class='borderBR' colspan="3"><div class='padding5'><b>IVA</b></div></td> 
				<td align='right' class='borderBR'><div id="<?php echo $idDivIVA_2 ?>" class='padding5'><?php echo $vbVrIVA_2 ?></div></td> 
			</tr> 
			<tr> 
				<td align='right' class='bb'>&nbsp;</td> 
				<td align='left' class='borderBR' colspan="3"><div class='padding5'><b>TOTAL</b></div></td> 
				<td align='right' class='borderBR' nowrap="nowrap"><div id="<?php echo $idDivGranTotal_2 ?>" class='padding5'><b>$ <?php echo $vbGranTotal_2 ?></b></div></td> 
			</tr> 
			
		</table>
		
		<table width="60%" border="0" cellspacing="0" cellpadding="0" align="center"> 
			<tr> 
				<td align='left'> 
					<div style="padding:5px; display: inline;"><a href="javascript:add_item_factura('<?php echo porcentajeIVA?>','<?php echo $nomObjVrTotalItem_2?>','<?php echo $idDivSubTotal_2?>','<?php echo $idDivIVA_2?>','<?php echo $idDivGranTotal_2?>',2);"><img src='/imagenes/ico-feedback.png' height='32' border='0' alt='Adicionar Item' title='Adicionar Item' /></a></div> 
				</td> 
			</tr> 
			</table>
	
	
	</div>
	
	<table width="60%" border="0" cellspacing="0" cellpadding="0" align="center">
	 <tr>
	  <td align='left'>
		<div class='textLabel'><B>Forma de pago:</B><br />
        <textarea name='forma_pago' id='forma_pago' lang='1' class='borderBlue' style='width:99%; height:80px; padding:5px;'><?php echo $formaPago?></textarea></div>
      </td>
	 </tr>

	 <tr>
	  <td align='left'>
		<div class='textLabel'><B>Validez de la propuesta:</B><br />
        <textarea name='validez_propuesta' lang='1' class='borderBlue' style='width:99%; height:80px; padding:5px;'><?php echo $info_prop['validez_propuesta']?></textarea></div>
      </td>
	 </tr>

	 <tr>
	 	<td align="left" >
	 		<?php require_once dirname(__FILE__).'/met_warning.php'; ?>	
	 	</td>
	 </tr>
	</table>
