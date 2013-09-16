<? 
	include('connection.php');
	include('libreria.php');
	
	$idPropuesta=$_POST["Id_prop"];
	/*echo '<script>alert("'.$idPropuesta.'");</script>';*/
	function eSQL($sql, $ver_msg=0, $msg=''){

	//echo '<BR>'.$sql;
	if(mysql_query($sql)){
		$result	= 1;
	}
	else{
		$result	= 0;
		if($ver_msg==1){
			echo "<div style='color:#990000'>Atención!!! Error al guardar la información, por favor intente nuevamente</div>".mysql_error();
		}
	}

	}
	
	$sqlP = "SELECT * FROM ".tablaProceso." ORDER BY id_proceso";
		//echo '<BR>'.$sqlP;
		$conP= mysql_query($sqlP);
		while($camposP		= mysql_fetch_array($conP)){
			$id_proceso		= $camposP["id_proceso"];
			$nameObjC		= 'p'.$idPropuesta.'p'.$id_proceso;
			$arraySemProceso= $_POST[$nameObjC];
			if(empty($arraySemProceso)){
				$arraySemProceso= array();
			}
			$sql = "REPLACE INTO ".tablaCalendario." (id_propuesta,id_proceso,semanas)
			 VALUES (".$idPropuesta.",'$id_proceso','".implode(',',$arraySemProceso)."')";
			//echo '<BR>'.$sql;
			$result	= eSQL($sql);
		}
		
		
		
?>