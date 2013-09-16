<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
<title>Requisición Servicio Interno</title>
<link rel="stylesheet" href="css/style.css" type="text/css">
<link rel="stylesheet" href="css/attention_box.css" type="text/css">
<link rel="stylesheet" href="scripts/box/colorbox.css" type="text/css">
</head>
<body onload='cargaContenido("propuesta")'>
<div id='container' style="margin:0px; padding:0px;">
<table width="100%" cellspacing="0" cellpadding="2" align="center" border="0" style="background-color:#333333">
  <tbody>
    <tr>
      <td width="10%" align="right" valign="middle" nowrap="nowrap"><div class="padding2" style="font-size:14px; color:#CCCCCC;"><b>BRIEF</b></div></td>
      <td width="1%" align="center" valign="middle">
      <div style="color:#FFFFFF;">|</div></td>
      <td width="10%" align="center" valign="middle" nowrap="nowrap" style=" color:#FFFFFF;"><div class="padding5"><a  href="../fabrica/"><span style='color:#FFFFFF;'>Fabrica</span></a></div></td>
      <td width="1%" align="center" valign="middle"><div style="color:#FFFFFF;">|</div></td> 
	  <td width="10%" align="center" valign="middle" nowrap="nowrap" style=" color:#FFFFFF;"><div class="padding5"><a class="iframe" id="hrefcal" href="#" ><span style='cursor:pointer;color:#FFFFFF;'>Log Calendario</span></a></div></td>
																													
      <td width="1%" align="center" valign="middle"><div style="color:#FFFFFF;">|</div></td>
      <td width="10%" align="center" valign="middle" nowrap="nowrap" style=" color:#FFFFFF;"><div class="padding5"><a class="iframe2" id="hrefform" href="#"><span style='cursor:pointer;color:#FFFFFF;'>Log Formularios</span></a></div></td>
      <td width="1%" align="center" valign="middle"><div style="color:#FFFFFF;">|</div></td>
      <td align="right" valign="middle">&nbsp;</td>
      <td width="20%" align="right" nowrap="nowrap"><div class="padding2" style="color: #6699CC; font-weight: bold;">Bienvenid@:<?=$_GET["session"];?></div></td>
      <td width="5%" align="right" valign="bottom" nowrap="nowrap"><div><img src="images/icoblg_candado.png" alt="Salir" title="Salir" height="30" border="0" style="margin-right:5px;" /></a></div></td>
    </tr>
  </tbody>
