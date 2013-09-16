<?
include("../core/connection.php");
$id_propuesta=$_GET["id"];

		$sqlR = "SELECT * FROM prop_entregable	M INNER JOIN prop_entregable_rta R USING(id_entregable)
		WHERE R.id_propuesta=".$id_propuesta;

		//echo '<BR>'.$sqlR;

		$conR		= mysql_query($sqlR);

		
			$filasEntregable="";
		while($camposP			= mysql_fetch_array($conR)){

			
		$id_entregable		= $camposP["id_entregable"];

		$nom_entregable		= $camposP["nom_entregable"];

		$filasEntregable	.= "

		 <TR>

		  <TD align='right' class='bb'><div class='padding5'><IMG src='images/yes.png' height='16' border='0'></div></TD>

		  <TD align='left' class='bb'><div class='padding5 textLabel'>$nom_entregable</div></TD>

		  <TD align='center' class='bb'>&nbsp;</TD>

		 </TR>";
}
	
?>



	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left">

	 <TR>

	  <TD align="center" colspan="2">

        <TABLE width='98%' border='0' cellspacing='0' cellpadding='0' align='center'>

         <TR>

          <TD width='1%' align='right' class='bb divInstruccion'>&nbsp;</TD>

          <TD width='30%' align='left' class='bb divInstruccion'><div class='padding5'><B>Productos</B></div></TD>

          <TD width='20%' align='center' class='bb divInstruccion'><div class='padding5'><B>&nbsp;</B></div></TD>

          <TD align='right' class='bb divInstruccion'>&nbsp;</TD>

         </TR>

	     <?=$filasEntregable?>

        </TABLE>

	  </TD>

	 </TR>

	</TABLE>

