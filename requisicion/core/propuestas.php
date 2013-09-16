<?php
header('Content-Type: text/html; charset=iso-8859-15');
include("connection.php");

// Array que vincula los IDs de los selects declarados en el HTML con el nombre de la tabla donde se encuentra su contenido
$listadoSelects=array(
"propuesta"=>"prop_propuesta"
);
$selectDestino=$_GET["select"];

$opt=$_GET["opcion"];

function validaSelect($selectDestino)
{
	// Se valida que el select enviado via GET exista
	global $listadoSelects;
	if(isset($listadoSelects[$selectDestino])) return true;
	else return false;
}
if($opt=='opt'){

	if(validaSelect($selectDestino) ){
		
		$conexion = dbConnect();
		$consulta=mysql_query("SELECT P.id_propuesta,P.titulo FROM prop_propuesta P WHERE P.id_estado='2' ORDER BY 1") or die(mysql_error());
		mysql_close($conexion);

		echo"
			<label for'prospuesta'class='input' >Seleccione una Propuesta:</label></br>
			";	
			// Comienzo a imprimir el select

		echo "<select name='".$selectDestino."' id='".$selectDestino."' onChange='cargaDatos(this.id)' class='inputclass' title='Seleccione una propuesta' >";
		echo "<option value='0'>Elige</option>";
		while($registro=mysql_fetch_row($consulta)){
			// Convierto los caracteres conflictivos a sus entidades HTML correspondientes para su correcta visualizacion
			$registro[1]=htmlentities($registro[1]);
			// Imprimo las opciones del select
			echo "<option value='".$registro[0]."'>".ucfirst(strtolower($registro[1]))."</option>"; //ojo ? con el valor cero y uno de $registro
			}			
	echo "</select>";
}
}if($opt=='camp'){
	
	$registro=array();
	$conexion = dbConnect();
	$consulta=mysql_query("SELECT p.titulo,p.empresa_cliente,p.telefono_cliente,p.email_cliente,p.nom_cliente,p.vr_dir_estudio, p.fecha_aprobacion FROM prop_propuesta p WHERE p.id_propuesta=$selectDestino") or die(mysql_error());
	$registro=mysql_fetch_row($consulta);
	mysql_close($conexion);
	
	$js_registro = json_encode($registro);
	echo $js_registro;
	
	
}if($opt=='pag'){
	
	header('Content-Type: text/html; charset=iso-8859-15');
	$conexion = dbConnect();
	$sql=("SELECT * FROM prop_metodologia M INNER JOIN prop_metodologia_rta R USING(id_metodologia) WHERE R.id_propuesta='".$selectDestino."'") or die(mysql_error());

	

$filasMetodologias		= NULL;

$con					= mysql_query($sql);
echo '<table align="center" width="" border="1" class="listado_tablas">';

while($campos			= mysql_fetch_array($con)){

	$id_metodologia		= $campos["id_metodologia"];

	$nom_metodologia	= $campos["nom_metodologia"];

	$id_row_metodologia	= $campos["id_row_metodologia"];

	$titulo				= $campos["titulo"];

	$temas				= $campos["temas"];

	$universo			= $campos["universo"];

	$marco_estadistico	= $campos["marco_estadistico"];

	$id_tipo_metodologia	= $campos["id_tipo_metodologia"];


		echo '<tr>';
		echo '<td width="180" >Titulo:</td>';
		echo '<td width="300" height="25" >'.$titulo.'</td>';
		echo '</tr>';
		
	if(!empty($temas)){

		echo '<tr>';
		echo '<td width="180">Temas:</td>';
		echo '<td width="180 height="25"">'.$temas.'</td>';
		echo '</tr>';
	}

		echo '<tr>';
		echo '<td width="180">Metodolog&iacute;a:</td>';
		echo '<td width="180 height="25"">'.$nom_metodologia.'</td>';
		echo '</tr>';

	if($id_tipo_metodologia==3){

		if(!empty($universo)){

		echo '<tr>';
		echo '<td width="180">Universo:</td>';
		echo '<td width="180 height="25"">'.$universo.'</td>';
		echo '</tr>';

			
		}

		if(!empty($marco_estadistico)){

		echo '<tr>';
		echo '<td width="180">Marco estad&iacute;stico:</td>';
		echo '<td width="180 height="25"">'.$marco_estadistico.'</td>';
		echo '</tr>';


			}

	}

	//---- consulta los segmentos de la metodología

	$sqlR = "SELECT *

	 FROM prop_seg_metodologia_rta R

	  WHERE R.id_propuesta='".$selectDestino."' AND R.id_row_metodologia=$id_row_metodologia";

	//echo '<BR>'.$sqlR;

	$conR						= mysql_query($sqlR);

	while($camposR				= mysql_fetch_array($conR)){

		$nom_segmento			= $camposR["nom_segmento"];

		$universo				= $camposR["universo"];

		$muestra				= $camposR["muestra"];

		$error_muestral			= $camposR["error_muestral"];

		$lugar					= $camposR["lugar"];

		$duracion				= $camposR["duracion"];

		

		$id_pob_objetivo_r		= $camposR["id_pob_objetivo"];

		$id_duracion_r			= $camposR["id_duracion"];

		$id_nivel_aceptacion_r	= $camposR["id_nivel_aceptacion"];

		$id_cobertura_r			= $camposR["id_cobertura"];



		if($id_tipo_metodologia==1){

			if(!empty($nom_segmento)){

		echo '<tr>';
		echo '<td width="20%">Ciudad:</td>';
		echo '<td width="180 height="25"">'.$nom_segmento.'</td>';
		echo '</tr>';

				
			}

			if(!empty($muestra)){

		echo '<tr>';
		echo '<td width="180">N&uacute;mero de sesiones:</td>';
		echo '<td width="180 height="25"">'.$muestra.'</td>';
		echo '</tr>';

			}

			if(!empty($lugar)){

		echo '<tr>';
		echo '<td width="180">Lugar donde se va a realizar:</td>';
		echo '<td width="180 height="25"">'.$lugar.'</td>';
		echo '</tr>';
				

			}

			if(!empty($duracion)){

		echo '<tr>';
		echo '<td width="180">Duraci&oacute;n:</td>';
		echo '<td width="180 height="25"">'.$duracion.'</td>';
		echo '</tr>';

			
			}

		}

		elseif($id_tipo_metodologia==3){

			if(!empty($nom_segmento)){

		echo '<tr>';
		echo '<td width="180">Segmento:</td>';
		echo '<td width="180 height="25"">'.$nom_segmento.'</td>';
		echo '</tr>';


			}

			if(!empty($universo)){

				
		echo '<tr>';
		echo '<td width="180">Universo:</td>';
		echo '<td width="180" height="25">'.$universo.'</td>';
		echo '</tr>';

			
			}

			if(!empty($muestra)){

		echo '<tr>';
		echo '<td width="180">Muestra:</td>';
		echo '<td width="180" height="25">'.$muestra.'</td>';
		echo '</tr>';
				
			}

			if(!empty($error_muestral)){

		echo '<tr>';
		echo '<td width="180">Error muestral:</td>';
		echo '<td width="180" height="25">'.$error_muestral.'%</td>';
		echo '</tr>';

		
			}

		}

		else{

			if(!empty($nom_segmento)){

				
		echo '<tr>';
		echo '<td width="180">Segmento:</td>';
		echo '<td width="180" height="25">'.$nom_segmento.'%</td>';
		echo '</tr>';


			}

			if(!empty($muestra)){

						
		echo '<tr>';
		echo '<td width="180">Muestra:</td>';
		echo '<td width="180" height="25">'.$muestra.'%</td>';
		echo '</tr>';

				

			}

		}

	}


}
mysql_close($conexion);
echo '</table>';
}
else if($opt=='log'){
		if($selectDestino==''){
			echo "fail";
		}else{
			$conexion = dbConnect();
			$usuario="admin";
			$ip=$_SERVER['REMOTE_ADDR'];
			$campos="";
			$query="";
			$logtem=explode(",",$selectDestino);

			//$i=1;
			foreach ($logtem as $v) {
				
			//	echo " Opcion.$i : $v <br/>";
			//   $i++;	
				$logt=explode(":",$v);
				
				mysql_query("INSERT INTO `ab1255_fabrica`.`req_logs` (`id_propuesta`, `nombre`, `label`, `campo`, `valor`, `usuario`, `ip`, `fecha`) VALUES ('$logt[0]', '$logt[1]', '$logt[2]', '$logt[3]', '$logt[4]', '$usuario', '$ip', CURRENT_TIMESTAMP)") or die(mysql_error());
						
				
				//$consulta=mysql_query("INSERT INTO `ab1255_fabrica`.`rq_logs` (`id_propuesta`, `nombre`, `label`, `campo`, `valor`, `usuario`, `ip`, `fecha`) VALUES ('1', 'jajaj', 'nana', 'nana', 'nana', 'nana', 'nan', CURRENT_TIMESTAMP)");
			//	echo"--> $logt[0] <br/>";
			//	echo"--> $logt[1] <br/>";
			//	echo"--> $logt[2] <br/>";
			//	echo"--> $logt[3] <br/>";
			//	echo"--> $logt[4] <br/>";
			//	echo"--> $usuario <br/>";
			//	echo"--> $ip <br/>";	
			
			if($logt[2]=="Estudio") $campos[] .= "titulo = '$logt[4]'";
			if($logt[2]=="Contacto del Cliente") $campos[] .= "nom_cliente = '$logt[4]'";
			if($logt[2]=="Cliente") $campos[] .= "empresa_cliente = '$logt[4]'";
			if($logt[2]=="email") $campos[] .= "email_cliente = '$logt[4]'"  ;
			if($logt[2]=="Telefono") $campos[] .= "telefono_cliente = '$logt[4]'";
			//if($logt[2]=="Centro de Costos") $campos[] .= "telefono_cliente = '$logt[4]'";
			
				
			}
			
			mysql_query("update prop_propuesta set ".implode(", ", $campos)." where  id_propuesta= $logt[0]  ");
						
			unset($logtem);
			unset($logt);
			mysql_close($conexion);
		
		}
}else if($opt=='logcalen'){
		if($selectDestino==''|| $selectDestino=='undefined'){
			echo "fail logcalen";
		}else{
			$conexion = dbConnect();
			$usuario="admin";
			$ip=$_SERVER['REMOTE_ADDR'];
			
			$listaProductos = json_decode($_GET['calen']);
				foreach($listaProductos as $producto){
					
					$logt=explode(":",$producto);
					mysql_query("INSERT INTO `ab1255_fabrica`.`req_logcalendario` (`id_propuesta`, `id_proceso`, `semact`, `semdes`, `usuario`, `ip`, `fecha`) VALUES ('$logt[0]', '$logt[1]', '$logt[2]', '$logt[3]','$usuario', '$ip', CURRENT_TIMESTAMP)") or die(mysql_error());
				}
		
		unset($logt);
		mysql_close($conexion);
		
		}
}else if($opt=='grlogcp'){

$page = $_REQUEST['page']; // get the requested page
$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
$sord = $_REQUEST['sord']; // get the direction

	
	$result = mysql_query(" SELECT COUNT(*) AS count
	FROM `req_logs` 
	WHERE id_propuesta='$selectDestino'");	
	
	$row = mysql_fetch_array($result,MYSQL_ASSOC);
	$count = $row['count'];

	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)
	if ($start<0) $start = 0;
	$SQL = "SELECT label,valor,usuario,ip,fecha FROM `req_logs` WHERE id_propuesta='$selectDestino'  ORDER BY ".$sidx." ".$sord. " LIMIT ".$start." , ".$limit;
	$result = mysql_query( $SQL ) or die("Could not execute query 222.".mysql_error());
	$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
		 $responce->rows[$i]['cell']=array($row['label'],$row['valor'],$row['usuario'],$row['ip'],$row['fecha']);
		 
		$i++;
	}

	echo json_encode($responce);
	

}else if($opt=='grlogcl'){

	$page = $_REQUEST['page']; // get the requested page
	$limit = $_REQUEST['rows']; // get how many rows we want to have into the grid
	$sidx = $_REQUEST['sidx']; // get index row - i.e. user click to sort
	$sord = $_REQUEST['sord']; // get the direction

	
	$result = mysql_query("SELECT COUNT(*) AS count
	FROM `req_logcalendario` log,`prop_propuesta`pp,`prop_proceso` pc
	WHERE log.id_propuesta=pp.id_propuesta and log.id_proceso=pc.id_proceso 
	and log.id_propuesta='$selectDestino'");
	$row = mysql_fetch_array($result,MYSQL_ASSOC);
	$count = $row['count'];

	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)
	if ($start<0) $start = 0;
	$SQL = "SELECT pc.nom_proceso,log.semact,log.semdes, log.usuario,log.ip,log.fecha
	FROM `req_logcalendario` log,`prop_propuesta`pp,`prop_proceso` pc
	WHERE log.id_propuesta=pp.id_propuesta and log.id_proceso=pc.id_proceso 
	and log.id_propuesta='$selectDestino'  ORDER BY ".$sidx." ".$sord. " LIMIT ".$start." , ".$limit;
	$result = mysql_query( $SQL ) or die("Could not execute query.".mysql_error());
	$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	
	
	$i=0;
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
		 $responce->rows[$i]['cell']=array(htmlentities($row['nom_proceso']),$row['semact'],$row['semdes'],$row['usuario'],$row['ip'],$row['fecha']);
		// echo htmlentities($row['nom_proceso']);
		$i++;
	}
	
	
	
	echo json_encode($responce);
	
}
?>