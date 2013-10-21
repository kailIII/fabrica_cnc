<?php
// para concatenar celdas
//http://tegarrputra.wordpress.com/2011/11/02/merging-cells-in-msword-2007-table-using-phpword/

require_once dirname(__FILE__).'/classes/class.Propuesta.php';
$PropuestaDoc = new Propuesta(  $idPropuesta );

require_once dirname(__FILE__).'/classes/class.Contenidos.php';
$ContenidosDoc = new Contenidos;

require_once dirname(__FILE__).'/classes/class.Metodologia.php';
$Metodologia = new Metodologia( $idPropuesta );

require_once dirname(__FILE__).'/classes/class.SqlQuery.php';
$SqlQuery = new SqlQuery;

$info_prop = $PropuestaDoc->getProp();

include_once("../connection.php");
include_once("../libreria.php");

include_once("sql_vista_previa.php");


require_once '../PHPWord.php';
// New Word Document
$PHPWord = new PHPWord();

//---- valores por defecto
$PHPWord->setDefaultFontName('Arial');
$PHPWord->setDefaultFontSize(12);
//---- propiedades del documento
$properties = $PHPWord->getProperties();
$properties->setCreator('Centro Nacional de Consultoría'); 
$properties->setCompany('Centro Nacional de Consultoría');
$properties->setTitle('Propuesta');
$properties->setDescription('Propuesta de valor'); 
$properties->setCategory('Vicepresidencia Comercial');
$properties->setLastModifiedBy('Willian Valencia');
$properties->setCreated( mktime(0, 0, 0, 3, 12, 2010) );
$properties->setModified( mktime(0, 0, 0, 3, 14, 2010) );
$properties->setSubject('La propuesta'); 
$properties->setKeywords('my, key, word');

// New portrait section
//$section = $PHPWord->createSection(array('borderColor'=>'00FF00', 'borderSize'=>12));
$sectionStyle = array('orientation' => null,
			    'marginLeft' => 1100,
			    'marginRight' => 1100,
			    'marginTop' => 2000,
			    'marginBottom' => 900,
				'pageSizeW'=>12240,
				'pageSizeH'=>15940);
$section = $PHPWord->createSection($sectionStyle);

/*$srcFoto	='encabezado.png';
$imageStyle = array('width'=>653, 'height'=>58, 'align'=>'left');
$header = $section->createHeader();
//$header->addPreserveText('CENTRO NACIONAL DE CONSULTORIA');
$header->addImage($srcFoto, $imageStyle);
*/
//---- formato del indicador de páginas
$styleCellPag = array('valign'=>'center');
$fontStylePag		= array('align'=>'center', 'name'=>'Arial', 'size'=>12, 'color'=>'999999');
$fontStylePagAct	= array('bold'=>true, 'align'=>'center', 'name'=>'Arial', 'size'=>12, 'color'=>'4B9700');


// Define el encabezado
$styleBarra		= array('valign'=>'left', 'bgColor'=>'BDD2D1');
$styleBarraAct	= array('valign'=>'left', 'bgColor'=>'009900');
// Define cell style arrays
$styleCell = array('valign'=>'center');
// Define font style for first row
$fontStyle		= array('align'=>'center', 'name'=>'Arial', 'size'=>9, 'color'=>'000000');
$fontStyleAct	= array('bold'=>true, 'align'=>'center', 'name'=>'Arial', 'size'=>9, 'color'=>'000000');

$header = $section->createHeader();
//$header->addPreserveText('CENTRO NACIONAL DE CONSULTORIA');
$table = $header->addTable();

// Add row
$table->addRow(-580);

$srcFoto	='../logo_CNC.png';
$imageStyle = array('width'=>181, 'height'=>41, 'align'=>'left');
//$section->addImage($srcFoto, $imageStyle);

$styleUndNeg[1]	= $fontStyle; 
$styleUndNeg[2]	= $fontStyle; 
$styleUndNeg[3]	= $fontStyle; 
$styleUndNeg[4]	= $fontStyle; 
$styleUndNeg[5]	= $fontStyle; 
$styleUndNeg[6]	= $fontStyle; 
$styleUndNeg[7]	= $fontStyle; 

$styleUndNeg[$unidad_negocio]	= $fontStyleAct; 

// Add cells
$table->addCell(3000)->addImage($srcFoto, $imageStyle);
$table->addCell(20)->addText('', $fontStyle);
$table->addCell(1000, $cellStyle)->addText(utf8_decode('Lealtad y relaciones'), $styleUndNeg[1]); 
$table->addCell(20)->addText('', $fontStyle);
$table->addCell(1000, $cellStyle)->addText(utf8_decode('Marca y medios'), $styleUndNeg[2]);
$table->addCell(20)->addText('', $fontStyle);
$table->addCell(1800, $cellStyle)->addText(utf8_decode('Gobierno y asuntos públicos'), $styleUndNeg[3]);
$table->addCell(20)->addText('', $fontStyle);
$table->addCell(1200, $cellStyle)->addText(utf8_decode('Investigación de mercado'), $styleUndNeg[4]);
$table->addCell(20)->addText('', $fontStyle);
$table->addCell(1000, $cellStyle)->addText(utf8_decode('Opinión pública'), $styleUndNeg[5]);
$table->addCell(20)->addText('', $fontStyle);
$table->addCell(1000, $cellStyle)->addText(utf8_decode('Consultoría empresarial'), $styleUndNeg[6]);
$table->addCell(20)->addText('', $fontStyle);
$table->addCell(500, $cellStyle)->addText(utf8_decode('Más...'), $styleUndNeg[7]);

// Add row
$table->addRow(-90);
$styleUndNeg[1]	= $styleBarra; 
$styleUndNeg[2]	= $styleBarra; 
$styleUndNeg[3]	= $styleBarra; 
$styleUndNeg[4]	= $styleBarra; 
$styleUndNeg[5]	= $styleBarra; 
$styleUndNeg[6]	= $styleBarra; 
$styleUndNeg[7]	= $styleBarra; 


// elige el color de la barra adecuado para cada unidad de negocio
switch( $unidad_negocio ){
	
	// lealtad y relaciones
	case 1:
		$color_unidad = "1ca2da";
		break;
	
	// Marca y medios
	case 2:
		$color_unidad = "2aa84a";
		break;
	
	// gobierno y asuntos publicos
	case 3:
		$color_unidad = "f2cc10";
		break;
	
	// investigacion de mercado
	case 4:
		$color_unidad = "f39320";
		break;
	
	// opinion publica
	case 5:
		$color_unidad = "f28121";
		break;
	
	// consultoria empresarial
	case 6:
		$color_unidad = "0082c5";
		break;
}


$styleBarraAct	= array('valign'=>'left', 'bgColor'=> $color_unidad );

$styleUndNeg[$unidad_negocio]	= $styleBarraAct; 

// Add cells
$table->addCell(0)->addText('', $fontStyle);
$table->addCell(0)->addText('', $fontStyle);
$table->addCell(0, $styleUndNeg[1])->addText('');
$table->addCell(0)->addText('');
$table->addCell(0, $styleUndNeg[2])->addText('');
$table->addCell(0)->addText('');
$table->addCell(0, $styleUndNeg[3])->addText('');
$table->addCell(0)->addText('');
$table->addCell(0, $styleUndNeg[4])->addText('');
$table->addCell(0)->addText('');
$table->addCell(0, $styleUndNeg[5])->addText('');
$table->addCell(0)->addText('');
$table->addCell(0, $styleUndNeg[6])->addText('');
$table->addCell(0)->addText('');
$table->addCell(0, $styleUndNeg[7])->addText('');
//----

$footer = $section->createFooter();

////---- crear línea
//$styleTable = array('borderSize'=>1, 'borderColor'=>$colorLinea, 'cellMargin'=>0);
//// Add table style
//$PHPWord->addTableStyle('myOwnTableStyle', $styleTable);
//// Add table
//$table = $footer->addTable('myOwnTableStyle');
//// Add row
//$table->addRow(-1);
//// Add cells
//$table->addCell(10000)->addText('');


//$footer->addPreserveText(utf8_decode('Página').' {PAGE} de {NUMPAGES}.', array('align'=>'right'));
$cellStyle = array('name'=>'Arial', 'size'=>9, 'color'=>'333333');
//$footer->addPreserveText(utf8_decode('Página').' {PAGE} de {NUMPAGES}', $cellStyle, array('align'=>'right'));
$footer->addPreserveText(utf8_decode('Página | ').'{PAGE}', $cellStyle, array('align'=>'right'));


//----
$PHPWord->addFontStyle('titleStyle', array('name'=>'Arial', 'size'=>35, 'color'=>'7d949c', 'bold' => true ));
$PHPWord->addFontStyle('empStyle', array('name'=>'Arial', 'size'=>28, 'color'=>'7d949c'));

//----
$section->addTextBreak(2);
$section->addText($empresa_cliente, 'empStyle');
$section->addTextBreak(1);

//---- longitud de las líneas usadas
$longLinea	= 9000;
$colorLinea	= '999999';

