<?

$idPropuesta=$_GET["id"];
$vrDirEstudio=$_GET["vrstudio"];

include("../core/connection.php");
include("../core/libreria.php");

echo"<script type='text/javascript' src='scripts/library/js.js'></script> ";
echo "
<script type='text/javascript'>
function fxInversion(muestra,porcentajeIVA,idObjVrUnit,nomObjVrTotalItem,idObjVrTotalItem,idDivSubTotal,idDivIVA,idDivGranTotal){

	var frm		= document.formulario;

	var vrUnit	= document.getElementById(idObjVrUnit).value;

    //---- quitamos caracteres

    muestra	= muestra.toString().replace(/\./g, '');

    muestra	= muestra.toString().replace(/\,/g, '');

    vrUnit	= vrUnit.toString().replace(/\./g, '');

    vrUnit	= vrUnit.toString().replace(/\,/g, '');

	var vrTotalItem	= 0;

	if(parseFloat(muestra)>0){

		vrTotalItem	= parseFloat(muestra)*parseFloat(vrUnit);

	}

	vrUnit = formatNumber.new(vrUnit);

	document.getElementById(idObjVrUnit).value=vrUnit;

	vrTotalItem = formatNumber.new(vrTotalItem);

	document.getElementById(idObjVrTotalItem).value=vrTotalItem;



	var vrSubTotal	= 0;

	if(typeof frm[nomObjVrTotalItem] != 'undefined'){

		//alert('Entro');

		for (var w = 0, total = frm[nomObjVrTotalItem].length; w < total; w++){

			var valorObj	= frm[nomObjVrTotalItem][w].value;

			//---- quitamos caracteres

			valorObj	= valorObj.toString().replace(/\./g, '');

			valorObj	= valorObj.toString().replace(/\,/g, '');

//			alert('valorObj: '+valorObj);

//			var idObj_act	= frm[nomObjVrTotalItem][w].id;

			if(trimAll(valorObj).length > 0){

				if(parseFloat(valorObj)){

					vrSubTotal	+= parseFloat(valorObj);

				}

			}

		}

	}

	var vrIVA	= 0;

	if(parseFloat(vrSubTotal)){

		vrIVA	= Math.round(parseFloat(porcentajeIVA) * parseFloat(vrSubTotal),0);

	}

	var vrGranTotal	= Math.round((parseFloat(vrSubTotal)+parseFloat(vrIVA)),0);

	vrSubTotal = formatNumber.new(vrSubTotal);

	document.getElementById(idDivSubTotal).innerHTML = vrSubTotal;

	vrIVA = formatNumber.new(vrIVA);

	document.getElementById(idDivIVA).innerHTML = vrIVA;

	vrGranTotal = formatNumber.new(vrGranTotal, '$ ');

	document.getElementById(idDivGranTotal).innerHTML = '<B>'+vrGranTotal+'</B>';

	//alert('vrSubTotal: '+vrSubTotal);

// http://www.verteweb.com/2012/11/funcion-para-dar-formato-numeros-en.html

// http://www.antisacsor.com/articulo/10_98_dar-formato-a-numeros-en-javascript

}


var formatNumber = {

	separador: ',', // separador para los miles

	sepDecimal: '.', // separador para los decimales

	formatear:function (num){

		num +='';

		var splitStr = num.split('.');

		var splitLeft = splitStr[0];

		var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';

		var regx = /(\d+)(\d{3})/;

		while (regx.test(splitLeft)) {

			splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');

		}

		return this.simbol + splitLeft  +splitRight;

	},

	new:function(num, simbol){

		this.simbol = simbol ||'';

		return this.formatear(num);

	}

}



</script>";
if(empty($formaPago)){

	$sql = "SELECT * FROM ".tablaFormaPago;

	//echo '<BR>'.$sql;

	$con				= mysql_query($sql);

	while($campos		= mysql_fetch_array($con)){


		$formaPago		= $campos["forma_pago"];
	}

}



$idDivSubTotal	= 'divSubTotal';

$idDivIVA		= 'divIVA';

$idDivGranTotal	= 'divGranTotal';

$contItems		= 1;



$vbVrDirEstudio	= number_format($vrDirEstudio);



$nomObjVrTotalItem	= nameObjVrTotalItem.'[]';

$idObjVrUnit		= nameObjVrDirEstudio;

$idObjVrTotalItem	= 'objVrTotalItem'.$contItems;

$fxVrUnit			= "fxInversion('1','".porcentajeIVA."','$idObjVrUnit','$nomObjVrTotalItem','$idObjVrTotalItem','$idDivSubTotal','$idDivIVA','$idDivGranTotal')";