</table>
<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center" style="background-color:#FFFFFF">
    <tr>
      <td><table width="100%" cellspacing="0" cellpadding="2" align='center' border="0">
        <tr>
          <td width="10%" height="85" align="left"><img src="images/logo_cnc.gif" title="Centro Nacional de consultor&iacute;a" height="81" border='0' /></td>
          <td align="left" width="40%" nowrap="nowrap" valign="bottom"><div class="padding5 subtitulos_azules">
          </div></td>
          <td width="53%" align='left' valign='middle'>
          <div align="right" id="propu" class="padding5 textLabel">
            <label for="prospuesta" class="input" >Seleccione una Propuesta:</label>
            </br>
            <select name="propuesta" id="propuesta"  class="inputclass" title="Seleccione una propuesta">
              <option value="">Selecciona opci&oacute;n...</option>
            </select>
          </div>
            <br /></td>
          </tr>
    </table></td>
    </tr>
    <tr><td><div class="textLabel">
          <table width="850">
              <tr>
                <td width="231" height="32"><label for="prospuesta" class="input" >
                  <div align="justify">Centro de Costos:</div>
                </label>                  
                  <div align="justify">
                    <input type="text" name="Centro de Costos" id="header_item1" class="padding5" style="width:229px;" value="">                
                  </div></td>
                <td width="228"><div align="justify">Estudio:</div>
                  </label>
                  <div align="justify">
                    <input type="text" name="Estudio" id="header_item2" class="padding5" style="width:260px;" value="" />
                </div></td>
                <td width="375"><label for="prospuesta" class="input" >
                  <label for="prospuesta" class="input " >
                  <div align="justify">Telefono:</div>
                  </label>
                  <div align="justify">
                    <input type="text" name="Telefono" id="header_item5" class="padding5" style="width:229px;" value="" />
                  </div>
                <div align="justify"></div></td>
                <td width="155"><div align="justify">Contacto del Cliente:</div>
                  </label>
                  <div align="justify">
                    <input type="text" name="Contacto del Cliente" id="header_item7" class="padding5" style="width:229px;" value="" />
                </div></td>
              </tr>
              <tr>
                <td height="30"><label for="prospuesta" class="input " >
                  <div align="justify">Director de Estudios :</div>
                </label>                  
                  <div align="justify">
                    <input type="text" name="Director de Estudios" id="header_item3" class="padding5" style="width:229px;" value="" />                
                  </div></td>
                <td><div align="justify">Cliente:</div>
                  </label>
                  <div align="justify">
                    <input type="text" name="Cliente" id="header_item4" class="padding5" style="width:260px;" value="" />
                </div></td>
                <td><label for="prospuesta" class="input " >
                  <div align="justify">Email:</div>
                  </label>
                  <div align="justify">
                    <input type="text" name="Email"  id="header_item6" class="padding5" style="width:229px;" value="" />
                  </div>
                <div align="justify"></div></td>
                <td><div align="justify">Contacto CNC:</div>
                  </label>
                  <div align="justify">
                    <input type="text" name="Contacto CNC"  id="header_item8" class="padding5" style="width:229px;" value="" />
                </div></td>
              </tr>
          </table>
      </div></td></tr>
      <tr>
      <td><table cellspacing='0' cellpadding='0' width='100%' align='center' border='0'>
        <tr>
          <td width="10" nowrap="nowrap"><img src='images/spacer.gif' width='10' height='8' border="0" /></td>
          <td nowrap="nowrap"><div class="padding5"><img src='images/barra_colores.jpg' width='100%' height='8' /></div></td>
          <td width="10" nowrap="nowrap"><img src='images/spacer.gif' width='10' height='8' border="0" /></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td id="Barra" style="background-color:#F5F5F5" height="20"><table cellspacing='0' cellpadding='0' width='100%' align='center' border='0'>
        <tr>
          <td width="9%" nowrap="nowrap" class=""><div class="padding5 menuF"></div></td>
          <td width="9%" nowrap="nowrap" class=""><div class="padding5 menuF"></div></td>
          <td width="9%" nowrap="nowrap" class=""><div class="padding5 menuF"></div></td>
          <td width="9%" nowrap="nowrap" class=""><div class="padding5 menuF"></div></td>
          <td width="9%" nowrap="nowrap" class=""><div id="Item1" class="padding5 menuF" align="center" style="background:#cccccc;"><a href="#"><b>Planeaci&oacute;n</b></a></div></td>
          <td width="14%" nowrap="nowrap" class=""><div id="Item2" class="padding5 menuF" align="center"><a href="#"><b>Estad&iacute;stica - Muestreo</b></a></div></td>
          <td width="9%" nowrap="nowrap" class=""><div id="Item3" class="padding5 menuF" align="center"><a href="#"><b>Cualitativo</b></a></div></td>
          <td width="9%" nowrap="nowrap" class=""><div id="Item4" class="padding5 menuF" align="center"><a href="#"><b>Cuantitativo</b></a></div></td>
          <td width="10%" nowrap="nowrap" class=""><div id="Item5" class="padding5 menuF" align="center"><a href="#"><b>Procesamiento</b></a></div></td>
          <td width="9%" nowrap="nowrap" class=""><div id="Item6" class="padding5 menuF" align="center"><a href="#"><b>Seguimiento</b></a></div></td>
          <td width="9%" nowrap="nowrap" class=""><div id="Item7" class="padding5 menuF" align="center"><a href="#"><B>Presupuesto</B></a></div></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" align="left" >
        <tr>
          <td align="center"><table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td width="100%" align='justify'>
              <div id="wrap"><div id="main">