//---- crear línea
$styleTable = array('borderSize'=>1, 'borderColor'=>$colorLinea, 'cellMargin'=>0);
// Add table style
$PHPWord->addTableStyle('myOwnTableStyle', $styleTable);
// Add table
$table = $section->addTable('myOwnTableStyle');
// Add row
$table->addRow(-1);
// Add cells
$table->addCell($longLinea)->addText('');


$tamano_titulo = strlen( $titulo );

if( $tamano_titulo <= 50 ){
	$PHPWord->addFontStyle('mainTitleStyle', array('name'=>'Arial', 'size'=>35, 'color'=>'000000', 'bold' => false ));
} else if( $tamano_titulo <= 82 ){
	$PHPWord->addFontStyle('mainTitleStyle', array('name'=>'Arial', 'size'=>28, 'color'=>'000000', 'bold' => false ));
} else {
	$PHPWord->addFontStyle('mainTitleStyle', array('name'=>'Arial', 'size'=>14, 'color'=>'000000', 'bold' => false ));
}

//$section->addTextBreak();
$section->addText($titulo, 'mainTitleStyle');
//----
$section->addTextBreak(2);

//---- crear línea
$styleTable = array('borderSize'=>1, 'borderColor'=>$colorLinea, 'cellMargin'=>0);
// Add table style
$PHPWord->addTableStyle('myOwnTableStyle', $styleTable);
// Add table
$table = $section->addTable('myOwnTableStyle');
// Add row
$table->addRow(-1);
// Add cells
$table->addCell($longLinea)->addText('');

$cellStyle = array('name'=>'Arial', 'size'=>12, 'color'=>'808080', 'bold' => true );
$table = $section->addTable();
$table->addRow(-330);
$table->addCell(6000)->addText('SOLICITUD/CONTACTOS', $cellStyle );
$table->addCell(6000)->addText('');

$clientes = $PropuestaDoc->getPropClientes();
$num_clientes = count($clientes);


$cellStyle = array('name'=>'Arial', 'size'=>12, 'color'=>'808080');

for( $i = 0; $i < $num_clientes; ){

	$table->addRow(-330);	
	
	$table->addCell(6000)->addText($clientes[$i]['nombre'], $cellStyle );
	if( isset( $clientes[$i+1]['nombre'] ) ){
		$table->addCell(6000)->addText($clientes[$i+1]['nombre'], $cellStyle );		
	} else{
		$table->addCell(6000)->addText('');
	}

	$table->addRow(-330);
	$table->addCell(6000)->addText($clientes[$i]['cargo'], $cellStyle );
	if( isset( $clientes[$i+1]['cargo'] ) ){
		$table->addCell(6000)->addText($clientes[$i+1]['cargo'], $cellStyle );		
	} else{
		$table->addCell(6000)->addText('');
	}

	$table->addRow(-330);
	$table->addCell(6000)->addText($clientes[$i]['email'], $cellStyle );
	if( isset( $clientes[$i+1]['email'] ) ){
		$table->addCell(6000)->addText($clientes[$i+1]['email'], $cellStyle );		
	} else{
		$table->addCell(6000)->addText('');
	}


	$table->addRow(-330);
	$table->addCell(6000)->addText($clientes[$i]['telefono'].' - '.$clientes[$i]['celular'], $cellStyle );
	if( isset( $clientes[$i+1]['telefono'] ) && isset( $clientes[$i+1]['celular']  )){
		$table->addCell(6000)->addText( $clientes[$i+1]['telefono'].' - '.$clientes[$i+1]['celular'], $cellStyle );		
	} else{
		$table->addCell(6000)->addText('');
	}

	$table->addRow(-330);
	$table->addCell(6000)->addText('');
	$table->addCell(6000)->addText('');

	$i+=2;
}


/*foreach ( $clentes as $cliente ){

	$table->addRow(-330);
	$table->addCell(12000, $cellStyle)->addText($cliente['nombre']);
	$table->addRow(-330);
	$table->addCell(12000, $cellStyle)->addText($cliente['cargo']);
	$table->addRow(-330);
	$table->addCell(12000, $cellStyle)->addText($cliente['email']);
	$table->addRow(-330);
	$table->addCell(12000, $cellStyle)->addText($cliente['telefono'].' - '.$cliente['celular']);

}*/




//----
$section->addTextBreak();

$cellStyle = array('name'=>'Arial', 'size'=>9.5, 'color'=>'808080');
$table = $section->addTable();
$table->addRow(-330);
$table->addCell(6000)->addText('Presentada por: ' . $nombreE , $cellStyle );
$table->addCell(6000)->addText('Revisada por: ' . $nombreR , $cellStyle );
// $table->addRow(-330);
// $table->addCell(6000)->addText($nombreE, $cellStyle );
// $table->addCell(6000)->addText($nombreR, $cellStyle );
$table->addRow(-330);
$table->addCell(6000)->addText($cargoE, $cellStyle );
$table->addCell(6000)->addText($cargoR, $cellStyle );
$table->addRow(-330);
$table->addCell(6000)->addText($emailE, $cellStyle );
$table->addCell(6000)->addText($emailR, $cellStyle );
$table->addRow(-330);

if( !empty( $celularE ) ){
	$table->addCell(6000)->addText($telefonoE.' - Cel: '.$celularE, $cellStyle );	
} else {
	$table->addCell(6000)->addText($telefonoE, $cellStyle );	
}

if( !empty( $celularR ) ){
	$table->addCell(6000)->addText($telefonoR.' - Cel: '.$celularR, $cellStyle );
} else {
	$table->addCell(6000)->addText($telefonoR, $cellStyle );	
}

//----
$arryaFechaP	= explode('-',$fechaPropuesta);
$anioP		= $arryaFechaP[0];
$mesP		= $arryaFechaP[1];
$diaP		= $arryaFechaP[2];
$nomMes		= strtolower($arrayNomMes[$mesP]);
$fecha_text = utf8_decode("Bogotá, $diaP de $nomMes de $anioP"); 
//----
$section->addTextBreak(2);
$section->addText($fecha_text, array('align'=>'left','color' => '808080', 'bold' => true ));
$srcFoto	='address.jpeg';
$imageStyle = array('width'=>690, 'height'=>69, 'align'=>'left');
$section->addImage($srcFoto, $imageStyle);



/*$PHPWord->addFontStyle('footer1Style', array('name'=>'Arial', 'size'=>10, 'color'=>'000000', 'bold' => true ));

$section->addText( utf8_decode("Centro Nacional de Consultoría S.A."),  'footer1Style' );
$section->addTextBreak(1);
$PHPWord->addFontStyle('footer2Style', array('name'=>'Arial', 'size'=>10, 'color'=>'000000', 'bold' => true ));
$section->addText( utf8_decode("Calle 34 N° 5-27 Bogotá D.C. / Teleéfono (1) 3 39 48 48 - Fax : (1) 2 87 26 70"), 'footer2Style' );
$section->addTextBreak(1);*/


//$PHPWord->addFontStyle('footerE1', array('bold'=>true, 'name'=>'Arial', 'size'=>10, 'color'=>'808080'));
//$section->addText(utf8_decode('Bogotá, 1 de marzo de 2013'), 'footerE1', array('align'=>'left'));
////----
//$PHPWord->addFontStyle('footerE2', array('name'=>'Arial', 'size'=>10, 'color'=>'808080')); 
//$section->addText(utf8_decode('Centro Nacional de Consultoría S.A.'), 'footerE2');
////----
//$section->addText(utf8_decode('Calle 34 Nro. 5 _ 62 Bogotá / Teléfono: 339 48 88 / Fax: 287 26 70'), 'footerE2');
////----
//$section->addText(utf8_decode('www.centronacionaldeconsultoria.com'), 'footerE2');


//---- Página 2
$section->addPageBreak();
//---- consulta las páginas
$table = $section->addTable();
// Add row
$table->addRow();
// Add cells
$table->addCell(5000, $styleCell)->addText('', $fontStylePag);
$pagAct	= 0;
$sql = "SELECT * FROM ".tablaPagina." ORDER BY 1";
//echo '<BR>'.$sql;
$con			= mysql_query($sql);
while($campos	= mysql_fetch_array($con)){
	$id_pagina	= $campos["id_pagina"];
	$nom_pagina	= $campos["nom_pagina"];
	$vb_pagina	= $id_pagina.'.'.$nom_pagina;

	if($id_pagina==$pagAct){
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePagAct);
	}else{
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePag);
	}
}
$section->addTextBreak(1);

//----
$texto1	= utf8_decode("El Centro Nacional de Consultoría es una firma de investigación y consultoría, centrada en la creación de valor a través de la escucha generosa de sus necesidades, el estudio cuidadoso de sus problemas y el desarrollo de soluciones comercialmente viables que les garanticen el progreso.");

$texto2	= utf8_decode("El Centro se compromete con un nuevo liderazgo de servicio construido sobre cuatro dimensiones: el sentido de realidad, la ética, la visión y el coraje para hacer siempre la tarea.");
//----
$section->addTextBreak(1);
$textStyle = array('bold'=>true, 'name'=>'Arial', 'size'=>21, 'color'=>'000000');
$section->addText(utf8_decode('Investigación + conversación = acción'), $textStyle);
$section->addTextBreak(3);
$textStyle = array('name'=>'Arial', 'size'=>14, 'color'=>'000000');


