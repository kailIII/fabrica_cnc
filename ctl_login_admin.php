<?php

session_start();
include("connection.php");

include("libreria.php");
//echo'<BR>userAdmin: '.$_SESSION['userAdmin'];

$v_usuarioAdmin		= $_REQUEST['c_usuarioAdmin'];

$v_claveAdmin		= $_REQUEST['c_claveAdmin'];

if(empty($v_usuarioAdmin)){

	$v_usuarioAdmin	= $_SESSION['usuarioAdmin'];
	$v_claveAdmin	= $_SESSION['claveAdmin'];

}

if(empty($v_usuarioAdmin)){

//if(empty($_SESSION['userAdmin']) || empty($usuarioAdmin)){

?>

<!--*** Traiga el HTML correspondiente a Bienvenida y LOGIN **-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<HTML xmlns="http://www.w3.org/1999/xhtml">

<HEAD>

<TITLE>..:: <?=tituloPag?> ::..</TITLE>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!--<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

--><LINK rel="stylesheet" href="/css/style.css" type="text/css">

<HEAD>

<BODY style="background-color:#FFFFFF">

<TABLE width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="border:1px solid #DDDDDD;">

 <TR>

  <TD align="center" width="10%"><IMG src='/imagenes/login_seekers.jpg' height="300" border='0'></TD>

  <TD align="center" width="90%">

  <TABLE width="350" border="0" align="center" cellpadding="0" cellspacing="0" class="Border">

	<TR>

	  <TD width="50%" height="77" align="center" valign="middle">

	  <img src="/imagenes/ie7security.png" width='51' border='0'>

	  </TD>

	  <TD width="50%" valign="top" align="right">

	  <IMG src="/imagenes/cta_dr.jpg" width="113" height="82"></TD>

	</TR>

	<TR>

	  <TD colspan="2" valign="top">

	  <FORM name="frm" method=POST action="<?=$PHP_SELF?>" enctype="multipart/form-data">

		<DIV align="center">

		  <TABLE width="100%">

			<TR>

			  <TD width="51%" nowrap="nowrap" class="texto_gral" align="right">Login:</TD>

			  <TD width="49%"><INPUT type="text" name="c_usuarioAdmin" style="width:100px;" value=""></TD>

			</TR>

			<TR>

			  <TD width="51%" nowrap="nowrap" class="texto_gral" align="right">Clave:</TD>

			  <TD width="49%"><INPUT type="password" name="c_claveAdmin" style="width:100px;" value=""></TD>

			</TR>

		  </TABLE>

		  <FONT size="2" face="Verdana" color="#FFFFFF">

		  <INPUT type="submit" name="Start_survey" value="Submit" class="Button" >

		  </FONT></DIV>

	  </FORM>

	  </TD>

	</TR>

  </TABLE>

  <div align="center">

	<script language=JavaScript>

	<!-- Ignore

	today = new Date()

	month = today.getMonth()

	dia = today.getDay()

	day = today.getDate()

	year = today.getYear()

	if (year < 2000)

	{

	year = year + 1900}

	document.write ("<font FACE='Arial' size=1 color='#000000'><B>")

	

	if (month == 0)

	document.write ("Enero. ")

	else if (month == 1)

	document.write ("Febrero. ")

	else if (month == 2)

	document.write ("Marzo. ")

	else if (month == 3)

	document.write ("Abril. ")

	else if(month == 4)

	document.write ("Mayo. ")

	else if (month == 5)

	document.write ("Junio. ")

	else if (month == 6)

	document.write ("Julio. ")

	else if (month == 7)

	document.write ("Agosto. ")

	else if (month == 8)

	document.write ("Septiembre. ")

	else if (month == 9)

	document.write ("Octubre. ")

	else if (month == 10)

	document.write ("Noviembre. ")

	else if (month == 11)

	document.write ("Diciembre. ")

	document.write (" "+day+", ")

	document.writeln ( year)

	

	RightNow=new Date();

	var timeValue = "";

	var timeValue = "";

	var hours = RightNow.getHours();

	var minutes = RightNow.getMinutes();

	timeValue += ((hours <= 12) ? hours : hours - 12);

	timeValue += ((minutes < 10) ? ":0" : ":") + minutes;

	timeValue += (hours < 12) ? " a.m." : " p.m.";

	

	document.write(""+timeValue+"");

	document.writeln ("</font></B></div>")

	// End ignoring  -->

	</script>

  </div>

  </TD>

 </TR>



 <TR>

  <TD align="center" colspan="2" height="15" style="background-color:#CCCCCC"><div style="padding:10px 5px;">Si 

				durante la operaci&oacute;n del sistema, se presentan dificultades 

				t&eacute;cnicas, por favor contactar al <A href="mailto:wvalencia@cnccol.com" >Webmaster</A>.</div></TD>

 </TR>

</TABLE>

</BODY>

</HTML>

<?php

  exit;

}


