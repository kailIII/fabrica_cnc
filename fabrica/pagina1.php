<?
//----
$sqlM = "SELECT * FROM ".tablaCiudad." ORDER BY 1";
//echo '<BR>'.$sqlM;
$optionElaboradaPor		= NULL;
$optionRevisadaPor		= NULL;
$conM					= mysql_query($sqlM);
while($camposM			= mysql_fetch_array($conM)){
	$id_ciudad			= $camposM["id_ciudad"];
	$nom_ciudad			= $camposM["nom_ciudad"];

	$optionElaboradaPor	.= "<OPTGROUP label='$nom_ciudad'>";
	$optionRevisadaPor	.= "<OPTGROUP label='$nom_ciudad'>";
	//----
	$sql = "SELECT * FROM ".tablaEquipo."
	 WHERE id_ciudad=$id_ciudad AND estado=1
	 ORDER BY nombre";
	//echo '<BR>'.$sql;
	$cont				= 0;
	$con				= mysql_query($sql);
	while($campos		= mysql_fetch_array($con)){
		++$cont;
		$id				= $campos["id"];
		$nombre			= $campos["nombre"];
		$muestra		= $campos["cargo"];
	
		$selected_e		= NULL;
		$selected_r		= NULL;


		$disabled_revisada='';
		$disabled_elaborada='';
		if($id==$elaborada_por){
			$selected_e	= "selected";
			$disabled_revisada = "disabled";
		}
		if($id==$revisada_por){
			$selected_r	= "selected";
			$disabled_elaborada = "disabled";
		}
		$optionElaboradaPor	.= "<OPTION $disabled_elaborada value='$id' $selected_e>$nombre</OPTION>";
		$optionRevisadaPor	.= "<OPTION $disabled_revisada value='$id' $selected_r>$nombre</OPTION>";
	}
	$optionElaboradaPor	.= "</OPTGROUP>";
	$optionRevisadaPor	.= "</OPTGROUP>";
}

//----
$sql = "SELECT * FROM ".tablaUnidadNegocio." ORDER BY 1";
//echo '<BR>'.$sql;
$optionUnidadNegocio	= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_unidad_negocio	= $campos["id_unidad_negocio"];
	$nom_unidad_negocio	= $campos["nom_unidad_negocio"];

	$selected_e		= NULL;
	if($id_unidad_negocio==$unidad_negocio){
		$selected_e	= "selected";
	}
	$optionUnidadNegocio	.= "<OPTION value='$id_unidad_negocio' $selected_e>$nom_unidad_negocio</OPTION>";
}


if( isset( $Propuesta ) ){
	$info_prop = $Propuesta->getProp();
}

?>
<!-- jquery library  -->
<script src="js/jquery-1.10.2.min.js" ></script>
<script src="js/gotopage.js?<?=time()?>" ></script>
<script src="js/page1.js?<?=time();?>" ></script>

<?php if( isset($_GET['gotopage']) ){ ?>
<input type="hidden" id="goTopage" value="2" >
<?php } ?>

	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	 <TR>
	  <TD width="5%" align='left' class="bb"><div class='padding5 textLabel'>T&iacute;tulo:</div></TD>
	  <TD width="95%" align='left' class="bb"><div class='padding5'><INPUT type="text" name="titulo" id="titulo" value="<?=$titulo?>" class="txt" style="width:350px;" /></div></TD>
	 </TR>
	 <TR>
	  <TD align='left' width="5%" colspan="2"><div class='padding5 textLabel'><B>Presentada a:</B> <input style="margin-left:15px;" type="text" name="empresa_cliente" id="empresa_cliente" value="<?=$info_prop['empresa_cliente']?>" > </div></TD>
	 </TR>

	

	 <TR>
	 	<td colspan="2" width="100%" >

	 		<div id="page1ClientsContainer">

	 			<?php if( ! isset( $idPropuesta ) ){ ?>
	 			<div class="clientBlock">
	 				<h4>Cliente 1</h4>
	 				<table>
	 					<tr>
	 						<td>Nombre:</td>
	 						<td><input type="text" name="cli_nombre[]" ></td>
	 					</tr>
	 					<!-- <tr>
	 						<td>Empresa:</td>
	 						<td><input type="text" name="cli_empresa[]" ></td>
	 					</tr> -->
	 					<tr>
	 						<td>Cargo:</td>
	 						<td><input type="text" name="cli_cargo[]" ></td>
	 					</tr>
	 					<tr>
	 						<td>Email:</td>
	 						<td><input type="text" name="cli_email[]" ></td>
	 					</tr>
	 					<tr>
	 						<td>Teléfono (PBX):</td>
	 						<td><input type="text" name="cli_telefono[]" ></td>
	 					</tr>
	 					<tr>
	 						<td>Celular:</td>
	 						<td><input type="text" name="cli_celular[]" ></td>
	 					</tr>
	 				</table>
	 			</div>
	 			<?php } else {

				foreach( $Propuesta->getPropClientes() as $key_cli => $cli ){ ?>
				<div class="clientBlock">
	 				<h4>Cliente <?=$key_cli+1?></h4>
	 				<table>
	 					<tr>
	 						<td>Nombre:</td>
	 						<td><input type="text" name="cli_nombre[]" value="<?=$cli['nombre']?>" ></td>
	 					</tr>
	 					<!-- <tr>
	 						<td>Empresa:</td>
	 						<td><input type="text" name="cli_empresa[]" value="<?=$cli['empresa']?>" ></td>
	 					</tr> -->
	 					<tr>
	 						<td>Cargo:</td>
	 						<td><input type="text" name="cli_cargo[]" value="<?=$cli['cargo']?>" ></td>
	 					</tr>
	 					<tr>
	 						<td>Email:</td>
	 						<td><input type="text" name="cli_email[]" value="<?=$cli['email']?>" ></td>
	 					</tr>
	 					<tr>
	 						<td>Teléfono (PBX):</td>
	 						<td><input type="text" name="cli_telefono[]" value="<?=$cli['telefono']?>" ></td>
	 					</tr>
	 					<tr>
	 						<td>Celular:</td>
	 						<td><input type="text" name="cli_celular[]" value="<?=$cli['celular']?>" ></td>
	 					</tr>
	 				</table>
	 			</div>
	 			<?php } // fin each
	 			} // fin else ?>
	 		</div>
	 	</td>
	 </TR>
	 
	 <tr>
	 	<td colspan="2" ><a href="javascript:void(0);" class="button" id="addContact" >Añadir Cliente</a></td>
	 </tr>

	 <TR>
	  <TD align='left' colspan="2"><IMG src='/imagenes/spacer.gif' width='1' height='10' border="0"></TD>
	 </TR>
	 <TR>
	  <TD align='left' class="bb" nowrap="nowrap"><div class='padding5 textLabel'><B>Elaborada por:</B></div></TD>
	  <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='elaborada_por' id='elaborada_por' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionElaboradaPor?>
		</SELECT>
	  </div></TD>
	 </TR>
	 <TR>
	  <TD align='left' class="bb" nowrap="nowrap"><div class='padding5 textLabel'><B>Revisada por:</B></div></TD>
	  <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='revisada_por' id='revisada_por' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionRevisadaPor?>
		</SELECT>
	  </div></TD>
	 </TR>
	 <TR>
	  <TD align='left' class="bb" nowrap="nowrap"><div class='padding5 textLabel'><B>Negocio:</B></div></TD>
	  <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='id_unidad_negocio' id='id_unidad_negocio' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionUnidadNegocio?>
		</SELECT>
	  </div></TD>
	 </TR>
	</TABLE>