$PHPWord->addParagraphStyle('pjustify', array('align' => 'both', 'spacing' => 120, 'spaceBefore' => 0, 'spaceAfter' => 0 ));
$PHPWord->addParagraphStyle('pjustify_no_spacing', array('align' => 'both', 'spacing' => 0, 'spaceBefore' => 0, 'spaceAfter' => 0 ));


$textrun = $section->createTextRun();
$textrun->addText( 'El ', $textStyle );
$textrun->addText( utf8_decode('Centro Nacional de Consultoría ') , array('name'=>'Arial', 'size'=>14, 'color'=>'000000', 'bold' => true ) );
$textrun->addText( utf8_decode( 'es una firma de investigación y consultoría, centrada en la creación de valor a través de la escucha generosa de sus necesidades, el estudio cuidadoso de sus problemas y el desarrollo de soluciones comercialmente viables que les garanticen el progreso.' ), $textStyle );


/*$textStyle = array('name'=>'Arial', 'size'=>12, 'color'=>'000000' );
$section->addText($texto1, $textStyle, 'pjustify' );*/
$section->addTextBreak(1);
$section->addText($texto2, $textStyle );

// si el contexto esta vacio no genera la pagina
if( !empty( $contexto ) ):
//---- Página 3
$section->addPageBreak();

//---- consulta las páginas
$table = $section->addTable();
// Add row
$table->addRow();
// Add cells
$table->addCell(5000, $styleCell)->addText('', $fontStylePag);
$pagAct	= 1;
$sql = "SELECT * FROM ".tablaPagina." ORDER BY 1";
//echo '<BR>'.$sql;
$con			= mysql_query($sql);
while($campos	= mysql_fetch_array($con)){
	$id_pagina	= $campos["id_pagina"];
	$nom_pagina	= $campos["nom_pagina"];
	$vb_pagina	= $id_pagina.'.'.$nom_pagina;

	if($id_pagina==$pagAct){
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePagAct);
	}else{
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePag);
	}
}
$section->addTextBreak(1);
//----
//$section->addTextBreak(1);
$section->addText('CONTEXTO', 'titleStyle');
$section->addTextBreak(3);
//----
$cellStyle = array('name'=>'Arial', 'size'=>14);
//$arrayLiTexto	= nl2br($introduccion_met);
$arrayLiTexto	= str_replace(Chr(13), "||", $contexto);  
$arrayLiTexto	= explode('||',$arrayLiTexto);
foreach($arrayLiTexto as $ind => $vbIntMed){
	if(!empty($vbIntMed)){
		$vbIntMed	= trim($vbIntMed);
		$caracter1	= substr($vbIntMed,0,1);
		if($caracter1=='*'){
			$textoLI	= trim(substr($vbIntMed,1));
			$section->addListItem($textoLI, 0, $cellStyle, 'pjustify' );
		}
		else{
			$section->addText($vbIntMed, $cellStyle, 'pjustify' );
		}
	}
	else{
		$section->addTextBreak();
	}
}
//----
endif;
// page 4 objetivos
// si hay objetivo general 
if( !empty( $objetivo_general ) ):
$section->addPageBreak();

//---- consulta las páginas
$table = $section->addTable();
// Add row
$table->addRow();
// Add cells
$table->addCell(5000, $styleCell)->addText('', $fontStylePag);
$pagAct	= 2;
$sql = "SELECT * FROM ".tablaPagina." ORDER BY 1";
//echo '<BR>'.$sql;
$con			= mysql_query($sql);
while($campos	= mysql_fetch_array($con)){
	$id_pagina	= $campos["id_pagina"];
	$nom_pagina	= $campos["nom_pagina"];
	$vb_pagina	= $id_pagina.'.'.$nom_pagina;

	if($id_pagina==$pagAct){
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePagAct);
	}else{
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePag);
	}
}
$section->addTextBreak(1);


	$section->addText('OBJETIVO', 'titleStyle');
	$section->addTextBreak(3);
	$cellStyle = array('name'=>'Arial', 'size'=>14);
	$section->addText($objetivo_general, $cellStyle, 'pjustify' );
	$section->addTextBreak(1);
	$cellStyle = array('name'=>'Arial', 'size'=>14, 'bold'=>true);

endif; // fin emtpy obj_gen obj_esps

if( !empty( $objetivos_especificos ) ):
	$section->addPageBreak();
	
	//---- consulta las páginas
	$table = $section->addTable();
	// Add row
	$table->addRow();
	// Add cells
	$table->addCell(5000, $styleCell)->addText('', $fontStylePag);
	$pagAct	= 2;
	$sql = "SELECT * FROM ".tablaPagina." ORDER BY 1";
	//echo '<BR>'.$sql;
	$con			= mysql_query($sql);
	while($campos	= mysql_fetch_array($con)){
		$id_pagina	= $campos["id_pagina"];
		$nom_pagina	= $campos["nom_pagina"];
		$vb_pagina	= $id_pagina.'.'.$nom_pagina;
	
		if($id_pagina==$pagAct){
			$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePagAct);
		}else{
			$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePag);
		}
	}
	$section->addTextBreak(1);
	
	$section->addText('OBJETIVOS ESPECIFICOS', 'titleStyle' );
	$section->addTextBreak(3);
	
	$cellStyle = array('name'=>'Arial', 'size'=>14);
	if(!empty($objetivos_especificos)){
		$objetivos_especificos	= explode('||',$objetivos_especificos);
		$numberStyleList = array('listType' => PHPWord_Style_ListItem::TYPE_NUMBER_NESTED);
		foreach($objetivos_especificos as $ind => $vbObjetivo){
			//echo '<BR>ind: '.$ind.' vbObjetivo: '.$vbObjetivo;
			
			// añade subniveles cada enter \n seguido de un *
			$spaced_obj = explode("\n", $vbObjetivo);
			foreach( $spaced_obj as $txt ){
				if( $txt[0] == '*' ){
	
					$txt_2 = substr_replace($txt ,"",0,1);
					$section->addListItem($txt_2, 1, $cellStyle, $numberStyleList, 'pjustify' );
	
				} else{
					$section->addListItem($txt, 0, $cellStyle, $numberStyleList, 'pjustify' );
					$section->addTextBreak(1);
				}
			}
			
			$section->addTextBreak(1);
		}
	}
endif;

//---- metodologías
$section->addPageBreak();
//---- consulta las páginas
$table = $section->addTable();
// Add row
$table->addRow();
// Add cells
$table->addCell(5000, $styleCell)->addText('', $fontStylePag);
$pagAct	= 3;
$sql = "SELECT * FROM ".tablaPagina." ORDER BY 1";
//echo '<BR>'.$sql;
$con			= mysql_query($sql);
while($campos	= mysql_fetch_array($con)){
	$id_pagina	= $campos["id_pagina"];
	$nom_pagina	= $campos["nom_pagina"];
	$vb_pagina	= $id_pagina.'.'.$nom_pagina;

	if($id_pagina==$pagAct){
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePagAct);
	}else{
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePag);
	}
}
$section->addTextBreak(1);
//----
$section->addText('METODOLOGIAS', 'titleStyle');
$section->addTextBreak(3);
//----
$cellStyle = array('name'=>'Arial', 'size'=>14);
//$arrayLiTexto	= nl2br($introduccion_met);
$arrayLiTexto	= str_replace(Chr(13), "||", $introduccion_met);  
$arrayLiTexto	= explode('||',$arrayLiTexto);
foreach($arrayLiTexto as $ind => $vbIntMed){
	if(!empty($vbIntMed)){
		$vbIntMed	= trim($vbIntMed);
		$caracter1	= substr($vbIntMed,0,1);
		if($caracter1=='*'){
			$textoLI	= trim(substr($vbIntMed,1));
			$section->addListItem($textoLI, 0, $cellStyle);
		}
		else{
			$section->addText($vbIntMed, $cellStyle);
		}
	}
	else{
		$section->addTextBreak();
	}
	
}

$section->addTextBreak();

//----
$cellStyle = array('name'=>'Arial', 'size'=>14, 'color'=>'333333');
$table = $section->addTable();
//---- consulta las metodologías de la propuesta
$sql = "SELECT *
 FROM ".tablaMetodologia." M INNER JOIN ".tablaMetodologiaRTA." R USING(id_metodologia)
  WHERE R.id_propuesta=$idPropuesta
   ORDER BY id_row_metodologia";
