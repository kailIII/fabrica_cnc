<?php

require_once dirname(__FILE__).'/../krumo/class.krumo.php';
require_once dirname(__FILE__).'/../../libreria.php';
require_once dirname(__FILE__).'/class.SqlConnections.php';
require_once dirname(__FILE__).'/class.Contenidos.php';
require_once dirname(__FILE__).'/../mail_function.php';
require_once dirname(__FILE__).'/class.Usuario.php';
require_once dirname(__FILE__).'/class.Propuesta.php';
require_once dirname(__FILE__).'/class.Metodologia.php';

class ClonePropuesta extends SqlConnections{

	private $id_propuesta_origen;
	private $id_propuesta_destino;
	private $PropuestaOrigen;
	private $PropuestaDestino;
	private $info_prop_origen;
	private $MetodologiaOrigen;
	private $MetodologiaDestino;


	public function __construct( $id_propuesta ){
		parent::__construct();
		$this->id_propuesta_origen = $id_propuesta;

	}

	public function makeClone( $data ){


		$this->PropuestaOrigen 		= new Propuesta( $this->id_propuesta_origen );
		$info_prop_origen 			= $this->PropuestaOrigen->getProp();
		$this->info_prop_origen 	= $info_prop_origen;
		$this->MetodologiaOrigen 	= new Metodologia( $this->id_propuesta_origen );

		// obtiene id propeusta destino
		$this->id_propuesta_destino = $this->clonePropuestaGetId($info_prop_origen, $data);
		$this->PropuestaDestino 	= new Propuesta( $this->id_propuesta_destino );
		$this->MetodologiaDestino 	= new Metodologia( $this->id_propuesta_destino );

		$this->setDefaults();

		$this->clonePage1();
		$this->clonePage2();
		$this->clonePage3();
		$this->clonePage4();
		$this->clonePage5();
		$this->clonePage6();
		$this->clonePage7();
		$this->clonePage9();
		$this->clonePage10();
	}


	// clona pag 1 de la propuesta, retorna ID de la nueva propuesta
	private function clonePropuestaGetId( $info_prop, $data ){

		$titulo 				= $data['titulo'];
		$nom_cliente			= $info_prop['nom_cliente'];
		$empresa_cliente		= $info_prop['empresa_cliente'];
		$cargo_cliente			= $info_prop['cargo_cliente'];
		$email_cliente			= $info_prop['email_cliente'];
		$telefono_cliente		= $info_prop['telefono_cliente'];
		$celular_cliente		= $info_prop['celular_cliente'];
		// $elaborada_por			= $info_prop['elaborada_por'];
		$elaborada_por			= $data['id_usuario'];
		$revisada_por			= $info_prop['revisada_por'];
		$id_unidad_negocio		= $info_prop['id_unidad_negocio'];
		$requerimiento_cliente	= $info_prop['requerimiento_cliente'];

		$sql = "INSERT INTO ".tablaPropuesta." (titulo,
			nom_cliente,
			empresa_cliente,
			cargo_cliente,
			email_cliente,
			telefono_cliente,
			celular_cliente,
			elaborada_por,
			revisada_por,
			id_unidad_negocio)
			 VALUES ('$titulo',
			 '$nom_cliente',
			 '$empresa_cliente',
			 '$cargo_cliente',
			 '$email_cliente',
			 '$telefono_cliente',
			 '$celular_cliente',
			 '$elaborada_por',
			 '$revisada_por',
			 '$id_unidad_negocio')";

