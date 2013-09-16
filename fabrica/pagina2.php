<?
//----
$sql = "SELECT * FROM ".tablaTiempoDedicado." ORDER BY 1";
//echo '<BR>'.$sql;
$optionTiempoDedicado	= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_tiempo_ded		= $campos["id_tiempo_ded"];
	$nom_tiempo_ded		= $campos["nom_tiempo_ded"];

	$selected_e		= NULL;
	if($id_tiempo_ded==$tiempo_ded){
		$selected_e	= "selected";
	}

	$optionTiempoDedicado.= "<OPTION value='$id_tiempo_ded' $selected_e>$nom_tiempo_ded</OPTION>";
}

$prop_info = $Propuesta->getProp();

?>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	 <TR>
	  <TD align="left" colspan="2" style="background-color:#FFE6CC;"><div style="padding:10px; font-size:14px;"><?php echo utf8_decode("El objetivo de esta hoja es captar y mantener el foco durante toda la realización de la propuesta en el cliente. Asegurar que la propuesta cumpla con los requerimientos del cliente y que el CNC pueda cumplir en todo sentido, con probabilidad de exceder las expectativas del cliente");?></div>
	  </TD>
	 </TR>
	 <TR>
	  <TD align="center" colspan="2">
		<TABLE width="98%" border="0" cellspacing="0" cellpadding="0" align="center" style="padding-top:10px;">

		 <TR>
		  <TD width="1%" align='left' class="bb divInstruccion">&nbsp;</TD>
		  <TD align='left' class="borderBR divInstruccion"><B>Idoneidad del CNC</B></TD>
		  <TD width="20%" align='center' class="borderBR divInstruccion"><div class='padding5'>SI</div></TD>
		  <TD width="20%" align='center' class="bb divInstruccion"><div class='padding5'>NO</div></TD>
		 </TR>
		
		<?php foreach( $Contenidos->getIdoneidades() as $idoneidad ){ ?>
		<tr>
			<td align='left' class="bb"><div class='padding5 textLabel'><IMG src='/imagenes/yes.png' height='16' border="0"></div></td>
			<td align='left' class="borderBR"><div class='padding5 textLabel'><?=$idoneidad['nombre']?></div></td>
			<td align='center' class="borderBR"><div class='padding5'><INPUT type="radio" name="idoneidad[<?=$idoneidad['id_idoneidad']?>]"  lang="1" <?php if( $Propuesta->hasIdoneidad($idoneidad['id_idoneidad']) ){ ?> checked <?php } ?> value="1" /></div></td>
			<td align='center' class="bb"><div class='padding5'><INPUT type="radio" name="idoneidad[<?=$idoneidad['id_idoneidad']?>]"  lang="1" value="0" <?php if( ! $Propuesta->hasIdoneidad($idoneidad['id_idoneidad']) ){ ?> checked <?php } ?> /></div></td>
		</tr>
		<?php } ?>
		</TABLE>
	  </TD>
	 </TR>
	 <TR>
	  <TD align='left' class="" colspan="2"><div class='padding5 textLabel'><br /><B>Parafrasee o escriba el verbatim de como el cliente expres&oacute; su necesidad u otro que considere conveniente mencionar:</B><br />
        <?=$instruccionBullet?><br />
	    <TEXTAREA name='requerimiento_cliente' id='requerimiento_cliente' lang='1' title='' class='borderBlue' style='width:99%; height:60px; padding:5px;'><?=$requerimiento_cliente?></TEXTAREA></div></TD>
	 </TR>
	 <TR>
	  <TD align='left' width="20%" class="bb" nowrap="nowrap"><div class='padding5 textLabel'><B>Direcci&oacute;n de estudio requiere tiempo de dedicaci&oacute;n:</B></div></TD>
	  <TD align='left' class="bb"><div class='padding5'>
		<SELECT name='c_tiempo_ded' id='c_tiempo_ded' lang='1' title='' style="padding:5px;">
		 <OPTION value='' selected>Seleccione...</OPTION>
		 <?=$optionTiempoDedicado?>
		</SELECT>
	  </div></TD>
	 </TR>

	 <tr>
	 	<td align='left' width="20%" class="bb" nowrap="nowrap" ><div class='padding5 textLabel'><b>Tipo</b></div></td>
	 	<td>
	 		<div class='padding5'>
		 		<select name="tipo_prop" style="padding:5px;" >
		 		<option value="">Seleccione...</option>
		 		<?php foreach( $Contenidos->getTipoProp() as $tipo_prop ){ ?>
		 		<option <?php if( $prop_info['id_tipo_prop'] == $tipo_prop['id_tipo_prop'] ){ ?> selected <?php } ?> value="<?=$tipo_prop['id_tipo_prop']?>"><?=$tipo_prop['descripcion']?></option>
		 		<?php } ?>
		 		</select>
		 	</div>
	 	</td>
	 </tr>

	</TABLE>