//echo '<BR>'.$sql;
$filasMetodologias		= NULL;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	
	$id_metodologia		= $campos["id_metodologia"];
	$nom_metodologia	= $campos["nom_metodologia"];
	$id_row_metodologia	= $campos["id_row_metodologia"];
	$titulo				= $campos["titulo"];
	$temas				= $campos["temas"];
	$universo			= $campos["universo"];
	$marco_estadistico	= $campos["marco_estadistico"];
	
	$id_tipo_metodologia	= $campos["id_tipo_metodologia"];
	$met_info 				= $ContenidosDoc->getMetodologia($id_metodologia);
	$met_selected 	= $Metodologia->getMetSelected( $campos["new_id_row_metodologia"] );

	$fontStyleTit		= array('bold'=>true, 'name'=>'Arial', 'size'=>14, 'color'=>'333333');

	$table->addRow();
	$table->addCell(0, $cellStyle)->addText(utf8_decode('Título:'));
	$table->addCell(0, $cellStyle)->addText($titulo, $fontStyleTit);
	if(!empty($temas)){
		$table->addRow();
		$table->addCell(0, $cellStyle)->addText('Temas:');
		// $table->addCell(0, $cellStyle)->addText($temas);
		
		$this_cell = $table->addCell(0, $cellStyle);		
		$temas = trim($temas);
		$spaced_txt = explode("\n", $temas);
		foreach( $spaced_txt as $txt ){
				
			
			if( $txt[0] == '*' ) {
		
				$item = substr_replace($txt ,"",0,1);
				$this_cell->addListItem($item,0);
				$section->addTextBreak(1);		
			} else if ( $txt[1] == '*' ){
				
				$item = substr_replace($txt ,"",0,2);
				$this_cell->addListItem($item,0);
				$section->addTextBreak(1);
				
			} else {
				$item = $txt;
				$this_cell->addText($item);
			}
		}
		
	}
	$table->addRow();
	$table->addCell(4000, $cellStyle)->addText(utf8_decode('Metodología:'));
	$table->addCell(6000, $cellStyle)->addText($nom_metodologia);

	if(!empty($universo)){
		$table->addRow();
		$table->addCell(0, $cellStyle)->addText( $campos["titulo_universo"].':');
		$table->addCell(0, $cellStyle)->addText($universo);
	}
	
	if( $campos["a_tam_poblacion"] == 1 && !empty( $met_selected["tamano_poblacion"] ) ){
		$table->addRow();
		$table->addCell(0, $cellStyle)->addText( $campos["titulo_tam_poblacion"].':' );
		$table->addCell(0, $cellStyle)->addText( $met_selected["tamano_poblacion"] );
	}
	
	if( $campos["a_tecnica_recoleccion"] == 1 && !empty( $met_selected["id_pob_objetivo"] ) && $met_selected["id_pob_objetivo"] != 0 ){
			
		$pob_objetivo_str = $ContenidosDoc->getPobObjetivo( $met_selected["id_pob_objetivo"] );
		$pob_objetivo_str = $pob_objetivo_str["des_pob_objetivo"];
			
		if( !empty( $pob_objetivo_str ) ){
			$table->addRow();
			$table->addCell(0, $cellStyle)->addText( $campos["titulo_tecnica_recoleccion"].':' );
			$table->addCell(0, $cellStyle)->addText( $pob_objetivo_str );
		}
	}
	
	if( $campos["a_marco_muestral"] == 1 && !empty( $met_selected["id_origen_db"] ) && $met_selected["id_origen_db"] != 0 ){
			
		$origen_db_str = $ContenidosDoc->getOrigenDbById( $met_selected["id_origen_db"] );
		$origen_db_str = $origen_db_str["nom_origen_db"];
			
		if( !empty( $origen_db_str ) ){
			$table->addRow();
			$table->addCell(0, $cellStyle)->addText( $campos["titulo_marco_muestral"].':' );
			$table->addCell(0, $cellStyle)->addText( $origen_db_str );
		}
	}
	
	if( $campos["a_dificultad"] == 1 && !empty( $met_selected["id_nivel_aceptacion"] ) && $met_selected["id_nivel_aceptacion"] != 0 ){
			
		$dificultad_str = $ContenidosDoc->getNivelAceptacionById( $met_selected["id_nivel_aceptacion"] );
		$dificultad_str = $dificultad_str["des_nivel_aceptacion"];
		
			
		if( !empty( $dificultad_str ) ){
			$table->addRow();
			$table->addCell(0, $cellStyle)->addText( $campos["titulo_dificultad"].':' );
			$table->addCell(0, $cellStyle)->addText( $dificultad_str );
		}
	}

	if($id_tipo_metodologia==3){
		
		if(!empty($marco_estadistico)){
			$table->addRow();
			$table->addCell(0, $cellStyle)->addText(utf8_decode('Marco estadístico:'));
			$table->addCell(0, $cellStyle)->addText($marco_estadistico);
		}
	}
	
	$sqlR = "SELECT *
	 FROM ".tablaSegmentoMetodologiaRTA." R
	  WHERE R.id_propuesta=$idPropuesta AND R.id_row_metodologia=$id_row_metodologia";
	  
	$prev_seg_met = $SqlQuery->GetRow( $sqlR );
	$id_duracion = $prev_seg_met["id_duracion"];
	
	if( $met_info['a_duracion'] == 1 && !empty( $id_duracion ) && $id_duracion != 0 ){
		
		$duracion_str = $ContenidosDoc->getDuracion($id_duracion);
		$duracion_str = $duracion_str["duracion"];
		
		
		if( !empty($duracion_str) ){
			
			$table->addRow();
			$table->addCell(0, $cellStyle)->addText( $campos["titulo_duracion"] );
			$table->addCell(0, $cellStyle)->addText( $duracion_str );	
		}
		
	}
	
	//---- consulta los segmentos de la metodología
	$sqlR = "SELECT *
	 FROM ".tablaSegmentoMetodologiaRTA." R
	  WHERE R.id_propuesta=$idPropuesta AND R.id_row_metodologia=$id_row_metodologia";
	//echo '<BR>'.$sqlR;
	$conR						= mysql_query($sqlR);
	while($camposR				= mysql_fetch_array($conR)){
		$nom_segmento			= $camposR["nom_segmento"];
		$universo				= $camposR["universo"];
		$muestra				= $camposR["muestra"];
		$error_muestral			= $camposR["error_muestral"];
		$lugar					= $camposR["lugar"];
		$duracion				= $camposR["duracion"];
		$id_duracion 			= $camposR["id_duracion"];
		
		$id_pob_objetivo_r		= $camposR["id_pob_objetivo"];
		$id_duracion_r			= $camposR["id_duracion"];
		$id_nivel_aceptacion_r	= $camposR["id_nivel_aceptacion"];
		$id_cobertura_r			= $camposR["id_cobertura"];
		
		$id_metodologia 		= $camposR["id_metodologia"];
		
		$met_info 				= $ContenidosDoc->getMetodologia($id_metodologia);
		
		
		
		// cualitativos
		/*if( $id_tipo_metodologia == 2 ){
			
			if(!empty($nom_segmento)){
				$table->addRow();
				$table->addCell(0, $cellStyle)->addText(utf8_decode('Ciudad:'));
				$table->addCell(0, $cellStyle)->addText($nom_segmento);
			}
			
			
			if(!empty($muestra)){
				$table->addRow();
				$table->addCell(0, $cellStyle)->addText(utf8_decode('Número de sesiones:'));
				$table->addCell(0, $cellStyle)->addText($muestra);
			}
		}*/
		
		// cuantitativos
		/*if( $id_tipo_metodologia ==3 ){
			if( !empty($nom_segmento) ){
				$table->addRow();
				$table->addCell(0, $cellStyle)->addText(utf8_decode('Segmento:'));
				$table->addCell(0, $cellStyle)->addText($nom_segmento);
			}
			
			if(!empty($muestra)){
				$table->addRow();
				$table->addCell(0, $cellStyle)->addText(utf8_decode('Muestra:'));
				$table->addCell(0, $cellStyle)->addText($muestra);
			}
			
			if(!empty($error_muestral)){
				$table->addRow();
				$table->addCell(0, $cellStyle)->addText(utf8_decode('Error muestral:'));
				$table->addCell(0, $cellStyle)->addText($error_muestral.'%');
			}
		}*/
		
		
				
		
	}

	$table->addRow();
	$table->addCell(0, $cellStyle)->addText('');
	$table->addCell(0, $cellStyle)->addText('');
	
	
	
}



// tabla de segmentos y metodologias
$section->addPageBreak();
// Define table style arrays
$styleTable 	= array('borderSize'=>1, 'borderColor'=>'CCCCCC', 'cellMargin'=>20);

// Define cell style arrays
$styleCell 		= array('valign'=>'center', 'align'=>'center');
$styleCellBTLR 	= array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);

// Define font style for first row
$fontStyle 		= array('bold'=>true, 'size'=>11, 'align'=>'center');

// Add table style
$PHPWord->addTableStyle('tablaSegmentosStyle', $styleTable);


$metodologias_prop 		= $Metodologia->getPropMetodologias();
$fontStyle 				= array('name'=>'Arial', 'size'=>9, 'align' => 'center' );
$titleStyle 			= array('name'=>'Arial', 'size'=>9, 'align' => 'center', 'bold' => true );
$paragraphStyleCenter 	= array('align'=>'center', 'spaceBefore'=>20, 'spacing'=>30);
$cell_width 			= 1500;