<ul id="stepForm" class="ui-accordion-container">
<li id="sf1"><a href='#' class="ui-accordion-link"></a>
	<div>
    <form name="cmaForm1" id="cmaForm1" method="post">
    <input type="hidden" name="Id_prop" id="Id_prop" value="0" />
    <input type="hidden" name="faprob" id="faprob" value="0" />
    <input type="hidden" name="Arg_prop" id="Arg_prop" value="0" />
	<fieldset>
	<legend> Página 1 de 7 </legend>
	<div id="cal"></div><br /><p>&nbsp;</p>
    <div id="Pag1_entregables"></div>
    <div id="pag1_comentario" align="left" class="textLabel padding5" style="display:none;">
      <p>&nbsp;</p>
      <p>Comentarios relevantes sobre el estudio:
        <textarea id="Pag1_item1" style="width: 100%; height: 49px;" ></textarea>
      </p>
    </div>
	<br />
	<div align="center" class="buttonWrapper"><input name="formNext1" type="button" class="open1 Button" value="Página Siguiente" alt="Página Siguiente" title="Página Siguiente" /></div>
	</fieldset>
    </form>
	</div>
	</li>
	<li id="sf2">
	<a href='#' class="ui-accordion-link">
	</a>
	<div>
	<fieldset>
	<legend> Página 2 de 7 </legend>
	<div align="center" id="pag2"></div>
	<div align="center" class="buttonWrapper"><input name="formBack0" type="button" class="open0 prevbutton Button" value="Página Anterior" alt="Página Anterior" title="Página Anterior" />  
    
    <input name="formNext2" type="button" class="open2 nextbutton Button" value="Página Siguiente" alt="Página Siguiente" title="Página Siguiente" /></div>
	</fieldset>
	</div>
	</li>
	<li id="sf3">
	<a href='#' class="ui-accordion-link">
	</a>
	<div>
	<fieldset>
	<legend> Página 3 de 7 </legend>
	<div align="center" id="pag3"></div> <br />
<div align="center" class="buttonWrapper"><input name="formBack1" type="button" class="open1 prevbutton Button" value="Página Anterior" alt="Página Anterior" title="Página Anterior" />
    <input name="formNext3" type="button" class="open3 nextbutton Button" value="Página Siguiente" alt="Página Siguiente" title="Página Siguiente" /></div>
	</fieldset>
	</div>
	</li>
    <li id="sf4">
	<a href='#' class="ui-accordion-link">
	</a>
	<div>
	<fieldset>
	<legend> Página 4 de 7 </legend>
	<div id="pag4"></div><br />
	<div align="center" class="buttonWrapper"><input name="formBack2" type="button" class="open2 prevbutton Button" value="Página Anterior" alt="Página Anterior" title="Página Anterior" /> 
    <input name="formNext4" type="button" class="open4 nextbutton Button" value="Página Siguiente" alt="Página Siguiente" title="Página Siguiente" /></div>
	</fieldset>
	</div>
	</li>
    <li id="sf5"><a href='#' class="ui-accordion-link"></a>
	<div>
    <fieldset>
	<legend> Página 5 de 7 </legend>
	<div align="center" id="pag5"></div><br />
	<div align="center" class="buttonWrapper"><input name="formBack3" type="button" class="prevbutton open3 Button" value="Página Anterior" alt="Página Anterior" title="Página Anterior" />
	  <input name="formNext5" type="button" class="open5 nextbutton Button" value="Página Siguiente" alt="Página Siguiente" title="Página Siguiente" />
	</div>
	</fieldset>
	</div>
	</li>
    <li id="sf6"><a href='#' class="ui-accordion-link"></a>
	<div>
	<fieldset>
	<legend> Página 6 de 7 </legend>
	<div id="pag6"></div><br />
	<div  align="center" class="buttonWrapper"><input name="formBack4" type="button" class="prevbutton open4 Button" value="Página Anterior" alt="Página Anterior" title="Página Anterior" />
	  <input name="formNext7" type="button" class="open6 nextbutton Button" value="P&aacute;gina Siguiente" alt="P&aacute;gina Siguiente" title="P&aacute;gina Siguiente" />
	</div>
	</fieldset>
	</div>
	</li>
    <li id="sf7"><a href='#' class="ui-accordion-link"></a>
	<div>
	<fieldset>
	<legend> Página 7 de 7 </legend>
	<div id="pag7"></div><br />
	<div  align="center" class="buttonWrapper"><input name="formBack5" type="button" class="prevbutton open5 Button" value="Página Anterior" alt="Página Anterior" title="Página Anterior" />
	</div>
	</fieldset>
	</div>
	</li>
</ul>


</div>
</div></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
    </tr>
</table>
</div>
</body>
</html>
<?php include_once('commons/footer.php'); ?>