$objPrecioUnit	= "<INPUT type='text' name='".$idObjVrUnit."' id='".$idObjVrUnit."' maxlength='10' value='$vbVrDirEstudio' class='txt' style='width:80px; text-align:right;' onkeypress='return esNumero(event);' onkeyup=\"$fxVrUnit;\"  readonly='readonly' disabled />";			

//----

$objVrTotalItem	= "<INPUT type='text' name='".$nomObjVrTotalItem."' id='".$idObjVrTotalItem."' value='$vbVrDirEstudio' style='width:90px; text-align:right; border:none;' readonly='readonly' disabled />";			



$filasInversion	= "

     <TR>

      <TD align='right' class='borderBR'><div class='padding5'>$contItems</TD>

      <TD align='left' class='borderBR'><div class='padding5'>Direcci&oacute;n de estudios</div></TD>

      <TD align='center' class='borderBR'><div class='padding5'>1</div></TD>

      <TD align='right' class='borderBR'><div class='padding5'>$objPrecioUnit</div></TD>

      <TD align='right' class='borderBR'><div class='padding5'>$objVrTotalItem</div></TD>

     </TR>";



//---- consulta las metodologías de la propuesta

$sql = "SELECT *

 FROM ".tablaMetodologia." M INNER JOIN ".tablaMetodologiaRTA." R USING(id_metodologia)

  WHERE R.id_propuesta=$idPropuesta ORDER BY 1";

//echo '<BR>'.$sql;

$subTotal				= 0;

$con					= mysql_query($sql);

while($campos			= mysql_fetch_array($con)){

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

		//---- consulta los segmentos de la metodología

		$sqlR = "SELECT *

		 FROM ".tablaSegmentoMetodologiaRTA." R

		  WHERE R.id_row_metodologia=$idRowMetodologia

		   ORDER BY 1";

		//echo '<BR>'.$sqlR;

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

				//echo '<BR>'.$sqlT;

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

			$fxVrUnit			= "fxInversion('$muestra','".porcentajeIVA."','$idObjVrUnit','$nomObjVrTotalItem','$idObjVrTotalItem','$idDivSubTotal','$idDivIVA','$idDivGranTotal')";



			$objPrecioUnit	= "<INPUT type='text' name='".$idObjVrUnit."' id='".$idObjVrUnit."' maxlength='10' value='$vbVrUnitario' class='txt' style='width:80px; text-align:right;' onkeypress='return esNumero(event);' onkeyup=\"$fxVrUnit;\" onchange=\"$fxVrUnit;\" readonly='readonly' disabled/>";			

			//----

			$objVrTotalItem	= "<INPUT type='text' name='".$nomObjVrTotalItem."' id='".$idObjVrTotalItem."' value='$vbVrTotal' style='width:90px; text-align:right; border:none;' readonly='readonly' disabled/>";			

			$filasInversion		.= "

			 <TR>

			  <TD align='right' class='borderBR'><div class='padding5'>$contItems</TD>

			  <TD align='left' class='borderBR'><div class='padding5'>$nom_metodologia - $nom_segmento</div></TD>

			  <TD align='center' class='borderBR'><div class='padding5'>$vbMuestra</div></TD>

			  <TD align='right' class='borderBR'><div class='padding5'>$objPrecioUnit <br /></div></TD>

			  <TD align='right' class='borderBR'><div class='padding5'>$objVrTotalItem</div></TD>

			 </TR>";

		}//---- consulta de segmentos de la metodología

	}

}

$subTotal		+= $vrDirEstudio;

//---- IVA

$vrIVA			= $subTotal * porcentajeIVA;

$vbVrIVA		= number_format($vrIVA);

//---- sub total

$vbSubTotal		= number_format($subTotal);

//---- gran total

$granTotal		= $subTotal + $vrIVA;

$vbGranTotal	= number_format($granTotal);

?>
  <form name="formulario" id="formulario" method="post">
	<div  style="padding-top:5px;">

	<TABLE width="60%" border="0" cellspacing="0" cellpadding="0" align="center" class="borderTL">

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

	<br />

	<TABLE width="60%" border="0" cellspacing="0" cellpadding="0" align="center">

	 <TR>

	  <TD align='left'>

		<div class='textLabel'><B>Forma de pago:</B><br />

        <TEXTAREA name='forma_pago' id='forma_pago' lang='1' class='borderBlue' style='width:99%; height:80px; padding:5px;'><?=$formaPago?></TEXTAREA></div>

      </TD>

	 </TR>

	</TABLE>

    </div>

</form>