foreach( $metodologias_prop as $met_selected ){

	$is_presencial = $met_selected['is_presencial'];
	
	$query 				= "SELECT * FROM prop_tipo_cuantitativo WHERE id_tipo_cuantitativo = {$met_selected['id_tipo_cuantitativo']}";
	$tipo_cuant 		= $SqlQuery->GetRow($query);
	$is_probabilistico 	= $tipo_cuant['probabilistico'];
	$id_row_met 		= $met_selected["id_row_metodologia"];

	$is_presencial = FALSE; // anula la cobertura

	

	// si la tabla es de 1 x 1 no se muestra en el output
	if( count( $Metodologia->getTableVarianzas($id_row_met) ) >= 1  && count( $Metodologia->getTableSegmentos($id_row_met) ) > 1 ){

		$section->addText( $met_selected["nom_metodologia"].': '.$met_selected["titulo"] );
		$table = $section->addTable('tablaSegmentosStyle');		
		
		// fase 1 header//
		$table->addRow();
		$table->addCell( $cell_width, $styleCell )->addText('Segmento', $titleStyle, $paragraphStyleCenter );
		
		foreach( $Metodologia->getTableVarianzas($id_row_met) as $varianza ){
			$table->addCell( $cell_width, $styleCell )->addText( $varianza["nombre_var"], $titleStyle, $paragraphStyleCenter );	
		}
		
		$table->addCell( $cell_width, $styleCell )->addText('Total', $titleStyle, $paragraphStyleCenter );
		
		if( $is_probabilistico == 1 ){
			$table->addCell( $cell_width, $styleCell )->addText('Error', $titleStyle, $paragraphStyleCenter );
		}
		
		if( $is_presencial == 1 ){
			$table->addCell( $cell_width, $styleCell )->addText('Cobertura', $titleStyle, $paragraphStyleCenter );
		}

		// fase 2 body segmentos
		foreach( $Metodologia->getTableSegmentos($id_row_met) as $seg_info ){
			$table->addRow();
			$table->addCell($cell_width, $styleCell )->addText( $seg_info['nombre_segmento'], $fontStyle, $paragraphStyleCenter );
			
			foreach( $seg_info['values'] as $seg_val ){
				$table->addCell($cell_width, $styleCell )->addText( $seg_val['value'] , $fontStyle, $paragraphStyleCenter );
			}

			$table->addCell($cell_width, $styleCell )->addText( $seg_info['total_segmento'] , $fontStyle, $paragraphStyleCenter );
			
			if( $Metodologia->isProbabilistico($id_row_met) ){
				$table->addCell( $cell_width, $styleCell )->addText( $seg_info['error_segmento'].'%' , $fontStyle, $paragraphStyleCenter );
			}
			
			if( $is_presencial == 1 ){
				$cobertura = $ContenidosDoc->getCoberturaById( $seg_info['id_cobertura'] );
				$table->addCell( $cell_width, $styleCell )->addText( $cobertura["nom_cobertura"] , $fontStyle, $paragraphStyleCenter ); 
			}
		}
		
		// fase 3 resultados //
		$table->addRow();
		$table->addCell( $cell_width, $styleCell )->addText( 'Total' , $fontStyle, $paragraphStyleCenter );
		$totales = $Metodologia->getTableTotales( $id_row_met );
		
		foreach( $totales as $tot_val ){
			$table->addCell( $cell_width, $styleCell )->addText( $tot_val['value'] , $fontStyle, $paragraphStyleCenter );
		}

		$table->addCell( $cell_width, $styleCell )->addText( $totales[0]['total'] , $fontStyle, $paragraphStyleCenter );
		
		if( $Metodologia->isProbabilistico($id_row_met) ){
			$table->addCell( $cell_width, $styleCell )->addText( $totales[0]['error'].'%' , $fontStyle, $paragraphStyleCenter );
		}

		if( $is_presencial == 1 ){
			$table->addCell( $cell_width, $styleCell )->addText( '-' , $fontStyle, $paragraphStyleCenter );
		}
		
		if( $Metodologia->isProbabilistico($id_row_met) ){
			$table->addRow();
			$table->addCell( $cell_width, $styleCell )->addText( 'Error' , $fontStyle, $paragraphStyleCenter );
			
			$errores = $Metodologia->getTableErrores($id_row_met);
			
			foreach( $errores as $error ){
				$table->addCell( $cell_width, $styleCell )->addText( $error['value'].'%' , $fontStyle, $paragraphStyleCenter );
			}
			
			$table->addCell( $cell_width, $styleCell )->addText( $error['total'].'%' , $fontStyle, $paragraphStyleCenter );
			$table->addCell( $cell_width, $styleCell )->addText( '-' , $fontStyle, $paragraphStyleCenter );
			
			if( $is_presencial == 1 ){
				$table->addCell( $cell_width, $styleCell )->addText( '-' , $fontStyle, $paragraphStyleCenter );
			}
		}
		
		$section->addTextBreak();

	}
}	


//---- calendario
$section->addPageBreak();
//---- consulta las páginas
$table = $section->addTable();
// Add row
$table->addRow();
// Add cells
$table->addCell(5000, $styleCell)->addText('', $fontStylePag);
$pagAct	= 3;
$sql = "SELECT * FROM ".tablaPagina." ORDER BY 1";
//echo '<BR>'.$sql;
$con			= mysql_query($sql);
while($campos	= mysql_fetch_array($con)){
	$id_pagina	= $campos["id_pagina"];
	$nom_pagina	= $campos["nom_pagina"];
	$vb_pagina	= $id_pagina.'.'.$nom_pagina;

	if($id_pagina==$pagAct){
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePagAct);
	}else{
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePag);
	}
}
$section->addTextBreak(1);
$section->addText('CALENDARIO', 'titleStyle');
$section->addTextBreak(3);
//---- consulta las semanas del calendario para el proceso actual
$sqlR = "SELECT * FROM ".tablaCalendario." WHERE id_propuesta=".$idPropuesta;
//echo '<BR>'.$sqlR;
$arraySemanas			= array();
$elMayor				= 0;
$conR					= mysql_query($sqlR);
while($camposR			= mysql_fetch_array($conR)){
	$arraySemanas		= explode(',',$camposR["semanas"]);
	rsort($arraySemanas);
	$mayor	= $arraySemanas[0];
	if($mayor > $elMayor){
		$elMayor	= $mayor;
	}
}

// Define table style arrays
$styleTable = array('borderSize'=>1, 'borderColor'=>'000000', 'cellMargin'=>20);
//$styleFirstRow = array('borderBottomSize'=>18, 'borderBottomColor'=>'0000FF', 'bgColor'=>'C0C0C0');
$styleFirstRow = array('bgColor'=>'C0C0C0');

// Define cell style arrays
$styleCell = array('valign'=>'center', 'align'=>'center');
$styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);

// Define font style for first row
$fontStyle = array('bold'=>true, 'size'=>11, 'align'=>'center');

// Add table style
$PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

// Add table
$table = $section->addTable('myOwnTableStyle');

$paragraphStyleCenter = array('align'=>'center', 'spaceBefore'=>20, 'spacing'=>30);
// Add row
$table->addRow(600);
$table->addCell(6000, $styleCell)->addText('Actividades', $fontStyle);
$table->addCell(2000, $styleCell)->addText('Responsable', $fontStyle, $paragraphStyleCenter);

$num_semanas	= $elMayor;
$inicioSemanas	= 1;
// Add cells
for($i=$inicioSemanas; $i <= $num_semanas; $i++){
	$vbSemana	= $i;
	$table->addCell(500, $styleCell)->addText($vbSemana, $fontStyle, $paragraphStyleCenter);
	//$table->addCell(500, $styleCellBTLR)->addText('Row 5', $fontStyle);
}
//----
// $sqlP = "SELECT * FROM ".tablaProceso." ORDER BY id_proceso";
$sqlP = "SELECT * FROM ".tablaProceso." WHERE id_propuesta = {$idPropuesta} ORDER BY id_proceso";
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
	}
	$colsSemanas	= NULL;
	//---- add filas
	$paragraphStyle	= array('align'=>'center', 'spaceBefore'=>20, 'spacing'=>30);
	$table->addRow();
	$fontStyle = array('name'=>'Arial', 'size'=>9);
	$table->addCell(6000)->addText($nom_proceso, $fontStyle);
	$table->addCell(2000, $styleCell)->addText($responsable, $fontStyle, $paragraphStyle);
	for($i=$inicioSemanas; $i <= $num_semanas; $i++){
		$vbSemana	= $i;

		$cellStyle = array('bgColor'=>'FFFFFF');
		if(in_array($i, $arraySemanas)){
			$cellStyle = array('bgColor'=>'3399FF');
		}
		$table->addCell(500, $cellStyle)->addText('');
	}
}
$section->addTextBreak();

$cellStyle = array('name'=>'Arial', 'size'=>8);
$dato	= utf8_decode("*Procesamiento y análisis incluye los procesos de elaboración de programas de captura, digitación de la información, crítica y codificación de preguntas abiertas, generación de tabulados y otros análisis estadísticos que se consideren convenientes.");
$section->addText($dato, $cellStyle);

$cellStyle = array('name'=>'Arial', 'size'=>14, 'bold'=>true);
$section->addText(utf8_decode('Ruta Crítica:'), $cellStyle);

$cellStyle = array('name'=>'Arial', 'size'=>14);