if( !isset( $_SESSION['is_robot'] ) ){
$md5_pass = md5( $v_claveAdmin );
} else {
	$md5_pass = $v_claveAdmin;
}

$sql_usu = "

SELECT *

FROM ".tablaUsuario."

 WHERE id_empleado = '$v_usuarioAdmin' AND clave = '$md5_pass'";

//echo '<BR>'.$sql_usu;

$es_valido 		= mysql_query($sql_usu);

if(mysql_num_rows($es_valido) > 0){

	$datosusuario				= mysql_fetch_array($es_valido);

	$idCliente					= $datosusuario["id_cliente"];

	$nomUsuario					= $datosusuario["nomUsuario"];

	$nomUsuario					= $datosusuario["nombres"].' '.$datosusuario["apellidos"];

	

	$usuario_id					= $datosusuario["id_empleado"];

	$tipo_usuario				= $datosusuario["tipo_usuario"];

	$vbNomCliente				= $datosusuario["vb_cliente"];

	$_SESSION['tipoUsuario']	= $tipo_usuario;

	$_SESSION['userAdmin']		= $usuario_id;

	$_SESSION['nomUsuario']		= $nomUsuario;

	$_SESSION['usuarioAdmin']	= $v_usuarioAdmin;

	$_SESSION['claveAdmin']		= $v_claveAdmin;

}

else{

	$_SESSION['userAdmin']		= NULL;

	$_SESSION['usuarioAdmin']	= NULL;

	$_SESSION['claveAdmin']		= NULL;

//	session_unregister("userAdmin");

//	session_destroy();

//	session_unset();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<HTML xmlns="http://www.w3.org/1999/xhtml">

<HEAD>

<TITLE>..:: <?=tituloPag?> ::..</TITLE>

<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<LINK rel="stylesheet" href="/css/style.css" type="text/css">

</HEAD>

<BODY style="background-color:#FFFFFF">

<TABLE width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="border:1px solid #DDDDDD;">

 <TR>

  <TD align="center" width="10%"><IMG src='/imagenes/login_seekers.jpg' height="300" border='0'></TD>

  <TD align="center" width="90%">

   <TABLE width="350" border="0" align="center" cellpadding="0" cellspacing="0" class="Border">

	<TR height="25">

	 <TD align='center'>

			<p>&nbsp;</p>

			<p align="center"><font face="Times New Roman" color="#FF0000" size="4"><b>Usuario incorrecto.</b></font></p>

			<img src="/imagenes/errorsmiley.png" width=128>

			<p align="center"><a href="./"><span style="color:#336699; font-size:16px;"><B>Intentar nuevamente</B></span></a></p>

			<p>&nbsp;</p>

	 </TD>

	</TR>

   </TABLE>

  </TD>

 </TR>



 <TR>

  <TD align="center" colspan="2" height="15" style="background-color:#CCCCCC"><div style="padding:10px 5px;">Si 

				durante la operaci&oacute;n del sistema, se presentan dificultades 

				t&eacute;cnicas, por favor contactar al <A href="mailto:wvalencia@cnccol.com" >Webmaster</A>.</div></TD>

 </TR>

</TABLE>

</BODY>

</HTML>

<?php

  exit;

}

?>