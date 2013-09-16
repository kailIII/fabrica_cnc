<?
/* Ojo: Redefinir la implementación de la función tooltip.. */

include('connection.php');
include('libreria.php');

if(isset($_GET['id'])){

$idPropuesta=$_GET["id"];
$date_aprob=$_GET["faprob"];

$num_semanas	= numSemanas;
$inicioSemanas	= 1;
$id_metodologia = 0;
$idIMG ="";
$filasProcesos="";



$colsTitSemanas	= NULL;
for($i=$inicioSemanas; $i <= $num_semanas; $i++){
	$vbSemana	= $i;
	$colsTitSemanas	.= "<TD width='1%' align='center' class='borderBR divInstruccion'><div class='padding2'><B>$vbSemana</B></div></TD>";
}
//----
	$sqlP = "SELECT * FROM ".tablaProceso." ORDER BY id_proceso";
	//echo '<BR>'.$sqlP;
	$conP				= mysql_query($sqlP);
	while($camposP		= mysql_fetch_array($conP)){
		$id_proceso		= $camposP["id_proceso"];
		$nom_proceso	= $camposP["nom_proceso"];
		$responsable	= $camposP["responsable"];

		//---- consulta las semanas del calendario para el proceso actual
		$sqlR = "SELECT * FROM ".tablaCalendario."
		  WHERE id_propuesta=".$idPropuesta." AND id_proceso=".$id_proceso;
		//echo '<BR>'.$sqlR;
		$arraySemanas			= array();
		$conR					= mysql_query($sqlR);
		while($camposR			= mysql_fetch_array($conR)){
			
			$arraySemanas		= explode(',',$camposR["semanas"]);
			if(($camposR["estado"]==1)&& !isset($img)){$img="images/yes.png";}
			if(($camposR["estado"]==0)&& !isset($img)){$img="images/no.png";}
		}
		/*echo '<script>alert("'.(var_dump($camposR)).'")</script>';*/
		$colsSemanas	= NULL;
		$nameObjC		= 'p'.$idPropuesta.'p'.$id_proceso.'[]';
		$idContSem		= 'p'.$idPropuesta.'p'.$id_proceso;
		$fecha_inicio=$date_aprob;
		$id_image="'image".($id_proceso)."'";
		$colaprobado='<img id='.$id_image.' src="'.$img.'" height="16"onClick="rotarImages('.$id_image.');" border="0" style="cursor:pointer" title="Cambiar Estado"/>';
		unset($img);
		for($i=$inicioSemanas; $i <= $num_semanas; $i++){
			$fecha_final=calculaFecha("days",6,$fecha_inicio);
			$class='';
			$divtooltip='';
			$vbSemana	= $i;
			$chObj		= NULL;
			$colorBg	= colorBgOFF;
			$idCelda	= 'celda_m'.$id_metodologia.'p'.$id_proceso.'s'.$i;
			echo '<script>';
			if(in_array($i, $arraySemanas)){
				$chObj	= "checked='checked'";
				$colorBg	= colorBgON;
				$class = 'tooltip';
				$divtooltip = "<div class='tooltip-seg'>Semana ".$i.": ".$fecha_inicio." - ".$fecha_final."</div>";
				echo 'tooltip("'.$idCelda.'");';
				}
			echo '</script>';
			$fecha_inicio = sumaFecha($fecha_final);
			$idObjC		= 'sw_m'.$id_metodologia.'p'.$id_proceso.'s'.$i;
			$objNs		= "<INPUT type='checkbox' name='$nameObjC' id='$idObjC' value='$i' $chObj style='display:none' />";

			$funcion	= "fxCalendario('$id_metodologia','$id_proceso','$idCelda','$nameObjC','$idObjC','$idContSem','$i','$vbSemana','".colorBgON."','".colorBgOFF."');";
//			$celda		= "<a href=\"JavaScript:$funcion\"><div style='width:50px;'>&nbsp;</div></a>";
			$celda		= "<a class='".$class."' href=\"JavaScript:$funcion\"><img id='$idIMG' src='images/spacer.png' width='25' height='30' border='0'/></a>".$divtooltip."";
			$colsSemanas	.= "<TD id='$idCelda' align='center' class='borderBR' style='background-color:$colorBg'>".$celda.$objNs."</TD>";
		}
		
		$filasProcesos .= "
		 <TR>
		  <TD align='right' class='bb'><IMG src='images/yes.png' height='16' border='0'></TD>
		  <TD align='left' class='bb'><div class='padding2 textLabel'>$nom_proceso</div></TD>
		  <TD align='center' class='bb'><div class='padding2 textLabel'>$responsable</div></TD>
		  <TD align='center' class='borderBR'><div id='$idContSem' class='padding2'></div></TD>
		  $colsSemanas
		  <TD align='center' class='borderBR'>$colaprobado</TD>
		  </TR>";
		  
	}
?>

	<TABLE id="calendario" width="100%" border="0" cellspacing="0" cellpadding="0" align="left">

	 <TR>

	  <TD align="center" colspan="2">

        <TABLE width='98%' border='0' cellspacing='0' cellpadding='0' align='center' class="borderL">

         <TR>

          <TD width='1%' align='right' class='bb divInstruccion'>&nbsp;</TD>

          <TD width='30%' align='left' class='bb divInstruccion'><div class='padding5'><B>Procesos</B></div></TD>

          <TD width='2%' align='center' class='bb divInstruccion'><div class='padding5'><B>Responsable</B></div></TD>

          <TD width='2%' align='center' class='borderBR divInstruccion'><div class='padding5'><B>Nro.<br />Semanas</B></div></TD>

          <?=$colsTitSemanas?>
	<TD width='5%' align='center' class='bb divInstruccion borderBR'><div class='padding5'><B>Estado</B></div></TD>
         </TR>

	     <?=$filasProcesos?>

        </TABLE>

	  </TD>

	 </TR>

	</TABLE>

<? }/*echo '<script>tooltip();</script>' */?>