$spaced_txt = explode("\n", $info_prop['ruta_critica']);
foreach( $spaced_txt as $txt ){

	if( $txt[0] == '*' ) {

		$item = substr_replace($txt ,"",0,1);
		$section->addListItem($item, 0, $cellStyle, 'pjustify' );
		$section->addTextBreak(1);	
	} else {
		$item = $txt;
		$section->addText($item, $cellStyle, 'pjustify' );
		$section->addTextBreak(1);
	}
}

/*$dato	= utf8_decode("La ruta crítica es la secuencia de los elementos terminales del proyecto que determinan el tiempo en el que es posible completar el proyecto. La duración de la ruta crítica determina la duración del proyecto entero. Cualquier retraso en un elemento de la ruta crítica afecta la fecha de terminación planeada. Los pasos de la ruta crítica son los siguientes:");
$section->addText($dato, $cellStyle);
//$listStyle = array('listType' => PHPWord_Style_ListItem::TYPE_NUMBER);

$item	= utf8_decode("El proceso de planeación en donde se elaboran los formularios, las bases de datos y se revisan los objetivos del proyecto.");
//$section->addListItem($item, 0, null, $listStyle);
$section->addListItem($item, 0, $cellStyle);
$item	= utf8_decode("Una vez aprobados los formularios y guías (todos), las bases de datos, listados y sus muestras se realiza el entrenamiento a encuestadores y se prueban en campo dando inicio a la etapa de recolección de la información (Trabajo de Campo).");
$section->addListItem($item, 0, $cellStyle);
$item	= utf8_decode("Simultáneamente se elaboran los programas de captura y procesamiento, se critican, codifican y digitan las encuestas, a medida que se va realizando el trabajo de campo."); 
$section->addListItem($item, 0, $cellStyle);
$item	= utf8_decode("Una vez terminado la recolección y de digitar todas las encuestas se inicia el procesamiento, generando tablas de tabulación. Por último, con ellas se analizan los resultados y graficados en una presentación de ppt.");
$section->addListItem($item, 0, $cellStyle);*/


//---- Equipo de trabajo
$section->addPageBreak();

//---- consulta las páginas
$table = $section->addTable();
// Add row
$table->addRow();
// Add cells
$table->addCell(5000, $styleCell)->addText('', $fontStylePag);
$pagAct	= 3;
$sql = "SELECT * FROM ".tablaPagina." ORDER BY 1";
//echo '<BR>'.$sql;
$con			= mysql_query($sql);
while($campos	= mysql_fetch_array($con)){
	$id_pagina	= $campos["id_pagina"];
	$nom_pagina	= $campos["nom_pagina"];
	$vb_pagina	= $id_pagina.'.'.$nom_pagina;

	if($id_pagina==$pagAct){
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePagAct);
	}else{
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePag);
	}
}
$section->addTextBreak(1);

$section->addText('EQUIPO DE TRABAJO', 'titleStyle');
$section->addTextBreak(3);

$sql = "SELECT *
 FROM ".tablaEquipoTrabajo." A INNER JOIN ".tablaEquipoTrabajoRTA." B USING(id_persona)
  LEFT JOIN ".tablaRol." C USING(id_rol)
 WHERE id_propuesta=".$idPropuesta."
  ORDER BY A.orden";
//echo '<BR>'.$sql;
$con				= mysql_query($sql);
while($campos		= mysql_fetch_array($con)){
	$id_persona		= $campos["id_persona"];
	$nombre			= $campos["nombre"];
	$cargo			= $campos["cargo"];
	$des_cv			= $campos["des_cv"];
	$nomFoto		= $campos["nom_foto"];
	$nom_rol		= $campos["nom_rol"];
	
	$srcFoto	= dirname(__FILE__).'/../fotos_equipo/'.$nomFoto.'.jpg';
	$imageStyle = array('width'=>230, 'height'=>150, 'align'=>'left');
	$section->addImage($srcFoto, $imageStyle);

	$cellStyle = array('name'=>'Arial', 'size'=>14, 'bold'=>true);
	$section->addText($nombre, $cellStyle, 'pjustify_no_spacing' );

	$cellStyle = array('name'=>'Arial', 'size'=>14);
	$section->addText($nom_rol, $cellStyle, 'pjustify_no_spacing' );
	$section->addTextBreak(1);

	$cellStyle = array('name'=>'Arial', 'size'=>14);
	$section->addText($des_cv, $cellStyle, 'pjustify' );
	$section->addTextBreak(1);
	
	$section->addPageBreak();
	$section->addTextBreak(1);
}

//---- Inversión
// $section->addPageBreak();
//---- consulta las páginas
$table = $section->addTable();
// Add row
$table->addRow();
// Add cells
$table->addCell(5000, $styleCell)->addText('', $fontStylePag);
$pagAct	= 3;
$sql = "SELECT * FROM ".tablaPagina." ORDER BY 1";
//echo '<BR>'.$sql;
$con			= mysql_query($sql);
while($campos	= mysql_fetch_array($con)){
	$id_pagina	= $campos["id_pagina"];
	$nom_pagina	= $campos["nom_pagina"];
	$vb_pagina	= $id_pagina.'.'.$nom_pagina;

	if($id_pagina==$pagAct){
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePagAct);
	}else{
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePag);
	}
}
$section->addTextBreak(1);

$section->addText(utf8_decode('INVERSIÓN'), 'titleStyle');
$section->addTextBreak(2);

// Define table style arrays
$styleTable = array('borderSize'=>1, 'borderColor'=>'000000', 'cellMargin'=>30);
//$styleFirstRow = array('borderBottomSize'=>1, 'borderBottomColor'=>'000000', 'bgColor'=>'C0C0C0');
$styleFirstRow = array('bgColor'=>'C0C0C0');

// Define cell style arrays
// Define font style for first row
$fontStyle = array('bold'=>true, 'size'=>11, 'align'=>'center', 'valign'=>'center');

// Add table style
$PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

// Add table
$table = $section->addTable('myOwnTableStyle');
//----
$styleCell = array('align'=>'right');

$paragraphStyle = array('align'=>'right', 'spaceBefore'=>200, 'spacing'=>30);
//$paragraphStyleLeft		= array('align'=>'left', 'spaceBefore'=>200, 'spaceAfter'=>200, 'spacing'=>200);
$paragraphStyleLeft		= array('align'=>'left', 'spaceBefore'=>200, 'spacing'=>30);
$paragraphStyleCenter	= array('align'=>'center', 'spaceBefore'=>200, 'spacing'=>30);
// Add row
$table->addRow(300);
$table->addCell(100, $styleCell)->addText('No.', $fontStyle, $paragraphStyleCenter);
$table->addCell(8000, $styleCell)->addText(utf8_decode(' Descripción'), $fontStyle, $paragraphStyleLeft);
$table->addCell(2000, $styleCell)->addText('Cantidad', $fontStyle, $paragraphStyleCenter);
$table->addCell(2000, $styleCell)->addText('Valor Unit.', $fontStyle, $paragraphStyleCenter);
$table->addCell(2000, $styleCell)->addText('Valor Total', $fontStyle, $paragraphStyleCenter);

$paragraphStyle = array('align'=>'right', 'spaceBefore'=>100, 'spacing'=>0);
//$paragraphStyleLeft		= array('align'=>'left', 'spaceBefore'=>200, 'spaceAfter'=>200, 'spacing'=>200);
$paragraphStyleLeft		= array('align'=>'left', 'spaceBefore'=>100, 'spacing'=>0);
$paragraphStyleCenter	= array('align'=>'center', 'spaceBefore'=>100, 'spacing'=>0);

//---- add filas
$vbVrDirEstudio	= number_format($vrDirEstudio);

$table->addRow();
$fontStyle		= array('name'=>'Arial', 'size'=>11);
$fontStyleBold	= array('name'=>'Arial', 'bold'=>true, 'size'=>11);
$table->addCell(300)->addText('1', $fontStyle, $paragraphStyleCenter);
$table->addCell(8000)->addText(utf8_decode(' Dirección de estudios'), $fontStyle);
$table->addCell(2000)->addText('1', $fontStyle, $paragraphStyleCenter);
$table->addCell(2000,$styleCell)->addText('$ '.$vbVrDirEstudio.' ', $fontStyle, $paragraphStyle);
$table->addCell(2000,$styleCell)->addText('$ '.$vbVrDirEstudio.' ', $fontStyle, $paragraphStyle);

//---- consulta las metodologías de la propuesta
//---- consulta las metodologías de la propuesta
$sql = "SELECT *
 FROM ".tablaMetodologia." M INNER JOIN ".tablaMetodologiaRTA." R USING(id_metodologia)
  WHERE R.id_propuesta=$idPropuesta
   ORDER BY id_row_metodologia";
