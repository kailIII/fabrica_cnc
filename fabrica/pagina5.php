<?
//----
include("data/sql_tarifario.php");

require_once dirname(__FILE__).'/classes/class.Metodologia.php';
$Metodologia = new Metodologia( $idPropuesta );

// $Metodologia->makeMigration();

$idMetodologia		= $_POST['id_metodologia'];
$idRowMetodologia	= $_POST['idRowMetodologia']; // ---- identificador del registro de cada metodologia por propuesta
//echo '<BR>idRowMetodologia: '.$idRowMetodologia;

//----
$sqlM = "SELECT * FROM ".tablaTipoMetodologia." where id_tipo_metodologia <4 ORDER BY 1";
//echo '<BR>'.$sqlM;
$optionMetodologia			= NULL;
$contMetodologias			= 0;
$conM						= mysql_query($sqlM);
while($camposM				= mysql_fetch_array($conM)){
	$id_tipo_metodologia	= $camposM["id_tipo_metodologia"];
	$nom_tipo_metodologia	= $camposM["nom_tipo_metodologia"];

	$optionMetodologia		.= "<OPTGROUP label='$nom_tipo_metodologia'>";
	
	$sql = "SELECT * FROM ".tablaMetodologia." WHERE id_tipo_metodologia=$id_tipo_metodologia ORDER BY 1";
	//echo '<BR>'.$sql;
	$con					= mysql_query($sql);
	while($campos			= mysql_fetch_array($con)){
		$id_metodologia		= $campos["id_metodologia"];
		$nom_metodologia	= $campos["nom_metodologia"];

		$selected_e		= NULL;
		if($id_metodologia==$idMetodologia){
//			$selected_e	= "selected";
		}
		$optionMetodologia	.= "<OPTION value='$id_metodologia' $selected_e>$nom_metodologia</OPTION>";
	}
	$optionMetodologia	.= "</OPTGROUP>";
}
if(!empty($idMetodologia)){
	//---- consulta el tipo de metodología seleccionada
	$sql = "SELECT * FROM ".tablaMetodologia." WHERE id_metodologia=$idMetodologia";
	//echo '<BR>'.$sql;
	$nom_metodologia		= NULL;
	$con					= mysql_query($sql);
	while($campos			= mysql_fetch_array($con)){
		$idTipoMetodologia	= $campos["id_tipo_metodologia"];
		$nomMetodologia		= $campos["nom_metodologia"];
	}

	$sql = "INSERT INTO ".tablaMetodologiaRTA." (id_propuesta,id_metodologia)
	 VALUES (".$idPropuesta.",'$idMetodologia')";
	//echo '<BR>'.$sql;
//	$result	= eSQL($sql);
	if(mysql_query($sql)){
		$idRowMetodologia	= mysql_insert_id();
		//---- adiciona el primer segmento
		$sqlSeg = "INSERT INTO ".tablaSegmentoMetodologiaRTA." (id_propuesta,
		id_row_metodologia,
		id_tipo_metodologia,
		id_metodologia)
		 VALUES (".$idPropuesta.",
		 '$idRowMetodologia',
		 '$idTipoMetodologia',
		 '$idMetodologia')";
		//echo '<BR>'.$sqlSeg;
		if(mysql_query($sqlSeg)){}
	}
	else{
		echo "<div style='color:#990000'>Atención!!! Error al guardar la información, por favor intente nuevamente</div>".mysql_error();
	}
}
// ---- nuevo segmento
$id_row_metodologia_new_seg		= $_POST['id_row_metodologia_new_seg'];
if(!empty($id_row_metodologia_new_seg)){
	//---- consulta el tipo de metodología seleccionada
	$sql = "SELECT A.id_metodologia,A.id_tipo_metodologia,B.id_row_metodologia
	 FROM ".tablaMetodologia." A INNER JOIN ".tablaMetodologiaRTA." B USING(id_metodologia)
	 WHERE id_propuesta = ".$idPropuesta." AND id_row_metodologia=$id_row_metodologia_new_seg";
	//echo '<BR>'.$sql;
	$con					= mysql_query($sql);
	while($campos			= mysql_fetch_array($con)){
		$idTipoMetodologia	= $campos["id_tipo_metodologia"];
		$idRowMetodologia	= $campos["id_row_metodologia"];
		$idMetodologia		= $campos["id_metodologia"];

		//---- adiciona el primer segmento
		$sqlSeg = "INSERT INTO ".tablaSegmentoMetodologiaRTA." (id_propuesta,
		id_row_metodologia,
		id_tipo_metodologia,
		id_metodologia)
		 VALUES (".$idPropuesta.",
		 '$idRowMetodologia',
		 '$idTipoMetodologia',
		 '$idMetodologia')";
		//echo '<BR>'.$sqlSeg;
		if(mysql_query($sqlSeg)){}
		else{
			echo "<div style='color:#990000'>Atención!!! Error al guardar el segmento</div>".mysql_error();
		}
	}
}
?>
<INPUT type='hidden' name='idRowMetodologiaDelete' id='idRowMetodologiaDelete' value=''>
<INPUT type='hidden' name='id_row_metodologia_new_seg' id='id_row_metodologia_new_seg' value=''>
<INPUT type='hidden' name='id_new_metodologia' id='id_new_metodologia' value=''>
	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">
	 <TR>
	  <TD align='left' class="bb"><div class='padding5 textLabel'><B>Introducción a la Metodolog&iacute;a:</B><br />
      <?=$instruccionBullet?>
      <TEXTAREA name='introduccion_met' id='introduccion_met' lang='1' class='borderBlue' style='width:99%; height:80px; padding:5px;'><?=$introduccion_met?></TEXTAREA></div></TD>
	 </TR>

	 <TR>
	  <TD align='left'>
        <TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0'>
         <TR>
          <TD align='left' width="5%" class="bb" nowrap="nowrap"><div class='padding5 textLabel'><B>Metodolog&iacute;as:</B></div></TD>
          <TD align='left' width="15%" class="bb"><div class='padding5'>
            <SELECT name='id_metodologia' id='id_metodologia' lang='1' title='' style="padding:5px;">
             <OPTION value='' selected>Seleccione...</OPTION>
             <?php foreach( $Metodologia->getListMetodologias() as $nom_tipo => $subnivel_met ){ ?>
             <optgroup label="<?=$nom_tipo?>" >
             	<?php foreach( $subnivel_met as $nom_submet => $met_list ){ ?>
             		<optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  $nom_submet ?>" >
             			<?php foreach( $met_list as $met ){ ?>
             			<option value="<?php echo $met['value'] ?>">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $met['label'] ?></option>
             			<?php } ?>
             		</optgroup>
             	<?php } ?>
             </optgroup>
             <?php } ?>
            </SELECT>	
            <INPUT type='hidden' name='contMetodologias' id='contMetodologias' value='<?=$contMetodologias?>'>
          </div></TD>
          <TD align='left' width="85%" class="bb"><div style="padding:2px 5px;"> <img  id="add_metodologia_trigger" src="../add_document2.jpg" alt=""> <input id="add_metodologia" type="hidden" value="0" name="add_metodologia"> </div>
          </TD>
         </TR>

         <tr>
         	<TD align='left' width="5%" class="bb" nowrap="nowrap"><div class='padding5 textLabel'><B id="sub_metodologia_label" >Herramienta:</B></div></TD>
         	<TD align='left' width="15%" class="bb"><div class='padding5'>
         		<select name="sub_metodologia"  id="sub_metodologia" disabled >
         		</select>
         	</TD>
         	<TD align='left' width="85%" class="bb"><div style="padding:2px 5px;">&nbsp;</TD>
         </tr>

        </TABLE>
        <TABLE cellSpacing='0' cellPadding='0' width='100%' align='center' border='0'>
        <?php foreach( $Metodologia->getPropMetodologias() as $met ){ ?>
        <?php  $id_r_met = $met['id_row_metodologia'];  ?>
	        <tr>
				<td>
					<div class="met-container" id="met_container_<?php echo $id_r_met; ?>" >
						<div class="met-title"><?=$met['nom_metodologia']?> <a title="eliminar metodología" id_met="<?php echo $id_r_met ?>" class="delete-met-selected"><img src="../imagenes/ico3_error.png" ></a> </div>
						<div class="met-fields">
							<table cellSpacing='0' cellPadding='0' width='100%' align='center' border='0' >
									
								<?php if( $met['id_sub_metodologia'] != '' &&  $met['id_sub_metodologia'] != 0 ){ ?>
								<tr>
									<td>Herramienta:</td>
									<td>
										<select name="met_submetodologia[<?=$id_r_met?>]" >
											<?php foreach( $Contenidos->getSubMetodologia( $met['id_metodologia'] ) as $submet ){ ?>
											<option value="<?=$submet['id_sub_met']?>" <?php if( $met['id_sub_metodologia'] == $submet['id_sub_met'] ){ ?> selected <?php } ?> ><?=$submet['nom_sub_met']?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<?php } ?>

								<tr>
									<td>Titulo:</td>
									<td>
										<input  class="w90" type="text" value="<?=$met['titulo']?>" name="met_titulo[<?=$id_r_met?>]" >
										<input type="hidden" name="met_ids[]" value="<?=$id_r_met?>" >
									</td>
								</tr>
								<tr>
									<td>Temas a tratar o objetivos temáticos a cubrir:</td>
									<td><textarea class="met-field-temas"  name="met_temas[<?=$id_r_met?>]" ><?=$met['temas']?></textarea></td>
								</tr>

								
								<tr>
									<td><?=$met['titulo_universo']?>:</td>
									<td><input type="text" name="met_universo[<?=$id_r_met?>]" value="<?=$met['universo']?>" ></td>
								</tr>
								<?php if( $met['a_tam_poblacion'] == 1 ){ ?>
								<tr>
									<td><?=$met['titulo_tam_poblacion']?>:</td>
									<td><input type="text" name="met_tamanio[<?=$id_r_met?>]"  class="only-numbers" value="<?=$met['tamano_poblacion']?>" ></td>
								</tr>
								<?php } ?>
								<?php if( $met['a_tecnica_recoleccion'] == 1 ){ ?>
								<tr>
									<td><?=$met['titulo_tecnica_recoleccion']?>:</td>
									<td>
										<select name="met_poblacion[<?=$id_r_met?>]" class="tecnica-recoleccion" id_met="<?=$id_r_met?>" >
											<option value="">Seleccione...</option>
											<?php foreach( $Contenidos->getTecnicasRecoleccion( $met['ids_pob_objetivo'] ) as $pob ){ ?>
											<option value="<?=$pob['id_pob_objetivo']?>" <?php if( $met['id_pob_objetivo'] == $pob['id_pob_objetivo'] ){ ?> selected <?php } ?> ><?=$pob['des_pob_objetivo']?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
								<?php } ?>
								
								<?php if( $met['a_marco_muestral'] == 1 ){ ?>
								<tr>
									<!-- En realidad origen DB -->
									<td><?=$met['titulo_marco_muestral']?></td>
									<td>
										<?php if( $met['id_pob_objetivo'] != '' ){ ?>
										<select name="met_marco[<?=$id_r_met?>]" class="met_marco" id_met="<?=$id_r_met?>" >
											<option value="">Seleccione...</option>
											<?php foreach( $Metodologia->getAvailableOrigenDb( $id_r_met, $met['id_pob_objetivo'] ) as $origen_db ){ ?>
											<option <?php if( $met['id_origen_db'] == $origen_db['id_origen_db'] ){ ?> selected <?php } ?> value="<?=$origen_db['id_origen_db']?>"><?=$origen_db['nom_origen_db'] ?></option>
											<?php } ?>
										</select>
										<?php } else { ?>
										<select name="met_marco[<?=$id_r_met?>]" class="met_marco" id_met="<?=$id_r_met?>" disabled >
											<option value="" >Completa los campos anteriores...</option>
										</select>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>
								
								<!-- <tr>
									<td>Marco estadistico:</td>
									<td><input type="text" value="<?=$met['marco_custom']?>" name="met_other_marco[<?=$id_r_met?>]" ></td>
								</tr> -->

								<?php if( $met['id_tipo_metodologia'] == 3 ){ ?>
								<tr>
									<td>Metodo de selección de la muestra:</td>
									<td>
										<select name="met_tipo[<?=$id_r_met?>]" class="met_tipo" id_met="<?=$id_r_met?>" >
											<option value="">Seleccione...</option>
											<?php foreach( $Contenidos->getTiposMetCuant( $met['exclude_tipo_cuant'] ) as $met_tipo ){ ?>
											<option <?php if( $met['id_tipo_cuantitativo'] == $met_tipo['id_tipo_cuantitativo'] ){ ?> selected <?php } ?> probabilistico="<?=$met_tipo['probabilistico']?>" value="<?=$met_tipo['id_tipo_cuantitativo']?>"><?=$met_tipo['descripcion']?></option>
											<?php } ?>
										</select>

										
											<input type="text" name="tipo_cuantitativo_custom[<?php echo $id_r_met ?>]" value="<?php echo $met['tipo_cuantitativo_custom'] ?>" placeholder="Especifique:"  <?php if( $met['id_tipo_cuantitativo'] != 10 ){ //otro ?> style="display:none;" <?php } ?>  >
										
									</td>
								</tr>
								<?php } ?>

								<tr class="probabilistic_data" id="probabilistic_data_<?=$id_r_met?>" <?php if( $Metodologia->isProbabilistico($id_r_met) ){ ?> style="display: table-row;" <?php } ?>  >
									<td>Nivel de confianza:</td>
									<td>
										<select name="met_nivel_confianza[<?=$id_r_met?>]" id="met_nivel_confianza_<?=$id_r_met?>">
											<?php foreach( $Contenidos->getNivelConfianza() as $niv_confianza ){ ?>
											<option <?php if( $met['id_nivel_confianza'] == $niv_confianza['id_nivel_confianza'] ){ ?> selected <?php } ?> percent="<?=$niv_confianza['valor']?>" value="<?=$niv_confianza['id_nivel_confianza']?>"><?=$niv_confianza['label']?></option>
											<?php } ?>
										</select>
									</td>
								</tr>

								<tr>
									<td>Especificación: </td>
									<td>
										<input class="only-numbers" min="0" type="number" name="met_filas[<?=$id_r_met?>]" id="met_filas_<?=$id_r_met?>" placeholder="segmentos (filas)" value="<?=$met['rows']?>" >
										<input class="only-numbers" min="0" type="number" name="met_cols[<?=$id_r_met?>]" id="met_cols_<?=$id_r_met?>" placeholder="cantidad (columnas)" value="<?=$met['cols']?>" >
										<a href="javascript:void(0);" class="generateTable" id_met="<?=$id_r_met?>" is_presencial="<?=$met['is_presencial']?>" >Generar Tabla</a>
									</td>
								</tr>
								
								<?php if( $met['a_duracion'] == 1 ){ ?>
								<tr>
									<td><?=$met['titulo_duracion']?>:</td>
									<td>
										<?php if( $met['id_pob_objetivo'] != '' && $met['id_origen_db'] != '' ){ ?>
										<select  class="met_duracion" name="met_tiempo[<?=$id_r_met?>]" id="met_timpo_<?=$id_r_met?>" id_met="<?=$id_r_met?>" >
											<option value="">Seleccione...</option>
											<?php foreach( $Metodologia->getAvailableDuracion( $id_r_met, $met['id_pob_objetivo'], $met['id_origen_db'] ) as $dur_met ){ ?>
											<option <?php if( $met['id_duracion'] == $dur_met['id_duracion'] ){ ?> selected <?php } ?> value="<?=$dur_met['id_duracion']?>"><?=$dur_met['duracion']?></option>
											<?php } ?>
										</select>
										<?php } else { ?>
										<select  class="met_duracion" name="met_tiempo[<?=$id_r_met?>]" id="met_timpo_<?=$id_r_met?>" disabled id_met="<?=$id_r_met?>" >
											<option value="" >Completa los campos anteriores...</option>
										</select>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>

								<?php if( $met['a_incidencia'] == 1 ){ ?>
								<tr>
									<td>¿Se conoce incidencia o hay que aplicar filtros?	</td>
									<td>
										<select class="met_if_incidencia" name="met_if_incidencia[<?=$id_r_met?>]" id="met_if_incidencia_<?=$id_r_met?>" id_met="<?=$id_r_met?>" >
											<option <?php if( $met['if_incidencia'] == 1 ){ ?> selected <?php } ?> value="1">Si</option>
											<option <?php if( $met['if_incidencia'] == 0 ){ ?> selected <?php } ?> value="0">No</option>
										</select>

										<input value="<?=$met['incidencia']?>" class="met_incidencia" type="text" name="met_incidencia[<?=$id_r_met?>]" id="met_incidencia_<?=$id_r_met?>" placeholder="Especifique:" <?php if( $met['if_incidencia'] == 1 ){ ?> style="display:block;" <?php } ?> >
									</td>
								</tr>
								<?php } ?>
								
								<?php if( $met['a_dificultad'] == 1 ){ ?>
								<tr>
									<td><?=$met['titulo_dificultad']?>:</td>
									<td>
										<?php if( $met['id_pob_objetivo'] != '' && $met['id_origen_db'] != '' && $met['id_duracion'] != '' ){ ?>
										<select name="nivel_aceptacion[<?=$id_r_met?>]" >
											<option value="">Seleccione...</option>
											<?php foreach( $Metodologia->getAvailableDificultad( $id_r_met, $met['id_pob_objetivo'], $met['id_origen_db'], $met['id_duracion'] ) as $contenido ){ ?>
											<option <?php if( $met['id_nivel_aceptacion'] == $contenido['id_nivel_aceptacion'] ){ ?> selected <?php } ?> value="<?=$contenido['id_nivel_aceptacion']?>"><?=$contenido['des_nivel_aceptacion']?></option>
											<?php } ?>
										</select>
										<?php } else { ?>
										<select name="nivel_aceptacion[<?=$id_r_met?>]" disabled >
											<option value="" >Completa los campos anteriores...</option>
										</select>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>


							</table>
						</div><!-- fin met fields -->

						<!-- cobertura -->
						<?php foreach( $Contenidos->getCoberturaConstrained( $met['ids_cobertura'] ) as $cobertura ){ ?>
						<input type="hidden" name="js_coberturas[<?=$id_r_met?>]" value="<?=$cobertura['id_cobertura']?>" label="<?=$cobertura['nom_cobertura']?>"  >
						<?php } ?>

						<div class="metTableWrapper" id="metTableWrapper_<?=$id_r_met?>" >
							
							<?php if( $met['cols'] > 0 && $met['rows'] > 0  ){ echo @$Metodologia->makeTable($id_r_met); } ?>
							
						</div> <!-- Fin met tabla -->
					</div><!-- Fin met container -->
				</td>
			</tr>

			
		<?php } ?>
		</table>
      </TD>
	 </TR>
	</TABLE>

<input type="hidden" name="set_default_inv" id="set_default_inv" value="0" >
<!-- jquery library  -->
<script src="js/jquery-1.10.2.min.js" ></script>
<script src="js/metodologia.js?<?php echo time(); ?>" ></script>

<!-- registra algun cambio en alguna metodologia para establecer valores por defecto en inversion -->
<script>
	$(document).ready(function(){

		// $("select").change(function(){ set_default_inv($(this)); });
		// $("input[type=text]").keydown(function(){ set_default_inv($(this)); });

		$("#btn_siguiente").click(function(){

			if( $("#set_default_inv").val() == 1 ){

				if( !confirm('Ud modificó las metodologías propuestas, los precios volverán a sus valores originales.\n¿Desea continuar?') ){
					return false;
				}
			}

		});

	});

	function set_default_inv( jQueryObject ){

		/**
		 * Ignora cambio si:
		 * se agrega nueva metodologia
		 * se cambia el titulo de metodlogia
		 * el campo Temas a tratar o objetivos es ignorado
		 */
		if( jQueryObject.attr('id') == 'id_metodologia' || jQueryObject.hasClass('met-title') ){
			return false;
		}

		$("#set_default_inv").val(1);
	}
</script>

<?php require_once dirname(__FILE__).'/met_warning.php'; ?>	
 	

<!--<INPUT type='hidden' name='sendPage5' id='sendPage5' value='1'>
-->