<?
function calculaFecha($modo,$valor,$fecha_inicio=false){
 
   if($fecha_inicio!=false) {
          $fecha_base = strtotime($fecha_inicio);
   }else {
          $time=time();
          $fecha_actual=date("Y-m-d",$time);
          $fecha_base=strtotime($fecha_actual);
   }
 
   $calculo = strtotime("$valor $modo","$fecha_base");
 
   return date("Y-m-d", $calculo);
 
}

function sumaFecha($fecha){
	
	return date("Y-m-d", strtotime("$fecha +1 day"));
	}

//echo calculaFecha("days",139,"2013-01-01") 
if(isset($_GET['semana'])){
	$fecha_inicio=$_GET['fechaprop'];
	echo '<span id="label">Semana '.$_GET['semana'].': ';
	if($_GET['semana'] != 1){
	$fecha_final=date("Y-m-d", strtotime("$fecha_inicio +".$_GET['semana']." week -1 day"));
	
	echo ''.(date("Y-m-d", strtotime("$fecha_final  -1 week +1 day"))).' - '.$fecha_final.'</span>';
	}
	else{
		echo ''.$fecha_inicio.'- '.(date("Y-m-d", strtotime("$fecha_inicio +1 week -1 day"))).'</span>';
		}
	}
	
	if(isset($_GET['image'])&&isset($_GET['idprop'])&&isset($_GET['flag'])){
		
	if($_GET['flag']=='yes'){
		$sqlR1 = "UPDATE ".tablaCalendario." SET estado=0 WHERE id_propuesta=".$_GET['idprop']." AND id_proceso=".substr($_GET['image'], 5);
	}else{
		$sqlR1 = "UPDATE ".tablaCalendario." SET estado=1 WHERE id_propuesta=".$_GET['idprop']." AND id_proceso=".substr($_GET['image'], 5);
	}
	mysql_query($sqlR1);
	}
	
?>