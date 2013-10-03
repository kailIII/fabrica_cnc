<?php
	
	require_once dirname(__FILE__).'/classes/class.Brief.php';
	$Brief = new Brief;

?>

<script src="js/page9.js?<?=time();?>" ></script>

	<div id="brief2Container">
		<div id="tabs">
			<ul>
				<?php foreach( $Contenidos->getAreas() as $area ){ ?>
				<li><a href="#tabs-<?php echo $area['id_area'] ?>"><?php echo $area['nom_area'] ?></a></li>
				<?php } ?>
				<li><a href="#tabs-sin-especificar">Sin especificar</a></li>
			</ul>

			<?php foreach( $Contenidos->getAreas() as $area ){ ?>
			<div id="tabs-<?php echo $area['id_area'] ?>">
				<table width="100%" class="brief2Table" border="0" cellspacing="0" cellpadding="0" >
					<?php 
						foreach( $Brief->getPropuestas() as $prop ){
							$id_propuesta = $prop['id_propuesta'];
					?>
						<tr>
							<td width="350" valign="top" ><a target="_BLANK" href="brief_1.php?idPropuesta=<?php echo $id_propuesta; ?>"><?php echo $prop['titulo'] ?></a></td>
							<td class="no-padding" >
								<!-- Listado procesos x area -->
								<?php
									 $procesos = $Brief->getProcesosArea( $area['id_area'], $prop['id_propuesta'] );
									 if( count( $procesos ) > 0 ){
								?>
								<div class="brief-procesos-container">
									<h3>Procesos</h3>
									<table width="100%" class="brief2Table innerTable" border="0" cellspacing="0" cellpadding="0" >
										<tr>
											<th width="50%" >Nombre</th>
											<th width="20%" >Fechas</th>
											<th width="10%" >Completado</th>
											<th width="20%" >Razón incumplimiento</th>
										</tr>
										<?php foreach( $procesos as $proceso ){ ?>
											<tr>
												<td><?php echo $proceso['nom_proceso'] ?></td>
												<td>
													<div>Fecha de inicio: <?php echo $proceso['fecha_ini'] ?></div>
													<div>Fecha de fin: <?php echo $proceso['fecha_fin'] ?></div>
												</td>
												<td>
													<?php 
														$proceso['completado'] == 1 ? $checked = 'checked' : $checked = '';
														$id_propuesta 	= $proceso['id_propuesta'];
														$id_proceso 	= $proceso['id_proceso'];
													?>
													<input type="checkbox" class="completado-proceso" id_propuesta="<?php echo $id_propuesta ?>" id_proceso="<?php echo $id_proceso ?>"  <?php echo $checked ?> ></td>
												<td>
													<select class="razon-incu-proceso" id_propuesta="<?php echo $id_propuesta ?>" id_proceso="<?php echo $id_proceso ?>" >
														<option value="">Ninguna</option>
														<?php
															foreach( $Contenidos->getIncumplimientoArea( $area['id_area'] ) as $incum_area ){
																$proceso['id_incu'] == $incum_area['id_incu'] ? $selected = 'selected' : $selected = '';
														?>
															<option value="<?php echo $incum_area['id_incu'] ?>" <?php echo $selected ?> ><?php echo $incum_area['des_incu'] ?></option>
														<?php } ?>
													</select>
												</td>
											</tr>
										<?php } ?>
									</table>
								</div>
								<?php } // fin if procesos ?>

								<!-- Listado productos x area -->
								<?php
									$productos 			= $Brief->getProductosArea( $area['id_area'], $prop['id_propuesta'] );
									$productos_custom	= $Brief->getProductosCustomArea( $area['id_area'], $prop['id_propuesta'] );
									if( count( $productos ) > 0 || count( $productos_custom ) > 0 ){
								?>
								<div class="brief-procesos-container">
									<h3>Productos</h3>

									<table width="100%"  class="brief2Table innerTable" border="0" cellspacing="0" cellpadding="0" >
										<tr>
											<th width="85%" >Nombre</th>
											<th width="15%" >Completado</th>
										</tr>
										
										<?php
											foreach( $productos as $producto ){
												$id_row_segmento = $producto['id_row_segmento'];
										?>
										<tr>
											<td><?php echo $producto['nom_metodologia'] .' - '. $producto['nom_segmento'] ?></td>
											<td>
												<input type="number" min="<?php echo $producto['completado'] ?>" max="<?php echo $producto['muestra'] ?>" id="producto_completado_<?php echo $id_row_segmento ?>" class="completado only-numbers" value="<?php echo $producto['completado'] ?>" > de <?php echo $producto['muestra'] ?>
												<a href="javascript:void(0);" class="set-completado-productos btn btn-mini pull-right" id_row_segmento="<?php echo $id_row_segmento ?>" >Guardar</a>
											</td>
										</tr>
										<?php } ?>

										<?php
											foreach( $productos_custom as $producto ){
												$id_producto = $producto['id_producto'];
										?>
										<tr>
											<td><?php echo $producto['producto'] ?></td>
											<td>
												<input type="number" min="<?php echo $producto['completado'] ?>" max="<?php echo $producto['cantidad'] ?>" id="producto_completado_c_<?php echo $id_producto; ?>" class="completado only-numbers" id_producto="<?php echo $id_producto; ?>" value="<?php echo $producto['completado'] ?>" > de <?php echo $producto['cantidad'] ?>
												<a href="javascript:void(0);" id_producto="<?php echo $id_producto ?>" class="set-completado-productos-c btn btn-mini pull-right">Guardar</a>
											</td>
										</tr>
										<?php } ?>

									</table>

									
								</div>

								<?php if( strtolower($area['nom_area']) == 'procesamiento' ){ // solo aplica a procesamientio ?>
								<div class="brief-procesos-container">
									<h3>Datos</h3>
									<table width="100%"  class="brief2Table innerTable" border="0" cellspacing="0" cellpadding="0" >
										<tr>
											<td>Tipo de captura:
												<select class="tipo-captura" id_propuesta="<?php echo $id_propuesta; ?>" >
													<option value="">Seleccione...</option>
													<?php
														foreach( $Contenidos->getPobsOjetivo() as $tipoc  ){
															$prop['id_pob_objetivo'] == $tipoc['id_pob_objetivo'] ? $selected = 'selected' : $selected = '';
													?>
													<option <?php echo $selected; ?> value="<?php echo $tipoc['id_pob_objetivo'] ?>"><?php echo $tipoc['des_pob_objetivo'] ?></option>
													<?php } ?>
												</select>
											</td>
											<td>Tipo de procesamiento: <select name="" id=""></select></td>
											<td>Crítica y codificación: 
												
												<?php

													if( $prop['critica_codificacion'] == 1 ){
														$checked_1 = 'checked';
														$checked_0 = '';
													} else {
														$checked_1 = '';
														$checked_0 = 'checked';
													}
													
												?>

												<label>Si <input <?php echo $checked_1 ?> type="radio" value="1" id_propuesta="<?php echo $id_propuesta; ?>" class="cyc" name="cyc[<?php echo $id_propuesta ?>]" ></label> 
												<label>No <input <?php echo $checked_0 ?> type="radio" value="0" id_propuesta="<?php echo $id_propuesta; ?>" class="cyc"  name="cyc[<?php echo $id_propuesta ?>]" ></label>
											</td>
											<td>Digitación:
												
												<?php 
													
													if( $prop['digitacion'] == 1 ){
														$checked_1 = 'checked';
														$checked_0 = '';
													} else {
														$checked_1 = '';
														$checked_0 = 'checked';
													}
												?>

												<label>Si <input <?php echo $checked_1; ?> type="radio" class="digitacion" id_propuesta="<?php echo $id_propuesta; ?>" value="1" name="digitacion['<?php echo $id_propuesta ?>']"  ></label>
												<label>No <input <?php echo $checked_0; ?> type="radio" class="digitacion" id_propuesta="<?php echo $id_propuesta; ?>" value="0" name="digitacion['<?php echo $id_propuesta ?>']"  ></label>
											</td>
										</tr>
										<tr>
											<td colspan="4" >Entrega tabulados: <input type="text" class="le-datepciker entrega-tabulados" id_propuesta="<?php echo $id_propuesta; ?>" value="<?php echo $prop['entrega_tabulados'] ?>" > </td>
										</tr>
									</table>

								</div>
								<?php } // fin procesamiento ?>

								<?php } // fin if productos count ?>

								<?php

									$productos 		= $Brief->getProductosPropuesta( $id_propuesta );
									$productos_c 	= $Brief->getProductosCustomPropuesta( $id_propuesta );


 									if( strtolower($area['nom_area']) == 'informe' && ( count( $productos ) > 0 || count( $productos_c ) > 0 ) ){ 
 									// solo aplica a informe

								?>
								<div class="brief-procesos-container">
									<div class="brief-procesos-container">
										<h3>Entregables</h3>
										<table width="100%"  class="brief2Table innerTable" border="0" cellspacing="0" cellpadding="0" >
											<tr>
												<th width="85%" >Nombre</th>
												<th width="15%" >Entregado</th>
											</tr>

											<?php 
												foreach( $productos as $prod ){
													$prod['entregado'] == 1 ? $checked = 'checked' : $checked = '';
													$id_row_segmento = $prod['id_row_segmento'];
											?>
											<tr>
												<td><?php echo $prod['nom_metodologia'] . ' - ' . $prod['nom_segmento'] ?></td>
												<td><input type="checkbox" <?php echo $checked; ?> id_row_segmento="<?php echo $id_row_segmento; ?>" class="entregado-producto" ></td>
											</tr>
											<?php } ?>

											<?php
												foreach( $productos_c as $prod ){
													$id_producto = $prod['id_producto'];
													$prod['entregado'] == 1 ? $checked = 'checked' : $checked = '';
											?>
											<tr>
												<td><?php echo $prod['producto'] ?></td>
												<td><input type="checkbox" <?php echo $checked; ?> id_producto="<?php echo $id_producto; ?>" class="entregado-producto-c" ></td>
											</tr>
											<?php } ?>
											
										</table>
									</div>
								</div>
								<?php } // fin informe ?>

							</td>
						</tr>
					<?php } ?>
				</table>
			</div>
			<?php } ?>

			<div id="tabs-sin-especificar">
				<table width="100%" class="brief2Table" border="0" cellspacing="0" cellpadding="0" >
				<?php foreach( $Brief->getPropuestas() as $prop ){ ?>
					<tr>
						<td width="350" valign="top" ><a target="_BLANK" href="brief_1.php?idPropuesta=<?php echo $id_propuesta; ?>"><?php echo $prop['titulo'] ?></a></td>
						<td class="no-padding" >
							<!-- Listado procesos sin area -->
							<?php
								$procesos = $Brief->getProcesosNoArea( $prop['id_propuesta'] );
								if( count( $procesos ) > 0 ){
							?>
							<div class="brief-procesos-container">
								<h3>Procesos</h3>
								<table width="100%"  class="brief2Table innerTable" border="0" cellspacing="0" cellpadding="0" >
									<tr>
										<th width="50%" >Nombre</th>
										<th width="20%" >Fechas</th>
										<th width="10%" >Completado</th>
										<th width="20%" >Razón incumplimiento</th>
									</tr>
									<?php foreach( $procesos as $proceso ){ ?>
									<tr>
										<td><?php echo $proceso['nom_proceso'] ?></td>
										<td>
											<div>Fecha de inicio: <?php echo $proceso['fecha_ini'] ?></div>
											<div>Fecha de fin: <?php echo $proceso['fecha_fin'] ?></div>
										</td>
										<td>
											<?php 
												$proceso['completado'] == 1 ? $checked = 'checked' : $checked = '';
												$id_propuesta 	= $proceso['id_propuesta'];
												$id_proceso 	= $proceso['id_proceso'];
											?>
											<input type="checkbox" class="completado-proceso" id_propuesta="<?php echo $id_propuesta ?>" id_proceso="<?php echo $id_proceso ?>"  <?php echo $checked ?> ></td>
										
										<td>
											<select class="razon-incu-proceso" id_propuesta="<?php echo $id_propuesta ?>" id_proceso="<?php echo $id_proceso ?>" >
												<option value="">Ninguna</option>
												<?php
													foreach( $Contenidos->getIncumplimientoArea( $area['id_area'] ) as $incum_area ){
														$proceso['id_incu'] == $incum_area['id_incu'] ? $selected = 'selected' : $selected = '';
												?>
													<option value="<?php echo $incum_area['id_incu'] ?>" <?php echo $selected; ?> ><?php echo $incum_area['des_incu'] ?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<?php } ?>
								</table>
							</div>
							<?php } ?>	

							<!-- Listado productos sin area -->
							<?php
								$productos 			= $Brief->getProductosNoArea( $prop['id_propuesta'] );
								$productos_custom	= $Brief->getProductosCustomNoArea( $prop['id_propuesta'] );

								if( count( $productos ) > 0 || count( $productos_custom ) > 0 ){
							?>
							<div class="brief-procesos-container">
								<h3>Productos</h3>

								<table width="100%"  class="brief2Table innerTable" border="0" cellspacing="0" cellpadding="0" >
									<tr>
										<th width="85%" >Nombre</th>
										<th width="15%" >Completado</th>
									</tr>

									<?php
										foreach( $productos as $producto ){
											$id_row_segmento = $producto['id_row_segmento'];
									?>
									<tr>
										<td><?php echo $producto['nom_metodologia'] .' - '. $producto['nom_segmento'] ?></td>
										<td>
											<input type="number" min="<?php echo $producto['completado'] ?>" max="<?php echo $producto['muestra'] ?>" id="producto_completado_<?php echo $id_row_segmento ?>" class="completado only-numbers" value="<?php echo $producto['completado'] ?>" > de <?php echo $producto['muestra'] ?>
											<a href="javascript:void(0);" class="set-completado-productos btn btn-mini pull-right" id_row_segmento="<?php echo $id_row_segmento ?>" >Guardar</a>
										</td>
									</tr>
									<?php } ?>

									<?php foreach( $productos_custom as $producto ){ ?>
									<tr>
										<td><?php echo $producto['producto'] ?></td>
										<td><input type="number" min="<?php echo $producto['completado'] ?>" max="<?php echo $producto['cantidad'] ?>" name="" class="completado only-numbers" value="<?php echo $producto['completado'] ?>" > de <?php echo $producto['cantidad'] ?> <a href="" class="btn btn-mini pull-right">Guardar</a> </td>
									</tr>
									<?php } ?>

								</table>


							</div>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
				</table>
			</div>
		</div>
	</div>

	<table style="display:none;" class="brief2Table" border="0" cellspacing="0" cellpadding="0" >
		<thead>
			<tr>
				<th width="350" rowspan="2" >Propuestas</th>
				<th colspan="100" >Área responsable</th>
			</tr>

			<tr>				
				<?php foreach( $Contenidos->getAreas() as $area ){ ?>
					<th><?php echo $area['nom_area'] ?></th>
				<?php } ?>
				<th>Sin especificar</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach( $Brief->getPropuestas() as $prop ){ ?>
			<tr>
				<td valign="top" ><?php echo $prop['titulo'] ?></td>
				<?php foreach( $Contenidos->getAreas() as $area ){ ?>
				<td>
					<!-- Listado procesos x area -->
					<ul class="brief-proceso-area">
					<?php foreach( $Brief->getProcesosArea( $area['id_area'], $prop['id_propuesta'] ) as $proceso ){ ?>
						<li><a href="javascript:void(0);" class="proceso-item" fecha-inicio="<?php echo $proceso['fecha_ini'] ?>" fecha-final="<?php echo $proceso['fecha_fin'] ?>"  ><?php echo $proceso['nom_proceso'] ?></a></li>
					<?php } ?>
					</ul>
				</td>
				<?php } ?>
				<td>
					<!-- Listado procesos sin area -->
					<ul class="brief-proceso-area">
					<?php foreach( $Brief->getProcesosNoArea( $prop['id_propuesta'] ) as $proceso ){ ?>
						<li><a href="javascript:void(0);" class="proceso-item" fecha-inicio="<?php echo $proceso['fecha_ini'] ?>" fecha-final="<?php echo $proceso['fecha_fin'] ?>"  ><?php echo $proceso['nom_proceso'] ?></a></li>
					<?php } ?>
					</ul>
				</td>
			</tr>
			<?php } ?>
		</tbody>

	</table>
