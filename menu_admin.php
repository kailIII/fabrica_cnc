<?

$idMenu				= $_REQUEST['idMenu']?	$_REQUEST['idMenu']	:	1;

$rowAtrib[$idMenu]	= "border-top:3px solid #D76F19;";

$rowBg[$idMenu]		= " bgcolor='#282828'";

?>

   <TABLE width="100%" cellspacing="0" cellpadding="2" align='center' border="0" style="background-color:#333333" id="navBarMain" >

	 <TR>

	  <TD width="10%" align='right' valign='middle' nowrap="nowrap"><div class="padding2" style='font-size:14px; color:#CCCCCC;'><B>F&aacute;brica de propuestas</B></div></TD>

	  <TD width="1%" align='center' valign='middle'><div style='color:#FFFFFF;'>|</div></TD>

	  <TD width="10%" align='center' valign='middle' nowrap="nowrap" style=" <?=$rowAtrib[1]?>"<?=$rowBg[1]?>><div class="padding5"><a href="index.php?idMenu=1"><span style='color:#FFFFFF;'>Nueva</span></a></div></TD>

	  <TD width="1%" align='center' valign='middle'><div style='color:#FFFFFF;'>|</div></TD>

	  <TD width="10%" align='center' valign='middle' nowrap="nowrap" style=" <?=$rowAtrib[2]?>"<?=$rowBg[2]?>><div class="padding5"><a href="lista_propuestas.php?idMenu=2"><span style='color:#FFFFFF;'>Propuestas realizadas</span></a></div></TD>
      
       
	  <TD width="1%" align='center' valign='middle'><div style='color:#FFFFFF;'>|</div></TD>
		<TD width="10%" align='center' valign='middle' nowrap="nowrap" style=" <?=$rowAtrib[3]?>" ><div class="padding5"><a href="propuestas_por_revisar.php?idMenu=3"><span style='color:#FFFFFF;'>Propuestas por revisar</span></a></div></TD>
	  <TD width="1%" align='center' valign='middle'><div style='color:#FFFFFF;'>|</div></TD>


	
    <? echo " <TD width='10%' align='center' valign='middle' nowrap='nowrap' style=".$rowAtrib[2]=$rowBg[2]."><div class='padding5'><a href='brief_2.php'> <span style='color:#FFFFFF;'>BRIEF</span></a></div></TD>  
  ";
  ?>

  <TD width="1%" align='center' valign='middle'><div style='color:#FFFFFF;'>|</div></TD>

	  

<!--	  <TD width="10%" align='right' valign='middle' nowrap="nowrap" style=" <?=$rowAtrib[2]?>"<?=$rowBg[2]?>><div class="padding5"><a href="/ecopetrol/cliente_interno/muestra/muestra_subservicio.php?idMenu=2"><span style='color:#FFFFFF;'>Muestra por subservicio</span></a></div></TD>

	  <TD width="1%" align='center' valign='middle'><div style='color:#FFFFFF;'>|</div></TD>

	  <TD width="10%" align='right' valign='middle' nowrap="nowrap" style=" <?=$rowAtrib[3]?>"<?=$rowBg[3]?>><div class="padding5"><a href="/ecopetrol/cliente_interno/muestra/muestra_form_general.php?idMenu=3"><span style='color:#FFFFFF;'>Preguntas Generales</span></a></div></TD>

	  <TD width="1%" align='center' valign='middle'><div style='color:#FFFFFF;'>|</div></TD>

	  <TD width="10%" align='right' valign='middle' nowrap="nowrap" style=" <?=$rowAtrib[4]?>"<?=$rowBg[4]?>><div class="padding5"><a href="/ecopetrol/cliente_interno/productividad/?idMenu=4"><span style='color:#FFFFFF;'>Productividad de campo</span></a></div></TD>

	  <TD width="1%" align='center' valign='middle'><div style='color:#FFFFFF;'>|</div></TD>

-->	  <TD align='right' valign='middle'>&nbsp;</TD>

	  <TD width="20%" align='right' nowrap="nowrap"><div class="padding2" style='color: #6699CC; font-weight: bold;'>Bienvenid@: <?=$nomUsuario?></div></TD>

	  <TD width="5%" align='right' valign="bottom" nowrap="nowrap"><div><a href="logout.php"><img src="/imagenes/icoblg_candado.png" alt="Salir" title="Salir" height="30" border="0" style="margin-right:5px;"></a></div></TD>

	 </TR>

   </TABLE>

