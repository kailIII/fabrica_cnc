<?php

/*
 * Clase base del objeto propuesta.
*/

require_once dirname(__FILE__).'/../krumo/class.krumo.php';
require_once dirname(__FILE__).'/../../libreria.php';
require_once dirname(__FILE__).'/class.SqlConnections.php';
require_once dirname(__FILE__).'/class.Contenidos.php';
require_once dirname(__FILE__).'/../mail_function.php';
require_once dirname(__FILE__).'/class.Usuario.php';

Class Propuesta extends SqlConnections{

	protected $id_propuesta;
	protected $crypt_archivo;

	public function __construct( $id_propuesta ){
		parent::__construct();

  		$this->id_propuesta = $id_propuesta;
	}

	// obtiene la propuesta
	public function getProp(){
		$query = "SELECT * FROM ". tablaPropuesta ." WHERE id_propuesta = {$this->id_propuesta}";
		return $this->adoDbFab->GetRow( $query );
	}

	// retorna el equipo de elaboracion y revision
	public function getElaboraRevisa(){

        $prop = $this->getProp();

		$id_elabora = $prop['elaborada_por'];
		$id_revisa = $prop['revisada_por'];

		$query_elabora 	= "SELECT * FROM prop_equipo_cnc WHERE id = {$id_elabora}";
		$query_revisa 	= "SELECT * FROM prop_equipo_cnc WHERE id = {$id_revisa}";

		return array(
			'elabora' 	=> $this->adoDbFab->GetRow($query_elabora),
			'revisa' 	=> $this->adoDbFab->GetRow($query_revisa)
			);
	}

	// configura los productos por defecto de la propuesta
	public function setDefaultProductos(){

		// si no hay productos por defecto los crea
		if( count( $this->getProdProducts() ) == 0 ):
			$query = "SELECT * FROM ".tablaEntregable." ORDER BY 1";
			foreach( $this->adoDbFab->GetAll($query) as $producto ){ 
				$query = "INSERT INTO  ". tablaProductos ."
				SET nom_producto = '{$producto['nom_entregable']}',
				id_propuesta = {$this->id_propuesta}";

				$this->adoDbFab->Execute( $query );
			}
		endif;
	}

	// obtiene los productos de propuesta
	public function getProdProducts( $act = FALSE ){
		$query = "SELECT * FROM ". tablaProductos ." WHERE id_propuesta = {$this->id_propuesta}";

		if( $act ){
			$query.=" AND activo = {$act}";
		}

		return $this->adoDbFab->GetAll($query);
	}

	// edita los productos de propuesta
	public function updateProdProduct( $id, $nombre, $act = 0 ){

		if( $act == '' ): $act = 0; endif;

		$query = "UPDATE ". tablaProductos ." SET
		nom_producto = '{$nombre}',
		activo = {$act}
		WHERE id_producto = {$id}";

		$this->adoDbFab->Execute( $query );
	}

	public function insertProdProduct( $nom_producto, $activo ){
		$query = "INSERT INTO prop_productos SET 
		id_propuesta = {$this->id_propuesta},
		nom_producto = '{$nom_producto}',
		activo = '{$activo}' ";

		$this->adoDbFab->Execute($query);
	}

	/**
	 * Calcula la invesrion en sus valores por defecto
	 * @var id_row_metodologia references PK table prop_metologia_rta
	 * SELECT * FROM prop_metodologia M INNER JOIN prop_metodologia_rta R USING(id_metodologia) WHERE R.id_propuesta=59 ORDER BY 1
	 */
	public function calcInversion( $id_row_metodologia ){
		$query = "SELECT * FROM ". tablaSegmentoMetodologiaRTA ." R WHERE R.id_row_metodologia= {$id_row_metodologia}";
		$segmento_rta = $this->adoDbFab->GetRow($query);
		$camposR = $segmento_rta;

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
		// if(!empty($muestra) && empty($precioUnitario)){
		if(!empty($muestra) ){
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
		}

		if( $segmento_rta['muestra'] > 0 ){

			$muestra = $segmento_rta['muestra'];
			$query = "SELECT * FROM ". tablaTarifario ." WHERE id_tipo_metodologia = '{$segmento_rta['id_tipo_metodologia']}' {$cond} ";
			$camposTarifario = $this->adoDbFab->GetAll($query);

			foreach( $camposTarifario as $camposT ){
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
			} // end foreach

			if($muestra*$vrUnitario){
				$vrTotal	= $muestra*$vrUnitario;
			}

		} else{
			$vrTotal = 0;
		}

		$result = array(
			'vrUnitario' => $vrUnitario,
			'vrTotal'	 => $vrTotal
			);

		return $result;
	}

	// restaura los valores por defecto de inversion
	public function setInversionToDefault(){
		$propuesta = $this->getProp();
		$id_tiempo_ded = $propuesta['id_tiempo_ded'];

		$query = "SELECT * FROM ". tablaTiempoDedicado ." WHERE id_tiempo_ded = {$id_tiempo_ded}";

		
		$valor_estudio = $this->adoDbFab->GetRow($query);
		$valor_estudio = $valor_estudio['vr_dir_estudio'];

		$query = "UPDATE ". tablaPropuesta ." SET  vr_dir_estudio = '{$valor_estudio}' WHERE id_propuesta = {$this->id_propuesta}";
		$this->adoDbFab->Execute($query);

		$query = "SELECT * FROM ". tablaMetodologia ." M INNER JOIN ". tablaMetodologiaRTA ." R USING(id_metodologia) WHERE R.id_propuesta = {$this->id_propuesta} ORDER BY 1";

		foreach( $this->adoDbFab->GetAll($query) as $result ){

			$query = "UPDATE ". tablaSegmentoMetodologiaRTA ." R SET 
			precio_unitario = ''
			WHERE R.id_row_metodologia = {$result['id_row_metodologia']}";

			$this->adoDbFab->Execute($query);
		}
	}

	// genera el codigo unico de la propuesta basado en la fecha actual
	public function generateUniqueCode( $year = FALSE ){
		
		$leading_ceros = '';
		for( $i = 0; $i < (4 - strlen( $this->id_propuesta )); $i++ ){
			$leading_ceros.='0';
		}

		if( !$year )
			$year = date('Y');

		$code = $leading_ceros.$this->id_propuesta.$year;

		return $code;

	}

	// guarda el codigo unico en BD
	public function setUniqueCode(){
		$code = $this->generateUniqueCode();

		$query = "UPDATE prop_propuesta SET unique_code = '{$code}' WHERE id_propuesta = {$this->id_propuesta}";
		$this->adoDbFab->Execute($query);
	}

	// establece todas las idoneidades seleccionadas por defecto
	public function setIdoneidades(){
		$Contenidos = new Contenidos;

		foreach( $Contenidos->getIdoneidades() as $idoneidad ){
			$query = "INSERT INTO ". tablaIdoneidadRta ." SET 
			id_propuesta = {$this->id_propuesta},
			id_idoneidad = {$idoneidad['id_idoneidad']}
			";

			$this->adoDbFab->Execute($query);
		}
	}

	// revisa si tiene la idoneidad n
	public function hasIdoneidad($id_idoneidad){
		$query = "SELECT * FROM ". tablaIdoneidadRta ." WHERE 
		id_idoneidad = {$id_idoneidad} AND 
		id_propuesta = {$this->id_propuesta}";

		$result = $this->adoDbFab->GetRow($query);

		if( count($result) > 0 )
			return true;

		return false;
	}

	// deselecciona una idoneidad para el proyecto
	public function unsetIndoneidad($id_idoneidad){
		$query = "DELETE FROM ". tablaIdoneidadRta ." WHERE 
		id_idoneidad = {$id_idoneidad} AND 
		id_propuesta = {$this->id_propuesta}";

		$this->adoDbFab->Execute($query);
	}

	// selecciona una idoneidad para el proyecto
	public function setIdoneidad($id_idoneidad){
		$query = "INSERT IGNORE INTO ". tablaIdoneidadRta ." SET 
		id_idoneidad = {$id_idoneidad},  
		id_propuesta = {$this->id_propuesta}";
		$this->adoDbFab->Execute($query);
	}

	// limpia los clientes
	public function cleanPropClientes(){
		$query = "DELETE FROM prop_clientes WHERE id_propuesta = {$this->id_propuesta}";
		$this->adoDbFab->Execute($query);
	}

	public function addCliente( $data )	{

		$query = "INSERT INTO prop_clientes SET ";
		foreach( $data as $field => $value ){
			$query.="{$field} = '{$value}',";
		}	

		$query = substr_replace($query, "", -1);
		$this->adoDbFab->Execute($query);
	}

	public function getPropClientes(){
		$query = "SELECT * FROM prop_clientes WHERE id_propuesta = {$this->id_propuesta} ";
		return $this->adoDbFab->GetAll($query);
	}

	public function setProcesos(){
		$Contenidos = new Contenidos();
		$procesos = $Contenidos->getDefaultsProceso();

		foreach( $procesos as $proceso ){
			$query = "INSERT INTO prop_proceso SET 
			id_propuesta = {$this->id_propuesta},
			nom_proceso = '{$proceso['nombre_dp']}',
			responsable = '{$proceso['responsable_dp']}'";
			
			$this->adoDbFab->Execute($query);
		}
	}

	public function addProceso(){
		$query = "INSERT INTO prop_proceso SET id_propuesta = {$this->id_propuesta}";
		$this->adoDbFab->Execute($query);
	}
	
	public function deleteProceso( $id_proceso ){
		$query = "DELETE FROM prop_proceso WHERE id_proceso = '{$id_proceso}' ";
		$this->adoDbFab->Execute($query);
	}

	public function setEstadoFinal( $estado_final ){
		$query = "UPDATE prop_propuesta SET estado_final = {$estado_final} WHERE id_propuesta = {$this->id_propuesta} ";
		$this->adoDbFab->Execute($query);
	}

	public function setRutaCritica(){
		$ruta = "La ruta crítica es la secuencia de los elementos terminales del proyecto que determinan el tiempo en el que es posible completar el proyecto. La duración de la ruta crítica determina la duración del proyecto entero. Cualquier retraso en un elemento de la ruta crítica afecta la fecha de terminación planeada. Los pasos de la ruta crítica son los siguientes:
*El proceso de planeación en donde se elaboran los formularios, las bases de datos y se revisan los objetivos del proyecto.
*Una vez aprobados los formularios y guías (todos), las bases de datos, listados y sus muestras se realiza el entrenamiento a encuestadores y se prueban en campo dando inicio a la etapa de recolección de la información (Trabajo de Campo).
*Simultáneamente se elaboran los programas de captura y procesamiento, se critican, codifican y digitan las encuestas, a medida que se va realizando el trabajo de campo.
*Una vez terminado la recolección y de digitar todas las encuestas se inicia el procesamiento, generando tablas de tabulación. Por último, con ellas se analizan los resultados y graficados en una presentación de ppt.";
		
		$ruta = utf8_decode($ruta);

		$query = "UPDATE prop_propuesta SET ruta_critica = '{$ruta}' WHERE id_propuesta = {$this->id_propuesta} ";
		$this->adoDbFab->Execute($query);
	}
	
	public function getCalendario(){
		$query ="SELECT * FROM prop_calendario prc
		INNER JOIN prop_proceso prp ON prc.id_proceso = prp.id_proceso
		WHERE prc.id_propuesta = {$this->id_propuesta} ";
		
		return $this->adoDbFab->GetAll($query);
	}

	public function setValidez(){

		$texto = utf8_decode( 'La propuesta tiene a validez de 60 días calendario desde la fecha de presentación.' );

		$query = "UPDATE prop_propuesta SET validez_propuesta = '{$texto}' 
		WHERE id_propuesta = {$this->id_propuesta}";

		$this->adoDbFab->Execute($query);
	}
	
	public function setFechaCreacion(){
		
		$fecha_creacion = date( 'Y-m-d H:i:s' );	
		
		$query = "UPDATE prop_propuesta SET fecha_creacion = '{$fecha_creacion}' WHERE id_propuesta = {$this->id_propuesta}";
		$this->adoDbFab->Execute($query);
	}
	
	public function getComentarios(){
		$query = "SELECT * FROM prop_comentarios_prop pcp
		INNER JOIN empleado emp ON emp.id_equipo_cnc = pcp.id_equipo_cnc
		WHERE pcp.id_propuesta = '{$this->id_propuesta}' ORDER BY id_com_prop DESC ";
		return $this->adoDbFab->GetAll($query);
	}
	
	public function addComentario( $id_usr, $comentario, $notifiacion = true ){
		$query = "INSERT INTO prop_comentarios_prop SET
		id_equipo_cnc = '{$id_usr}',
		id_propuesta = '{$this->id_propuesta}',
		comentario = '{$comentario}'";
		
		if( $notifiacion ){
			$this->notificacionComentario($id_usr);
		}
		
		$this->adoDbFab->Execute($query);
	}
	
	/**
	 * @var id_usr : id_equipo_cnc del usuario que realiza la notificacion
	 **/
	private function notificacionComentario( $id_usr ){
		
		$info_prop = $this->getProp();
		$info_prop['elaborada_por'] == $id_usr ? $recipent_id = $info_prop['revisada_por'] : $recipent_id = $info_prop['elaborada_por'];
		
		$Usuario = new Usuario(false, $recipent_id );
		$recipent = $Usuario->getUsuario();
		
		
		// si no es el q revisa o el que elabora ... es un super ... envia emails a el que elabora y el que revisa
		if( $id_usr != $info_prop['revisada_por'] && $id_usr != $info_prop['elaborada_por'] ){
			
			$Usuario = new Usuario(false, $info_prop['revisada_por'] );
			$revisa = $Usuario->getUsuario();
			$emails[] = $revisa = $revisa['email'];
			
			$Usuario = new Usuario(false, $info_prop['elaborada_por'] );
			$elabora = $Usuario->getUsuario();
			$emails[] = $elabora = $elabora['email'];			
			
		} else {
			$emails[] = $recipent['email'];
		}
		
		$Contenidos = new Contenidos;
		
		$fabrica_dev = explode('/', $_SERVER['PHP_SELF'] );
		$fabrica_dev = $fabrica_dev[2];
		
		
		$subject = utf8_decode("Observación para revisar en la propuesta ".$info_prop['titulo'] );
		$mailBody = file_get_contents( dirname(__FILE__).'/../email_templates/mail_observacion.html' );
		
		$mailBody = str_replace( "{titulo_propuesta}" , $info_prop['titulo'] , $mailBody );
		
		$redirect = 'prop_por_revisar.php?idPropuesta='.$this->id_propuesta;
		$redirect = rtrim(strtr(base64_encode($redirect), '+/', '-_'), '=');
		
		$link_observacion = 'http://herramientascnc.com/propuesta/'. $fabrica_dev .'/robot.php?autoAuth='.$Contenidos->encryptData( $recipent['id_equipo_cnc'] ).'&redirect='.$redirect;
		$mailBody = str_replace( "{link_observacion}" , $link_observacion , $mailBody );
		
		$from_name = "CNC - Fábrica";
		$from_email = "noreply@cnc.com";
		
		sendMail( $emails, $subject, $mailBody, $from_name, $from_email);
	}

	public function noEnIdoneidad(){
		$Contenidos = new Contenidos;
		
		$num_idoneidades = count( $Contenidos->getIdoneidades() );
		$query = "SELECT * FROM prop_idoneidad_rta WHERE id_propuesta  = {$this->id_propuesta} ";
		$result = $this->adoDbFab->GetAll($query);
		
		if( count( $result ) != $num_idoneidades ){
			return true;
		}
		
		return false;
		
	}
	
	public function sendEmailNoIdoneidad(){
		$info_prop = $this->getProp();
		
		$Contenidos = new Contenidos;
		
		$emails = array();	
		
		$query = "SELECT * FROM empleado emp
		INNER JOIN prop_equipo_cnc pec ON pec.id = emp.id_equipo_cnc 
		WHERE emp.notificar_no_idoneidad = 1 ";
		foreach( $this->adoDbFab->GetAll($query) as $value ){
			
			$emails = array( $value['email'] );
			
			$fabrica_dev = explode('/', $_SERVER['PHP_SELF'] );
			$fabrica_dev = $fabrica_dev[2];
			
			$subject = utf8_decode("Inclumpimiento de idoneidad en la propuesta ".$info_prop['titulo'] );
			$mailBody = file_get_contents( dirname(__FILE__).'/../email_templates/mail_no_idoneidad.html' );
			
			$mailBody = str_replace( "{titulo_propuesta}" , $info_prop['titulo'] , $mailBody );
			
			$redirect = 'prop_por_revisar.php?idPropuesta='.$this->id_propuesta;
			$redirect = rtrim(strtr(base64_encode($redirect), '+/', '-_'), '=');
			
			$link_observacion = 'http://herramientascnc.com/propuesta/'. $fabrica_dev .'/robot.php?autoAuth='.$Contenidos->encryptData( $value['id_equipo_cnc'] ).'&redirect='.$redirect;
			$mailBody = str_replace( "{link_observacion}" , $link_observacion , $mailBody );
			
			// lista idoneidades no cumplidas
			$query_idoneidades = "SELECT * FROM prop_idoneidad_rta WHERE id_propuesta  = {$this->id_propuesta} ";
			foreach( $this->adoDbFab->GetAll($query_idoneidades) as $idon ){
				
				$conds.= " id_idoneidad != '{$idon['id_idoneidad']}' AND ";
			}
			
			$conds = substr_replace($conds, "", -4);
			$query = "SELECT * FROM prop_idoneidad WHERE {$conds} ";
			
			foreach( $this->adoDbFab->GetAll( $query )  as $idon ){
				
				$lista_idoneidades.= "<li><b>{$idon['nombre']}</b></li>";
			}
			
			$mailBody = str_replace( "{lista_idoneidades}" , $lista_idoneidades , $mailBody );
			
			$from_name = "CNC - Fábrica";
			$from_email = "comercial@cnccol.com";
		
			sendMail( $emails, $subject, $mailBody, $from_name, $from_email);
		}
	
		
	}

	
	public function setNotasCalidad(){
		$query = "SELECT * FROM prop_nota_calidad ";
		
		$id_nota = 0;
		
		foreach( $this->adoDbFab->GetAll($query) as $notac ){
			$query_rta = "INSERT INTO prop_notas_calidad_rta 
			SET id_propuesta 	= '{$this->id_propuesta}',
			id_nota_calidad  	= '{$id_nota}',
			des_nota_calidad 	= '{$notac['des_nota_calidad']}',
			activo_nota_calidad = '{$notac['activo_nota_calidad']}'";
			
			$id_nota++;
			
			$this->adoDbFab->Execute($query_rta);
		}
	}
	
	public function set_crypt_archivo( $crypt_archivo ){
		$this->crypt_archivo = $crypt_archivo;
	}
	
	public function creacion_propuesta_enviar( $crypt_archivo , $codigo_validacion ){
		
		$id_propuesta 	= $this->id_propuesta;
		$query 			= "INSERT INTO prop_envio_email( id_propuesta , nombre_archivo , codigo_validacion , fecha_creado ) VALUES ( $id_propuesta , '$crypt_archivo' , '$codigo_validacion' , NOW( ) )";
		$this->adoDbFab->Execute( $query );
		
	}
	
	public function propuesta_enviada( $crypt_archivo , $codigo_validacion , $email ){
		
		$id_propuesta 	= $this->id_propuesta;
		
		$query = " SELECT COUNT( 1 ) as cuenta FROM prop_envio_email 
						WHERE nombre_archivo = '$crypt_archivo' AND 
							codigo_validacion = '$codigo_validacion' AND 
							email = '$email' AND
							id_propuesta = $id_propuesta ";
		
		$respuesta = $this->adoDbFab->GetRow( $query );
		
		if( $respuesta[ "cuenta" ] == "1" ){
			
			$query = "UPDATE prop_envio_email SET estado = 'enviado' , fecha_enviado = NOW( )
						WHERE id_propuesta = $id_propuesta AND
							nombre_archivo = '$crypt_archivo' AND
							codigo_validacion = '$codigo_validacion' AND
							email = '$email' ";
			
		} else {
			$query 	= "INSERT INTO prop_envio_email( id_propuesta , nombre_archivo , codigo_validacion , email , estado , fecha_enviado , fecha_creado ) 
						VALUES ( $id_propuesta , '$crypt_archivo' , '$codigo_validacion' , '$email' , 'enviado' , NOW( ) , NOW( ) )";
		}
		
		$this->adoDbFab->Execute( $query );
		
	}
	
	public function descarga_propuesta( ){
		
		$id_propuesta 		= $this->id_propuesta;
		$contenidos 		= new Contenidos;
		$email 				= trim( $contenidos->decryptData( $_GET[ "email" ] ) );
		$crypt_archivo 		= $_GET[ "crypt_archivo" ]; 
		$codigo_validacion 	= $_GET[ "codigo_validacion" ];
		
		
		$query = " SELECT COUNT( 1 ) as cuenta FROM prop_envio_email  
					WHERE id_propuesta = '$id_propuesta' AND
							nombre_archivo = '$crypt_archivo' AND 
							codigo_validacion = '$codigo_validacion' AND
							email = '$email' ";
		
		$respuesta = $this->adoDbFab->getRow( $query );
		if( $respuesta[ "cuenta" ] == "1" ){
			
			$id_propuesta 		= intval( $id_propuesta ); 
			$query = " UPDATE prop_envio_email
							SET numero_descargas = numero_descargas + 1 ,  
								estado = 'revisado' , 
								fecha_revisado = NOW( )
							WHERE id_propuesta = $id_propuesta AND
								nombre_archivo = '$crypt_archivo' AND 
								codigo_validacion = '$codigo_validacion' AND
								email = '$email' ";
			$this->adoDbFab->Execute( $query );
			
			$archivo 	= pathPropuestas_docx . '/registros/' . $crypt_archivo;
			$tmp 		= "PropuestaId_" . $id_propuesta . ".docx";
			header( "Content-type: application/docx" );				
			header( 'Content-Disposition: attachment; filename="' . $tmp . '"' );
			readfile( $archivo );
			return true;
			
		} else {
			die( "registro no existe" );
		}
		
		
		
	}


}