//echo '<BR>'.$sql;
$filasInversion		= NULL;
$cont					= 1;
$subTotal				= 0;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	$id_metodologia		= $campos["id_metodologia"];
	$nom_metodologia	= $campos["nom_metodologia"];
	$idTipoMetodologia	= $campos["id_tipo_metodologia"];
	$idRowMetodologia	= $campos["id_row_metodologia"];
	$titulo				= $campos["titulo"];
	$temas				= $campos["temas"];
	$universo			= $campos["universo"];
	$marco_estadistico	= $campos["marco_estadistico"];

	if(!empty($idTipoMetodologia)){
		//---- consulta los segmentos de la metodología
		$sqlR = "SELECT *
		 FROM ".tablaSegmentoMetodologiaRTA." R
		  WHERE R.id_row_metodologia=$idRowMetodologia
		   ORDER BY 1";
		//echo '<BR>'.$sqlR;
		$filasSegmentos			= NULL;
		$conR					= mysql_query($sqlR);
		while($camposR			= mysql_fetch_array($conR)){
			++$cont;
			$id_row_segmento	= $camposR["id_row_segmento"];
			$id_pob_objetivo	= $camposR["id_pob_objetivo"];
			$id_duracion		= $camposR["id_duracion"];
			$id_nivel_aceptacion= $camposR["id_nivel_aceptacion"];
			$id_cobertura		= $camposR["id_cobertura"];
			$id_origen_db		= $camposR["id_origen_db"];
			$nom_segmento		= $camposR["nom_segmento"];
			$universo			= $camposR["universo"];
			$muestra			= $camposR["muestra"];
			$vrUnitario			= $camposR["precio_unitario"];

			/**
			 * Fix Valor unitario en 0
			 * Cuando no existen valores en la BD, se calcula el valor original en vez de mostrar un valor NULL proveniente de la BD ...
			 * ...Que da por resultado 0
			 */

				if( empty($camposR["precio_unitario"]) || trim( $camposR['precio_unitario'] == '' ) ){
					$values = $PropuestaDoc->calcInversion( $idRowMetodologia );
					$vrUnitario = $values['vrUnitario'];
				}
			/*
			 * EOF
			 */

			$vrTotal			= '-';
			if(!empty($muestra)){
				if($muestra*$vrUnitario){
					$vrTotal	= $muestra*$vrUnitario;
					$subTotal	+= $vrTotal;
				}
				//echo '<BR>vrUnitario: '.$vrUnitario;
			}//---- Si tiene definido muestra
			@$vbMuestra		= number_format($muestra);
			@$vbVrUnitario	= number_format($vrUnitario);
			@$vbVrTotal		= number_format($vrTotal);

			$descripcion	= "$nom_metodologia - $nom_segmento";

			//---- add filas
			$table->addRow();
			$fontStyle = array('name'=>'Arial', 'size'=>11);
			$table->addCell(300)->addText($cont, $fontStyle, $paragraphStyleCenter);
			$table->addCell(8000)->addText(' '.$descripcion, $fontStyle, $paragraphStyleLeft);
			$table->addCell(2000, $styleCell)->addText($vbMuestra, $fontStyle, $paragraphStyleCenter);
			$table->addCell(2000, $styleCell)->addText('$ '.$vbVrUnitario, $fontStyle, $paragraphStyle);
			$table->addCell(2000, $styleCell)->addText('$ '.$vbVrTotal, $fontStyle, $paragraphStyle);
		}//---- consulta de segmentos de la metodología
	}
}
//---- consulta los segmentos de la metodología
$sqlR = "SELECT *
 FROM ".tablaInversion." R
   WHERE R.id_propuesta=$idPropuesta AND tabla = 1
   ORDER BY 1";
//echo '<BR>'.$sqlR;
$conR				= mysql_query($sqlR);
while($camposR		= mysql_fetch_array($conR)){
	++$cont;
	$id_producto	= $camposR["id_producto"];
	$descripcion	= $camposR["producto"];
	$muestra		= $camposR["cantidad"];
	$vrUnitario		= $camposR["vr_unitario"];

	$vrTotal			= '-';
	if(!empty($muestra)){
		if($muestra*$vrUnitario){
			$vrTotal	= $muestra*$vrUnitario;
			$subTotal	+= $vrTotal;
		}
		//echo '<BR>vrUnitario: '.$vrUnitario;
	}//---- Si tiene definido muestra
	$vbMuestra		= number_format($muestra);
	$vbVrUnitario	= number_format($vrUnitario);
	$vbVrTotal		= number_format($vrTotal);

	//---- add filas
	$table->addRow();
	$fontStyle = array('name'=>'Arial', 'size'=>11);
	$table->addCell(300)->addText($cont, $fontStyle, $paragraphStyleCenter);
	$table->addCell(8000)->addText(' '.$descripcion, $fontStyle, $paragraphStyleLeft);
	$table->addCell(2000, $styleCell)->addText($vbMuestra, $fontStyle, $paragraphStyleCenter);
	$table->addCell(2000, $styleCell)->addText('$ '.$vbVrUnitario, $fontStyle, $paragraphStyle);
	$table->addCell(2000, $styleCell)->addText('$ '.$vbVrTotal, $fontStyle, $paragraphStyle);
}//---- consulta de segmentos de la metodología


$subTotal		+= $vrDirEstudio;
$vbVrDirEstudio	= number_format($vrDirEstudio);
//---- IVA
$vrIVA			= $subTotal * porcentajeIVA;
$vbVrIVA		= number_format($vrIVA);
//---- sub total
$vbSubTotal		= number_format($subTotal);
//---- gran total
$granTotal		= $subTotal + $vrIVA;
$vbGranTotal	= number_format($granTotal);

// Define font style for first row
//---- add filas
$table->addRow();
$fontStyle		= array('name'=>'Arial', 'size'=>11);
$fontStyleBold	= array('name'=>'Arial', 'bold'=>true, 'size'=>11);
$table->addCell(100)->addText('', $fontStyle);
$table->addCell(8000)->addText(' Subtotal', $fontStyleBold);
$table->addCell(2000)->addText('', $fontStyle);
$table->addCell(2000)->addText('', $fontStyle);
$table->addCell(2000, $styleCell)->addText('$ '.$vbSubTotal, $fontStyle, $paragraphStyle);
//----
$table->addRow();
$table->addCell(100)->addText('', $fontStyle);
$table->addCell(8000)->addText(' IVA', $fontStyleBold);
$table->addCell(2000)->addText('', $fontStyle);
$table->addCell(2000)->addText('', $fontStyle);
$table->addCell(2000, $styleCell)->addText('$ '.$vbVrIVA, $fontStyle, $paragraphStyle);

$table->addRow();
$table->addCell(100)->addText('', $fontStyle);
$table->addCell(8000)->addText(' TOTAL', $fontStyleBold);
$table->addCell(2000)->addText('', $fontStyle);
$table->addCell(2000)->addText('', $fontStyle);
$table->addCell(2000, $styleCell)->addText('$ '.$vbGranTotal, $fontStyleBold, $paragraphStyle);


