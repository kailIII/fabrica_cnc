<?
define("tablaUsuario","empleado");
define("tablaEquipo","prop_equipo_cnc");
define("tablaEquipoTrabajo","prop_equipo_trabajo");
define("tablaTipoEstudio","prop_tipo_estudio");
define("tablaMetodologia","prop_metodologia");
define("tablaProceso","prop_proceso");
define("tablaTiempoProceso","prop_tiempo_proceso");
define("tablaEntregable","prop_entregable");
define("tablaPropuesta","prop_propuesta");
define("tablaTipoMetodologia","prop_tipo_metodologia");
define("tablaObjetivoGeneral","prop_objetivo_general");
define("tablaObjetivoEspecifico","prop_objetivo_especifico");
define("tablaTiempoDedicado","prop_tiempo_dedicado");
define("tablaTarifario","prop_tarifario");
define("tablaOrigenDB","prop_origen_db");
define("tablaDesMuestra","prop_des_muestra");
define("tablaNivelAceptacion","prop_nivel_aceptacion");
define("tablaPobObjetivo","prop_pob_objetivo");
define("tablaCobertura","prop_cobertura");
define("tablaDuracion","prop_duracion");
define("tablaRol","prop_rol");
define("tablaNotasCalidad","prop_nota_calidad");
define("tablaCiudad","prop_ciudad");
define("tablaUnidadNegocio","prop_unidad_negocio");
define("tablaPagina","prop_pagina");
define("tablaFormaPago","prop_forma_pago");

define("tablaMetodologiaRTA","prop_metodologia_rta");
define("tablaTiempoProcesoRTA","prop_tiempo_proceso_rta");
define("tablaEntregableRTA","prop_entregable_rta");
define("tablaEquipoTrabajoRTA","prop_equipo_trabajo_rta");
define("tablaCalendario","prop_calendario");
define("tablaSegmentoMetodologiaRTA","prop_seg_metodologia_rta");
define("tablaNotasCalidadRTA","prop_notas_calidad_rta");

define("pathPropuestas_docx","propuestas");
//$arrayNomEstado	= array('0'=>'Inactivo','1'=>'Activo');
//define("colorON","#FF3300");
//define("colorOFF","#000000");

define("tituloPag","PROPUESTA");
define("colorBordeON","#CC0000");
define("colorBordeOFF","#FFFFFF");
define("colorBgON","#3399FF");
define("colorBgOFF","#FFFFFF");
define("nameObjMetodologias","metodologias");
define("nameObjEquipoTrabajo","equipo_trabajo");
define("nameObjEntregables","entregables_p");
define("nameObjVrDirEstudio","vr_dir_estudio");
define("nameObjVrUnitario","vr_unitario_item");
define("nameObjVrTotalItem","vr_total_por_item");

define("nameObjNotasCalidad","notas_calidad");
//---- % de IVA
define("porcentajeIVA","0.16");
//---- costantes para el cálculo del error muestral
//define("idObjNomSegmento","nom_segmentoM");
//---- objetos tipo metodología 3
define("idObjNomSegmento","nom_segmentoM");
define("idObjPobObjetivo","pob_objetivoM");
//define("idObjDuracion","duracionM");
define("idObjNivelAceptacion","nivel_aceptacionM");
define("idObjCobertura","nom_coberturaM");
define("idObjUniverso","universoM");
define("idObjMuestra","muestraM");
define("idObjErrorMuestral","error_muestralM");
define("idObjOrigenDB","origenDB_M");
define("idObjLugar","lugarM");
define("idObjDuracion","duracionM");
define("numPaginas",11);// numero de páginas que componen la encuesta
define("numSemanas",20);// numero de semanas del año
//$arrayTiempos	= array();
//$arrayTiempos['t_reunion'] = 'Reuniones Para Ajustar Objetivos, Tiempos Y Otros';
//$arrayTiempos['t_entrega_material'] = 'Entrega De Materiales Para El Desarrollo Del Estudio';
//$arrayTiempos['t_elab_instrumento'] = 'Elaboración De Instrumentos De Recolección';
//$arrayTiempos['t_aprob_instrumento'] = 'Aprobación De Instrumento De Recolección Y Aprobación De Análisis Específicos A Desarrolar';
//$arrayTiempos['t_recoleccion_info'] = 'Recoleccion De La Información';
//$arrayTiempos['t_procesamiento'] = 'Procesamiento Y Análisis';
//$arrayTiempos['t_resultados'] = 'Entrega De Resultados Informes Y Otros';
$sup = "
<Table Width='100%' Border='0' Align='Center' Cellpadding='0' Cellspacing='0'>
<TR> 
	<TD align='left' width='13'><IMG src='/imagenes/coo_bsi_4.jpg' width='13' height='9'></TD>
	<TD align='center' valign='top' bgcolor='#FFFFFF'>
	<IMG src='/imagenes/coo_lh_4.gif' width='100%' height='1'></TD>
	<TD align='right' width='13'><IMG src='/imagenes/coo_bsd_4.gif' width='13' height='9'></TD>
	</TR>
	<TR> 
	<TD width='13' bgcolor='#FFFFFF' background='/imagenes/coo_lvi_4.gif' align='left'>
	<IMG src='/imagenes/coo_lv_4.gif' width='1' height='100%'></TD>
	<TD bgcolor='#FFFFFF'>";

$inf = "
</td>
	<TD width='13'bgcolor='#FFFFFF' background='/imagenes/coo_lvd_4.gif' align='right'>
	<IMG src='/imagenes/coo_lv_4.gif' width='1' height='100%'></TD>
	</TR>
	<TR> 
	<TD width='13' align='left'><IMG src='/imagenes/coo_bii_4.gif' width='13' height='9'></TD>
	<TD align='center' bgcolor='#FFFFFF' valign='bottom'>
	<IMG src='/imagenes/coo_lh_4.gif' width='100%' height='1'></TD>
	<TD width='13' align='right'><IMG src='/imagenes/coo_bid_4.gif' width='13' height='9'></TD>
	</TR>
    </table>";
?>

