<?php

require_once dirname(__FILE__).'/class.SqlConnections.php';
require_once dirname(__FILE__).'/../krumo/class.krumo.php';
require_once dirname(__FILE__).'/../../libreria.php';
require_once dirname(__FILE__).'/class.Contenidos.php';
require_once dirname(__FILE__).'/class.Propuesta.php';

Class Brief extends SqlConnections{

	public function __construct(){
		parent::__construct();
	}

	public function getPropuestas(){
		$query = "SELECT * FROM prop_propuesta WHERE estado_final = 3 ORDER BY id_propuesta DESC ";
		return $this->adoDbFab->GetAll( $query );
	}

	// obtiene los procesos de un area especifica
	public function getProcesosArea( $id_area, $id_propuesta ){
		$query = "SELECT * FROM prop_calendario prc
				INNER JOIN prop_proceso pro ON pro.id_proceso = prc.id_proceso
				WHERE prc.id_area = '{$id_area}'
				AND prc.id_propuesta = '{$id_propuesta}' ";
		return $this->adoDbFab->GetAll( $query );
	}

	// obtiene los procesos que no tienen area designada
	public function getProcesosNoArea( $id_propuesta ){
		$query = "SELECT * FROM prop_calendario prc
				INNER JOIN prop_proceso pro ON pro.id_proceso = prc.id_proceso
				WHERE (id_area IS NULL OR id_area = '')
				AND prc.id_propuesta = '{$id_propuesta}'";
		return $this->adoDbFab->GetAll( $query );
	}

	// obtiene los procesos de una propuesta
	public function getProcesosPropuesta( $id_propuesta ){
		$query = "SELECT * FROM prop_calendario prc
				INNER JOIN prop_proceso pro ON pro.id_proceso = prc.id_proceso
				AND prc.id_propuesta = '{$id_propuesta}'";
		return $this->adoDbFab->GetAll( $query );
	}

	// obtiene los productos de un area especifica
	public function getProductosArea( $id_area, $id_propuesta ){

		$query = "SELECT * FROM prop_seg_metodologia_rta psmr
					INNER JOIN prop_metodologia_rta pmr ON pmr.id_row_metodologia = psmr.id_row_metodologia
					INNER JOIN prop_metodologia prm ON prm.id_metodologia = pmr.id_metodologia
					WHERE psmr.id_area = '{$id_area}' AND pmr.id_propuesta = '{$id_propuesta}' ";

		return $this->adoDbFab->GetAll( $query );
	}

	// obtiene inversion de un area especifica (productos personalizados)
	public function getProductosCustomArea( $id_area, $id_propuesta ){
		$query = "SELECT * FROM prop_inversion WHERE id_area = '{$id_area}' AND id_propuesta = '{$id_propuesta}' ";
		return $this->adoDbFab->GetAll( $query );
	}



	// obtiene productos de una propuesta especifica
	public function getProductosPropuesta( $id_propuesta ){
		$query = "SELECT * FROM prop_seg_metodologia_rta psmr
					INNER JOIN prop_metodologia_rta pmr ON pmr.id_row_metodologia = psmr.id_row_metodologia
					INNER JOIN prop_metodologia prm ON prm.id_metodologia = pmr.id_metodologia
					WHERE pmr.id_propuesta = '{$id_propuesta}' ";

		return $this->adoDbFab->GetAll( $query );
	}

	// obtiene inversion de una propuesta especifica (productos personalizados)
	public function getProductosCustomPropuesta( $id_propuesta ){
		$query = "SELECT * FROM prop_inversion WHERE id_propuesta = '{$id_propuesta}' ";
		return $this->adoDbFab->GetAll( $query );
	}

	// obtiene los productos sin area especifica
	public function getProductosNoArea( $id_propuesta ){
		$query = "SELECT * FROM prop_seg_metodologia_rta psmr
					INNER JOIN prop_metodologia_rta pmr ON pmr.id_row_metodologia = psmr.id_row_metodologia
					INNER JOIN prop_metodologia prm ON prm.id_metodologia = pmr.id_metodologia
					WHERE (psmr.id_area IS NULL OR psmr.id_area = '')  AND pmr.id_propuesta = '{$id_propuesta}' ";

		return $this->adoDbFab->GetAll( $query );
	}

	// obtiene inversion de un area especifica (productos personalizados) SIN AREA
	public function getProductosCustomNoArea( $id_propuesta ){
		$query = "SELECT * FROM prop_inversion WHERE (id_area IS NULL OR id_area = '') AND id_propuesta = '{$id_propuesta}' ";
		return $this->adoDbFab->GetAll( $query );
	}

	// cambia estado completado de un proceso
	public function setProcesoCompletado( $id_propuesta, $id_proceso, $val ){

		$query = "UPDATE prop_calendario SET completado = '{$val}' WHERE id_propuesta = '{$id_propuesta}' AND id_proceso = '{$id_proceso}'";
		$this->adoDbFab->Execute( $query );
	}

	// cambia razon incumplimiento de proceso
	public function setRazonIncuProceso( $id_propuesta, $id_proceso, $val ){


		if( $val == '' ){
			$query = "UPDATE prop_calendario SET id_incu = NULL WHERE id_propuesta = '{$id_propuesta}' AND id_proceso = '{$id_proceso}'";
		} else {
			$query = "UPDATE prop_calendario SET id_incu = '{$val}' WHERE id_propuesta = '{$id_propuesta}' AND id_proceso = '{$id_proceso}'";
		}

		$this->adoDbFab->Execute( $query );
	}

	public function setCompletadoProductos( $id_row_segmento, $val ){

		$query = "UPDATE prop_seg_metodologia_rta SET completado = '{$val}' WHERE id_row_segmento = '{$id_row_segmento}'";
		$this->adoDbFab->Execute( $query );

	}

	public function setCompletadoProductosC( $id_producto, $val ){

		$query = "UPDATE prop_inversion SET completado = '{$val}' WHERE id_producto = '{$id_producto}'";
		$this->adoDbFab->Execute( $query );

	}

	public function setTipoCaptura( $id_propuesta, $val ){

		$query = "UPDATE prop_propuesta SET id_pob_objetivo = '{$val}' WHERE id_propuesta = '{$id_propuesta}' ";
		$this->adoDbFab->Execute( $query);

	}

	public function setCriticaYCod( $id_propuesta, $val ){
		$query = "UPDATE prop_propuesta SET critica_codificacion = '{$val}'  WHERE id_propuesta = '{$id_propuesta}' ";
		$this->adoDbFab->Execute( $query );
	}


	public function setDigitacion( $id_propuesta, $val ){
		$query = "UPDATE prop_propuesta SET digitacion = '{$val}'  WHERE id_propuesta = '{$id_propuesta}' ";
		$this->adoDbFab->Execute( $query );
	}

	public function setEntregaTabulados( $id_propuesta, $val ){
		$query = "UPDATE prop_propuesta SET entrega_tabulados = '{$val}'  WHERE id_propuesta = '{$id_propuesta}' ";
		$this->adoDbFab->Execute( $query );
	}

	public function setEntregadoProductos( $id_row_segmento, $val ){
		$query = "UPDATE prop_seg_metodologia_rta SET entregado = '{$val}' WHERE id_row_segmento = '{$id_row_segmento}' ";
		$this->adoDbFab->Execute( $query );
	}

	public function setEntregadoProductoCustom( $id_producto, $val ){

		$query = "UPDATE prop_inversion SET entregado = '{$val}' WHERE id_producto = '{$id_producto}' ";
		$this->adoDbFab->Execute( $query );

	}

	// avance x proceso es en relacion a los PRODUCTOS
	public function getPercentProcesoArea( $id_area, $id_propuesta ){

			$porcentaje_avance = 0;

			$productos 		= $this->getProductosArea($id_area, $id_propuesta);
			$productos_inv 	= $this->getProductosCustomArea($id_area, $id_propuesta);
			$procesos 		= $this->getProcesosArea($id_area, $id_propuesta);

			// base por el cual se dividen los %
			$cantidad_procesos_productos = count( $productos ) + count( $productos_inv ) + count( $procesos );

			if( $cantidad_procesos_productos == 0 )
				return false;

			$porcentaje_cada_producto = 100 / $cantidad_procesos_productos;

			// ciclo productos metodologia
			foreach( $productos  as $prod ){

				$completado = $prod['completado'];
				$cantidad 	= $prod['muestra'];
				$porcentaje = ( $completado / $cantidad ) * $porcentaje_cada_producto;

				$porcentaje_avance += $porcentaje;

			}

			// ciclo productos personalizados
			foreach( $productos_inv  as $prod ){

				$completado = $prod['completado'];
				$cantidad 	= $prod['cantidad'];
				$porcentaje = ( $completado / $cantidad ) * $porcentaje_cada_producto;

				$porcentaje_avance += $porcentaje;

			}

			foreach( $procesos as $proceso ){

				$proceso['completado'] == 1 ? $porcentaje = 1 : $porcentaje = 0;
				$porcentaje *= $porcentaje_cada_producto;


				$porcentaje_avance += $porcentaje;
			}

			if( $this->is_decimal( $porcentaje_avance )  ){
				return number_format( $porcentaje_avance, 2, '.', '' );
			}

			return $porcentaje_avance;

	}

	public function getPercentProceso( $id_propuesta ){
		$Contenidos = new Contenidos;

		$porcentaje_avance 	= 0;
		$porcentaje_areas  	= 0;
		$cantidad_areas 	= 0; // cantidad de areas con productos

		$procesos 		= $this->getProcesosPropuesta($id_propuesta);
		$productos 		= $this->getProductosPropuesta($id_propuesta);
		$productos_c 	= $this->getProductosCustomPropuesta($id_propuesta);


		// base por el cual se dividen los %
		$cantidad_procesos_productos = count( $procesos ) + count( $productos ) + count( $productos_c );
		$cantidad_procesos_productos*= 100;



		foreach( $procesos as $proceso ){

			if( $proceso['completado'] == 1 ){
				$porcentaje_avance += 100;
			}

		}


		foreach( $productos as $producto ){

			if( $producto['completado'] > 0 ){
				$porcentaje_avance += ( $producto['completado'] / $producto['muestra'] ) * 100;

			}
		}

		foreach( $productos_c as $producto ){

			if( $producto['completado'] > 0 ){
				$porcentaje_avance += ( $producto['completado'] / $producto['cantidad'] ) * 100;
			}
		}

		if( $cantidad_procesos_productos > 0 ){
			$porcentaje_avance = ($porcentaje_avance / $cantidad_procesos_productos) * 100;
		}


		if( $this->is_decimal( $porcentaje_avance )  ){
			return number_format( $porcentaje_avance, 2, '.', '' );
		}

		return $porcentaje_avance;

	}

	// avance proyecto en relacion a los PROCESOS (calendario)
	public function getPercentProyectoArea( $id_area, $id_propuesta ){

		$porcentaje_avance 				= 0;
		$procesos 						= $this->getProcesosArea($id_area, $id_propuesta);
		$qty_procesos 					= count( $procesos );
		$total_semanas_procesos_area 	= 0;


		if( $qty_procesos == 0 )
			return false;

		// carga total semanas dedicadas al area
		foreach( $procesos as $proceso ){

			$num_semanas 					= count (explode( ',', $proceso['semanas'] ));
			$total_semanas_procesos_area 	+= $num_semanas;
		}

		if( $total_semanas_procesos_area == 0 )
			return false;

		foreach( $procesos as $proceso ){

			$num_semanas 		= count (explode( ',', $proceso['semanas'] ));
			$porcentaje_aporte 	= $num_semanas / $total_semanas_procesos_area;

			if( $proceso['completado'] == 1 ){
				$porcentaje_avance += $porcentaje_aporte;
			}
		}

		$porcentaje_avance *= 100;

		if( $this->is_decimal( $porcentaje_avance )  ){
			return number_format( $porcentaje_avance, 2, '.', ''  );
		}
		return $porcentaje_avance;


	}

	public function getPercentProyecto( $id_propuesta ){

		$Contenidos = new Contenidos;

		$porcentaje_avance 	= 0;
		$porcentaje_areas  	= 0;
		$cantidad_semanas 	= 0; // cantidad de todas las semanas de los procesos


		foreach( $Contenidos->getAreas() as $area ){

			$id_area 	= $area['id_area'];
			$procesos 	= $this->getProcesosArea($id_area, $id_propuesta);

			foreach( $procesos as $proceso ){
				$cantidad_semanas += count (explode( ',', $proceso['semanas'] ));
			}

		}

		foreach( $Contenidos->getAreas() as $area ){

			$id_area = $area['id_area'];
			$procesos 	= $this->getProcesosArea($id_area, $id_propuesta);

			foreach( $procesos as $proceso ){

					if( $proceso['completado'] == 1 ){

						$num_semanas = count (explode( ',', $proceso['semanas'] ));
						// calculo de avance en base al numero de semanas que toma la actividad sobre la cantidad total de semanas del proyecto
						$porcentaje_avance += ($num_semanas / $cantidad_semanas) * 100;

						// krumo( "{$num_semanas} / {$cantidad_semanas}  * 100 =" . ($num_semanas / $cantidad_semanas) * 100 );
					}

				}
		}


		if( $this->is_decimal( $porcentaje_avance )  ){
			return number_format( $porcentaje_avance, 2, '.', '' );
		}

		return $porcentaje_avance;

	}

	public function getAvanceTiempo( $id_propuesta ){

		$Propuesta 		= new Propuesta($id_propuesta);
		$info_prop 		= $Propuesta->getProp();
		$fecha_inicio 	= $info_prop['fecha_inicio'];

		$calendario 	= $Propuesta->getCalendario();
		$num_semanas 	= 0; // numero de semanas que toma la propuesta

		foreach( $calendario as $cal ){

			$semanas = explode( ",", $cal['semanas'] );
			sort( $semanas );

			$semana_mayor = end( $semanas );

			if( $semana_mayor > $num_semanas ){
				$num_semanas = $semana_mayor;
			}
		}

		// fecha de finalizacion
		$query 				= "SELECT DATE_ADD( '{$fecha_inicio}', INTERVAL 8 WEEK ) as fecha";
		$fecha_finalizacion = $this->adoDbFab->GetRow( $query );
		$fecha_finalizacion = $fecha_finalizacion['fecha'];

		// cuantas semanas han pasado desde la fecha de inicio a la fecha actual
		$query = "SELECT ABS( CEIL ( DATEDIFF (  NOW() , '{$fecha_inicio}' ) / 7 ) ) as fecha";
		$num_semanas_pasadas = $this->adoDbFab->GetRow( $query );
		$num_semanas_pasadas = $num_semanas_pasadas['fecha'];

		// porcentaje
		$porcentaje = 0;

		if( $num_semanas > 0 ){
			$porcentaje = ($num_semanas_pasadas / $num_semanas)*100;
		}


		if( $this->is_decimal( $porcentaje ) ){
			$porcentaje =  number_format( $porcentaje, 2, '.', '' );
		}

		$data = array(
			'fecha_inicio' 			=> $fecha_inicio,
			'fecha_finalizacion' 	=> $fecha_finalizacion,
			'num_semanas_que_toma' 	=> $num_semanas,
			'num_semanas_pasadas' 	=> $num_semanas_pasadas,
			'porcentaje' 			=> $porcentaje
		);

		return $data;
	}

	public function getEfectividad( $num_encuestadores, $efectividad, $dias_semana, $goal ){

		$efectividad *= $dias_semana; // efectividad en la semana

		// si en una semana se hace X encuestas
		$encuestas_por_semana = $goal / $efectividad;

		// se dilata el resultado segun el num de encuestadores
		$semanas_de_demora = ceil($encuestas_por_semana / $num_encuestadores);

		return $semanas_de_demora;
	}

	private function is_decimal( $val ){

	    return is_numeric( $val ) && floor( $val ) != $val;
	}
}