if( $vrDirEstudio_2 != "0" ){ 

	$subTotal = 0;
	$section->addPageBreak();
	
	$section->addText(utf8_decode('INVERSIÓN 2'), 'titleStyle');
	$section->addTextBreak(2);
	
	// Define table style arrays
	$styleTable = array('borderSize'=>1, 'borderColor'=>'000000', 'cellMargin'=>30);
	//$styleFirstRow = array('borderBottomSize'=>1, 'borderBottomColor'=>'000000', 'bgColor'=>'C0C0C0');
	$styleFirstRow = array('bgColor'=>'C0C0C0');
	
	// Define cell style arrays
	// Define font style for first row
	$fontStyle = array('bold'=>true, 'size'=>11, 'align'=>'center', 'valign'=>'center');
	
	// Add table style
	$PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);
	
	// Add table
	$table = $section->addTable('myOwnTableStyle');
	//----
	$styleCell = array('align'=>'right');
	
	$paragraphStyle = array('align'=>'right', 'spaceBefore'=>200, 'spacing'=>30);
	//$paragraphStyleLeft		= array('align'=>'left', 'spaceBefore'=>200, 'spaceAfter'=>200, 'spacing'=>200);
	$paragraphStyleLeft		= array('align'=>'left', 'spaceBefore'=>200, 'spacing'=>30);
	$paragraphStyleCenter	= array('align'=>'center', 'spaceBefore'=>200, 'spacing'=>30);
	// Add row
	$table->addRow(300);
	$table->addCell(100, $styleCell)->addText('No.', $fontStyle, $paragraphStyleCenter);
	$table->addCell(8000, $styleCell)->addText(utf8_decode(' Descripción'), $fontStyle, $paragraphStyleLeft);
	$table->addCell(2000, $styleCell)->addText('Cantidad', $fontStyle, $paragraphStyleCenter);
	$table->addCell(2000, $styleCell)->addText('Valor Unit.', $fontStyle, $paragraphStyleCenter);
	$table->addCell(2000, $styleCell)->addText('Valor Total', $fontStyle, $paragraphStyleCenter);
	
	$paragraphStyle = array('align'=>'right', 'spaceBefore'=>100, 'spacing'=>0);
	//$paragraphStyleLeft		= array('align'=>'left', 'spaceBefore'=>200, 'spaceAfter'=>200, 'spacing'=>200);
	$paragraphStyleLeft		= array('align'=>'left', 'spaceBefore'=>100, 'spacing'=>0);
	$paragraphStyleCenter	= array('align'=>'center', 'spaceBefore'=>100, 'spacing'=>0);
	
	//---- add filas
	$vbVrDirEstudio_2	= number_format( $vrDirEstudio_2 );
	
	$table->addRow();
	$fontStyle		= array('name'=>'Arial', 'size'=>11);
	$fontStyleBold	= array('name'=>'Arial', 'bold'=>true, 'size'=>11);
	$table->addCell(300)->addText('1', $fontStyle, $paragraphStyleCenter);
	$table->addCell(8000)->addText(utf8_decode(' Dirección de estudios'), $fontStyle);
	$table->addCell(2000)->addText('1', $fontStyle, $paragraphStyleCenter);
	$table->addCell(2000,$styleCell)->addText('$ '.$vbVrDirEstudio_2.' ', $fontStyle, $paragraphStyle);
	$table->addCell(2000,$styleCell)->addText('$ '.$vbVrDirEstudio_2.' ', $fontStyle, $paragraphStyle);
	
	
	//---- consulta los segmentos de la metodología
	$sqlR = "SELECT *
	 FROM ".tablaInversion." R
	   WHERE R.id_propuesta=$idPropuesta AND tabla = 2
	   ORDER BY 1";
	//echo '<BR>'.$sqlR;
	$conR				= mysql_query($sqlR);
	while($camposR		= mysql_fetch_array($conR)){
		++$cont;
		$id_producto	= $camposR["id_producto"];
		$descripcion	= $camposR["producto"];
		$muestra		= $camposR["cantidad"];
		$vrUnitario		= $camposR["vr_unitario"];
	
		$vrTotal			= '-';
		if(!empty($muestra)){
			if($muestra*$vrUnitario){
				$vrTotal	= $muestra*$vrUnitario;
				$subTotal	+= $vrTotal;
			}
			//echo '<BR>vrUnitario: '.$vrUnitario;
		}//---- Si tiene definido muestra
		$vbMuestra		= number_format($muestra);
		$vbVrUnitario	= number_format($vrUnitario);
		$vbVrTotal		= number_format($vrTotal);
	
		//---- add filas
		$table->addRow();
		$fontStyle = array('name'=>'Arial', 'size'=>11);
		$table->addCell(300)->addText($cont, $fontStyle, $paragraphStyleCenter);
		$table->addCell(8000)->addText(' '.$descripcion, $fontStyle, $paragraphStyleLeft);
		$table->addCell(2000, $styleCell)->addText($vbMuestra, $fontStyle, $paragraphStyleCenter);
		$table->addCell(2000, $styleCell)->addText('$ '.$vbVrUnitario, $fontStyle, $paragraphStyle);
		$table->addCell(2000, $styleCell)->addText('$ '.$vbVrTotal, $fontStyle, $paragraphStyle);
	}//---- consulta de segmentos de la metodología
	
	
	
	$subTotal		+= $vrDirEstudio_2;
	$vbVrDirEstudio	= number_format($vrDirEstudio_2);
	//---- IVA
	$vrIVA			= $subTotal * porcentajeIVA;
	$vbVrIVA		= number_format($vrIVA);
	//---- sub total
	$vbSubTotal		= number_format($subTotal);
	//---- gran total
	$granTotal		= $subTotal + $vrIVA;
	$vbGranTotal	= number_format($granTotal);
	
	// Define font style for first row
	//---- add filas
	$table->addRow();
	$fontStyle		= array('name'=>'Arial', 'size'=>11);
	$fontStyleBold	= array('name'=>'Arial', 'bold'=>true, 'size'=>11);
	$table->addCell(100)->addText('', $fontStyle);
	$table->addCell(8000)->addText(' Subtotal', $fontStyleBold);
	$table->addCell(2000)->addText('', $fontStyle);
	$table->addCell(2000)->addText('', $fontStyle);
	$table->addCell(2000, $styleCell)->addText('$ '.$vbSubTotal, $fontStyle, $paragraphStyle);
	//----
	$table->addRow();
	$table->addCell(100)->addText('', $fontStyle);
	$table->addCell(8000)->addText(' IVA', $fontStyleBold);
	$table->addCell(2000)->addText('', $fontStyle);
	$table->addCell(2000)->addText('', $fontStyle);
	$table->addCell(2000, $styleCell)->addText('$ '.$vbVrIVA, $fontStyle, $paragraphStyle);
	
	$table->addRow();
	$table->addCell(100)->addText('', $fontStyle);
	$table->addCell(8000)->addText(' TOTAL', $fontStyleBold);
	$table->addCell(2000)->addText('', $fontStyle);
	$table->addCell(2000)->addText('', $fontStyle);
	$table->addCell(2000, $styleCell)->addText('$ '.$vbGranTotal, $fontStyleBold, $paragraphStyle);

}


$section->addTextBreak(1);
$cellStyle = array('name'=>'Arial', 'size'=>14, 'bold'=>true);
$section->addText('Forma pago:', $cellStyle);
$cellStyle = array('name'=>'Arial', 'size'=>14);
$section->addText($formaPago, $cellStyle, 'pjustify');

$cellStyle = array('name'=>'Arial', 'size'=>14, 'bold'=>true);
$section->addText('Validez de la propuesta:', $cellStyle);
$cellStyle = array('name'=>'Arial', 'size'=>14);
$section->addText( $info_prop['validez_propuesta'] , $cellStyle, 'pjustify');

//---- Productos
$section->addPageBreak();
//---- consulta las páginas
$table = $section->addTable();
// Add row
$table->addRow();
// Add cells
$table->addCell(5000, $styleCell)->addText('', $fontStylePag);
$pagAct	= 3;
$sql = "SELECT * FROM ".tablaPagina." ORDER BY 1";
//echo '<BR>'.$sql;
$con			= mysql_query($sql);
while($campos	= mysql_fetch_array($con)){
	$id_pagina	= $campos["id_pagina"];
	$nom_pagina	= $campos["nom_pagina"];
	$vb_pagina	= $id_pagina.'.'.$nom_pagina;

	if($id_pagina==$pagAct){
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePagAct);
	}else{
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePag);
	}
}
$section->addTextBreak(1);
$section->addText('PRODUCTOS', 'titleStyle');
$section->addTextBreak(3);

$cellStyle = array('name'=>'Arial', 'size'=>14);
$section->addText($vb_productos, $cellStyle);

$sql = "SELECT * FROM ".tablaEntregable." INNER JOIN ".tablaEntregableRTA." USING(id_entregable)
		 WHERE id_propuesta=".$idPropuesta." ORDER BY 1";
//echo '<BR>'.$sql;
/*$con				= mysql_query($sql);
while($campos		= mysql_fetch_array($con)){
	$id_entregable	= $campos["id_entregable"];
	$nom_entregable	= $campos["nom_entregable"];

//	$listStyle = array('listType' => PHPWord_Style_ListItem::TYPE_NUMBER);
//	$section->addListItem($des_nota_calidad, 0, null, $listStyle);
	$section->addListItem($nom_entregable, 0, $cellStyle);
}*/

foreach( $PropuestaDoc->getProdProducts(1) as $prod_doc ){

	if( $prod_doc['nom_producto'] != '' )
		$section->addListItem( $prod_doc['nom_producto'] , 0, $cellStyle);
}

//---- Notas de calidad
$section->addPageBreak();
//---- consulta las páginas
$table = $section->addTable();
// Add row
$table->addRow();
// Add cells
$table->addCell(5000, $styleCell)->addText('', $fontStylePag);
$pagAct	= 4;
$sql = "SELECT * FROM ".tablaPagina." ORDER BY 1";
//echo '<BR>'.$sql;
$con			= mysql_query($sql);
while($campos	= mysql_fetch_array($con)){
	$id_pagina	= $campos["id_pagina"];
	$nom_pagina	= $campos["nom_pagina"];
	$vb_pagina	= $id_pagina.'.'.$nom_pagina;

	if($id_pagina==$pagAct){
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePagAct);
	}else{
		$table->addCell(1500, $styleCellPag)->addText($vb_pagina, $fontStylePag);
	}
}
$section->addTextBreak(1);
$section->addText('CONTROL DE CALIDAD', 'titleStyle');
$section->addTextBreak(3);

$cellStyle = array('name'=>'Arial', 'size'=>11);
$section->addText(utf8_decode('El Centro Nacional de Consultoría:'), $cellStyle);

$sql = "SELECT * FROM ".tablaNotasCalidadRTA." WHERE id_propuesta=$idPropuesta AND activo_nota_calidad = 1 ORDER BY 1";
//echo '<BR>'.$sql;
$count_control_c = 0;
$con					= mysql_query($sql);
while($campos			= mysql_fetch_array($con)){
	
	$count_control_c++;
	
	$id_nota_calidad	= $campos["id_nota_calidad"];
	$des_nota_calidad	= $campos["des_nota_calidad"];

//	$listStyle = array('listType' => PHPWord_Style_ListItem::TYPE_NUMBER);
//	$section->addListItem($des_nota_calidad, 0, null, $listStyle);
	$section->addListItem($des_nota_calidad, 0, $cellStyle );
	
	$section->addTextBreak(1);
	
	if( $count_control_c % 7 == 0 ){
		$section->addTextBreak(1);
	}
}

$PropuestaDoc->creacion_propuesta_enviar( $crypt_archivo , md5( $ContenidosDoc->decryptData( $crypt_archivo ) ) );


// Save File
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save( $pathPropuesta );
$objWriter->save( $path_propuesta_envio );

?>