		$this->adoDbFab->Execute( $sql );
		return $this->adoDbFab->Insert_ID();
	}

	// establece valores x defecto propuesta
	private function setDefaults(){

		// $this->PropuestaDestino->setDefaultProductos(); se establecen en clonePage7
		$this->PropuestaDestino->setUniqueCode();
		// $this->PropuestaDestino->setProcesos(); se establecen en clonePage9
		// $this->PropuestaDestino->setRutaCritica(); se establece en clonePage9
		$this->PropuestaDestino->setIdoneidades();
		$this->PropuestaDestino->setValidez();
		$this->PropuestaDestino->setFechaCreacion();
		// $this->PropuestaDestino->setNotasCalidad(); se establece en clonePage10
	}

	// clona pagina 1 (clientes)
	private function clonePage1(){

		$this->PropuestaDestino->cleanPropClientes();

		$clientes = $this->PropuestaOrigen->getPropClientes();
		foreach( $clientes as $cliente ){

			$cli_data = array(
				'id_propuesta' 	=> $this->id_propuesta_destino,
				'nombre' 		=> $cliente['nombre'],
				'cargo' 		=> $cliente['cargo'],
				'email' 		=> $cliente['email'],
				'telefono' 		=> $cliente['telefono'],
				'celular' 		=> $cliente['celular']
			);

			$this->PropuestaDestino->addCliente( $cli_data );
		}

	}

	// clona pagina 2 (verbatim, tiempo dedicacion, tipo)
	private function clonePage2(){

		$info_prop_origen = $this->info_prop_origen;

		$query = "UPDATE prop_propuesta SET
					requerimiento_cliente 	= '{$info_prop_origen['requerimiento_cliente']}',
					id_tiempo_ded 			= '{$info_prop_origen['id_tiempo_ded']}',
					conf_vr_dir_estudio 	= '{$info_prop_origen['conf_vr_dir_estudio']}',
					vr_dir_estudio 			= '{$info_prop_origen['vr_dir_estudio']}',
					vr_dir_estudio_2  		= '{$info_prop_origen['vr_dir_estudio_2']}',
					id_tipo_prop  			= '{$info_prop_origen['id_tipo_prop']}'
					WHERE id_propuesta = {$this->id_propuesta_destino}  ";

		$this->adoDbFab->Execute( $query );
	}

	// clona contexto
	private function clonePage3(){

		$info_prop_origen = $this->info_prop_origen;

		$query = "UPDATE prop_propuesta SET contexto = '{$info_prop_origen['contexto']}'
					WHERE id_propuesta = {$this->id_propuesta_destino} ";

		$this->adoDbFab->Execute( $query );
	}

	// clona objetivos
	private function clonePage4(){

		$info_prop_origen = $this->info_prop_origen;

		$query = "UPDATE prop_propuesta SET
			objetivo_general 		= '{$info_prop_origen['objetivo_general']}',
			objetivos_especificos 	= '{$info_prop_origen['objetivos_especificos']}'
			WHERE id_propuesta = {$this->id_propuesta_destino} ";

		$this->adoDbFab->Execute( $query );
	}

	// clona metodologias :o
	private function clonePage5(){

		$metodologias = $this->MetodologiaOrigen->getPropMetodologiasNoJoins();
		$metodologias = $this->removeArrayIndexes( $metodologias );

		foreach( $metodologias 	as $met_key => $met ){

			$id_row_metodologia_origen = $met['id_row_metodologia'];


			unset( $met['id_row_metodologia'] );
			$met['id_propuesta'] = $this->id_propuesta_destino;

			$query = "INSERT INTO prop_metodologia_selected SET ";

			foreach( $met as $val_key => $met_val ){

				$query.= " {$val_key} = '{$met_val}', ";


			}

			$query = substr_replace( $query, "" , -2 );
			$this->adoDbFab->Execute( $query );

			$id_row_metodologia_destino = $this->adoDbFab->Insert_ID();

			// clona varianzas
			$varianzas_origen 	= $this->MetodologiaOrigen->getTableVarianzas( $id_row_metodologia_origen );
			$varianzas_destino 	= array();

			foreach( $varianzas_origen as $varianza ){

				$varianzas_destino[] = $varianza['nombre_var'];
			}

			$this->MetodologiaDestino->tableSetVarianzas( $id_row_metodologia_destino , $varianzas_destino  );

			// clona segmentos
			$segmentos_origen 	= $this->MetodologiaOrigen->getTableSegmentos( $id_row_metodologia_origen );
			$segmentos_destino 	= array();

			foreach( $segmentos_origen as $key_seg => $segmento ){

				$segmentos_destino = array(
					'nombre_segmento' 	=> $segmento['nombre_segmento'],
					'total_segmento' 	=> $segmento['total_segmento'],
					'order_seg' 		=> $key_seg
				);

				if( !empty( $segmento['error_segmento'] ) ){
					$segmentos_destino['error_segmento'] = $segmento['error_segmento'];
				}

				if( !empty( $segmento['id_cobertura'] ) ){
					$segmentos_destino['id_cobertura'] = $segmento['id_cobertura'];
				}

				foreach( $segmento['values'] as $seg_val ){

					$segmentos_destino['values'][] = $seg_val['value'];

				}

				$this->MetodologiaDestino->tableSetSegmentos( $id_row_metodologia_destino, $segmentos_destino );
			}

			// clona totales
			$totales_origen 	= $this->MetodologiaOrigen->getTableTotales( $id_row_metodologia_origen );
			$totales_destino 	= array();

			$totales_destino['total'] = $totales_origen[0]['total'];

			if( !empty( $totales_origen[0]['error'] ) ){
				$totales_destino['error'] = $totales_origen[0]['error'];
			}

			foreach( $totales_origen as $values ){

				$totales_destino['values'][] = $values['value'];

			}

			$this->MetodologiaDestino->tableSetTotales( $id_row_metodologia_destino , $totales_destino);

			// clona errores
			$errores_origen 		= $this->MetodologiaOrigen->getTableErrores( $id_row_metodologia_origen );
			$errores_destino 		= array();
			$total_error_destino 	= null;


			if( count( $errores_origen ) > 0 ){

				$total_error_destino = $errores_origen[0]['total'];
				foreach( $errores_origen as $error ){
					$errores_destino[] = $error['value'];
				}


				$this->MetodologiaDestino->tableSetErrores($id_row_metodologia_destino, $total_error_destino, $errores_destino);
			}

		}

	}

	/*
	 * migracion de metodologias de la tabla antigua a la nueva (para el calculo de inv)
	 * items personalizados
	 * tabla extra
	 * forma de pago y validez
	*/
	private function clonePage6(){

		// migracion
		$this->MetodologiaDestino->makeMigration();

		// set de precios unitarios personalizadoas
		$query 		= "SELECT * FROM prop_seg_metodologia_rta WHERE id_propuesta = '{$this->id_propuesta_origen}'";
		$segs_rta 	= $this->adoDbFab->GetAll( $query );
		$precio_uni = array();

		foreach( $segs_rta as $seg ){

			$precios_uni[] = $seg['precio_unitario'];
		}

		$query 		= "SELECT * FROM prop_seg_metodologia_rta WHERE id_propuesta = '{$this->id_propuesta_destino}'";
		$segs_rta 	= $this->adoDbFab->GetAll( $query );

		foreach( $segs_rta as $key => $seg ){

			$query = "UPDATE prop_seg_metodologia_rta SET
						precio_unitario = '{$precios_uni[$key]}'
						WHERE id_row_segmento = '{$seg['id_row_segmento']}'";

			$this->adoDbFab->Execute( $query );

		}

		// items personalizados - incluye tabla extra
		$query 		= "SELECT * FROM prop_inversion WHERE id_propuesta = {$this->id_propuesta_origen} ";
		$inversion 	= $this->adoDbFab->GetAll( $query );

		foreach( $inversion as $inv ){

			$query = "INSERT INTO prop_inversion SET
						id_propuesta 	= '{$this->id_propuesta_destino}',
						producto 		= '{$inv['producto']}',
						cantidad 		= '{$inv['cantidad']}',
						vr_unitario 	= '{$inv['vr_unitario']}',
						tabla 			= '{$inv['tabla']}'";

			$this->adoDbFab->Execute( $query );
		}

		$query = "UPDATE prop_propuesta SET
				vr_dir_estudio_2 	= '{$this->info_prop_origen['vr_dir_estudio_2']}',
				validez_propuesta 	= '{$this->info_prop_origen['validez_propuesta']}',
				forma_pago 			= '{$this->info_prop_origen['forma_pago']}'
				WHERE id_propuesta 	= '{$this->id_propuesta_destino}'";

		$this->adoDbFab->Execute( $query );
	}

	// productos
	private function clonePage7(){

		$query = "UPDATE prop_propuesta SET
					vb_productos = '{$this->info_prop_origen['vb_productos']}'
					WHERE id_propuesta 	= '{$this->id_propuesta_destino}'";

		$this->adoDbFab->Execute( $query );

		$productos_origen = $this->PropuestaOrigen->getProdProducts();

		foreach( $productos_origen as $prod ){

			$query = "INSERT INTO prop_productos SET
						id_propuesta = '{$this->id_propuesta_destino}',
						nom_producto = '{$prod['nom_producto']}',
						activo 		 = '{$prod['activo']}' ";

			$this->adoDbFab->Execute( $query );
		}
	}

	// calendario
	private function clonePage9(){

		$calendario_origen = $this->PropuestaOrigen->getCalendario();

		foreach( $calendario_origen as $cal ){

			$query = "INSERT INTO prop_proceso SET
						id_propuesta 	= '{$this->id_propuesta_destino}',
						nom_proceso 	= '{$cal['nom_proceso']}',
						responsable 	= '{$cal['responsable']}' ";

			$this->adoDbFab->Execute( $query );

			$query = "INSERT INTO prop_calendario SET
						 id_proceso 	= '{$this->adoDbFab->Insert_ID()}',
						 id_propuesta 	= '{$this->id_propuesta_destino}',
						 semanas 		= '{$cal['semanas']}'";

			$this->adoDbFab->Execute( $query );
		}

		$query = "UPDATE prop_propuesta SET ruta_critica = '{$this->info_prop_origen['ruta_critica']}' WHERE id_propuesta = '{$this->id_propuesta_destino}'";
		$this->adoDbFab->Execute( $query );
	}

	// notas de calidad
	private function clonePage10(){

		$query 					= "SELECT * FROM prop_notas_calidad_rta WHERE id_propuesta = '{$this->id_propuesta_origen}' ";
		$notas_calidad_origen 	= $this->adoDbFab->GetAll( $query );

		foreach( $notas_calidad_origen as $nota ){

			$query = "INSERT INTO prop_notas_calidad_rta SET
						id_propuesta 		= '{$this->id_propuesta_destino}',
						id_nota_calidad 	= '{$nota['id_nota_calidad']}',
						des_nota_calidad 	= '{$nota['des_nota_calidad']}',
						activo_nota_calidad = '{$nota['activo_nota_calidad']}' ";

			$this->adoDbFab->Execute( $query );
		}
	}

	private function removeArrayIndexes( $array ){

		foreach( $array as $inner_key => $inner_array )
			foreach( $inner_array as $key => $val ){

				if( is_numeric( $key ) ){

					unset( $array[$inner_key][$key] );
				}

			}

		return $array;

	}


}
