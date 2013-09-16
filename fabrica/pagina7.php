<?
	// configura los productos por defecto si no existen (Fix proyectos antiguos)
	$Propuesta->setDefaultProductos();

	if(empty($vb_productos)){
		$vb_productos	= $vbDefaultProductos;
	}
	//----
	$sqlP = "SELECT * FROM ".tablaEntregable." ORDER BY 1";
	//echo '<BR>'.$sqlP;
	$conP					= mysql_query($sqlP);
	while($camposP			= mysql_fetch_array($conP)){
		$id_entregable		= $camposP["id_entregable"];
		$nom_entregable		= $camposP["nom_entregable"];
	
		//---- consulta si el proceso aplica para la propuesta activa
		$sqlR = "SELECT * FROM ".tablaEntregableRTA."
		 WHERE id_propuesta=".$idPropuesta." AND id_entregable=".$id_entregable;
		//echo '<BR>'.$sqlR;
		$chObj		= NULL;
		$conR		= mysql_query($sqlR);
		if(mysql_num_rows($conR)){
			$chObj	= "checked='checked'";
		}
		$nameObj	= nameObjEntregables.'[]';
		$idObj		= 'm'.$id_metodologia.'p'.$id_entregable;
		$objCH		= "<INPUT type='checkbox' name='$nameObj' id='$idObj' value='$id_entregable' $chObj />";

		$filasEntregable	.= "
		 <TR>
		  <TD align='right' class='bb'><div class='padding5'><IMG src='/imagenes/yes.png' height='16' border='0'></div></TD>
		  <TD align='left' class='bb'><div class='padding5 textLabel'>$nom_entregable</div></TD>
		  <TD align='center' class='bb'><div class='padding5'>$objCH</div></TD>
		  <TD align='center' class='bb'>&nbsp;</TD>
		 </TR>";
	}
?>

<!-- jquery library  -->
<script src="js/jquery-1.10.2.min.js" ></script>
<script src="js/page7.js?<?=time()?>" ></script>

	<TABLE width="100%" border="0" cellspacing="0" cellpadding="0" align="left" >
	 <TR>
	  <TD align='left' class="bb"><div class='padding5 textLabel'><B>Descripci&oacute;n productos:</B><br />
      <TEXTAREA name='vb_productos' id='vb_productos' lang='1' class='borderBlue' style='width:99%; height:80px; padding:5px;'><?=$vb_productos?></TEXTAREA></div></TD>
	 </TR>
	 <TR>
	  <TD align="center">
        <TABLE width='98%' border='0' cellspacing='0' cellpadding='0' align='center' id="prodsTable" >
         <TR>
          <TD width='1%' align='right' class='bb divInstruccion'>&nbsp;</TD>
          <TD width='30%' align='left' class='bb divInstruccion'><div class='padding5'><B>Productos</B></div></TD>
          <TD width='20%' align='center' class='bb divInstruccion'><div class='padding5'><B>&nbsp;</B></div></TD>
          <TD align='right' class='bb divInstruccion'>&nbsp;</TD>
         </TR>
	     <!-- <?=$filasEntregable?> -->
	     <tr>
	     	<td colspan="4" >
	     	<TABLE width='100%' border='0' cellspacing='0' cellpadding='0' align='center' id="prodsContainer" >	
		     <?php foreach( $Propuesta->getProdProducts() as $producto ){ ?>
		     <tr>
		     	<TD width="26" align='right' class='bb'><div class='padding5'><IMG src='/imagenes/yes.png' height='16' border='0'></div></TD>
		     	<TD width="534" align='left' class='bb'><div class='padding5 textLabel'>
		     		<input type="text" name="prod_nom[]" value="<?=$producto['nom_producto']?>" >
		     		<input type="hidden" name="prod_id[]" value="<?=$producto['id_producto']?>" >
		     	</div></TD>
		     	<TD width="356" align='center' class='bb'><div class='padding5'> <input type="checkbox" name="prod_act[<?=$producto['id_producto']?>]" value="1" <? if( $producto['activo'] == 1 ){  ?> checked="checked" <? } ?> > </div></TD>
		     	<TD align='center' class='bb'>&nbsp;</TD>
		     </tr>
		     <?php } // end foreach ?>
		 	</table>
		    </td>
		</tr>


	    <tr>
	    	<td colspan="4" > <a href="javascript:void(0);" class="btn" id="addProduct" >Añadir Producto</a> </td>
	    </tr>
        </TABLE>
	  </TD>
	 </TR>
	</TABLE>
