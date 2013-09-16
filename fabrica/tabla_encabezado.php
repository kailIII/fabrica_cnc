<?php
require_once '../PHPWord.php';

// New Word Document
$PHPWord = new PHPWord();

// New portrait section
$sectionStyle = array('orientation' => null,
			    'marginLeft' => 1120,
			    'marginRight' => 1120,
			    'marginTop' => 1200,
			    'marginBottom' => 1200);
$section = $PHPWord->createSection($sectionStyle);

// Define table style arrays
//$styleTable = array('border'=>0, 'borderSize'=>0, 'cellMargin'=>0);
//$styleFirstRow = array('valign'=>'left','borderBottomSize'=>50, 'borderBottomColor'=>'BDD2D1', 'bgColor'=>'FFFFFF');
$styleBarra = array('valign'=>'left', 'bgColor'=>'BDD2D1');

// Define cell style arrays
$styleCell = array('valign'=>'center');

// Define font style for first row
//$fontStyle = array('bold'=>true, 'align'=>'center');
$fontStyle = array('align'=>'center');
//$cellStyle = array('name'=>'Arial', 'size'=>8, 'color'=>'BDD2D1');
$fontStyle = array('align'=>'center', 'name'=>'Arial', 'size'=>8, 'color'=>'333333');

$table = $section->addTable();

// Add row
$table->addRow(-480);

$srcFoto	='../logo_CNC.jpg';
$imageStyle = array('width'=>145, 'height'=>32, 'align'=>'left');
//$section->addImage($srcFoto, $imageStyle);

// Add cells
$table->addCell(2000)->addImage($srcFoto, $imageStyle);
$table->addCell(5)->addText('', $fontStyle);
$table->addCell(1000, $cellStyle)->addText(utf8_decode('Lealtad y relaciones'), $fontStyle);
$table->addCell(5)->addText('', $fontStyle);
$table->addCell(1000, $cellStyle)->addText(utf8_decode('Marca y medios'), $fontStyle);
$table->addCell(5)->addText('', $fontStyle);
$table->addCell(2000, $cellStyle)->addText(utf8_decode('Gobierno y asuntos públicos'), $fontStyle);
$table->addCell(5)->addText('', $fontStyle);
$table->addCell(1000, $cellStyle)->addText(utf8_decode('Investigación de mercado'), $fontStyle);
$table->addCell(5)->addText('', $fontStyle);
$table->addCell(1000, $cellStyle)->addText(utf8_decode('Opinión pública'), $fontStyle);
$table->addCell(5)->addText('', $fontStyle);
$table->addCell(1000, $cellStyle)->addText(utf8_decode('Consultoría empresarial'), $fontStyle);
$table->addCell(5)->addText('', $fontStyle);
$table->addCell(500, $cellStyle)->addText(utf8_decode('Más...'), $fontStyle);

// Add row
$table->addRow(-70);

// Add cells
$table->addCell(0)->addText('', $fontStyle);
$table->addCell(0)->addText('', $fontStyle);
$table->addCell(0, $styleBarra)->addText('');
$table->addCell(0)->addText('');
$table->addCell(0, $styleBarra)->addText('');
$table->addCell(0)->addText('');
$table->addCell(0, $styleBarra)->addText('');
$table->addCell(0)->addText('');
$table->addCell(0, $styleBarra)->addText('');
$table->addCell(0)->addText('');
$table->addCell(0, $styleBarra)->addText('');
$table->addCell(0)->addText('');
$table->addCell(0, $styleBarra)->addText('');
$table->addCell(0)->addText('');
$table->addCell(0, $styleBarra)->addText('');




// Define table style arrays
$styleTable = array('borderSize'=>1, 'borderColor'=>'006699', 'cellMargin'=>40, 'valign'=>'right', 'align'=>'right');
$styleTable = array('cellMargin'=>40, 'valign'=>'right', 'align'=>'right');

// Define cell style arrays
$styleCell = array('valign'=>'center');
// Define font style for first row
$fontStyle = array('bold'=>true, 'align'=>'center');

// Add table style
$PHPWord->addTableStyle('myOwnTableStyle', $styleTable);

// Add table
$header = $section->createHeader();
//$header->addPreserveText('CENTRO NACIONAL DE CONSULTORIA');
$table = $header->addTable('myOwnTableStyle');

// Add row
$table->addRow(-300);
// Add cells
$table->addCell(8000, $styleCell)->addText('', $fontStyle);
$table->addCell(1500, $styleCell)->addText('Contexto', $fontStyle);
$table->addCell(1500, $styleCell)->addText('Objetivos', $fontStyle);
$table->addCell(1500, $styleCell)->addText(utf8_decode('Solución'), $fontStyle);
$table->addCell(1500, $styleCell)->addText('Anexos', $fontStyle);
$table->addCell(1500, $styleCell)->addText('Comercial', $fontStyle);

//----
$section->addPageBreak();

// Define table style arrays
$styleTable = array('borderSize'=>1, 'borderColor'=>'006699', 'cellMargin'=>40, 'valign'=>'right', 'align'=>'right');
$styleTable = array('cellMargin'=>40, 'valign'=>'right', 'align'=>'right');

// Define cell style arrays
$styleCell = array('valign'=>'center');
// Define font style for first row
$fontStyle = array('bold'=>true, 'align'=>'center');

// Add table style
$PHPWord->addTableStyle('myOwnTableStyle', $styleTable);

// Add table
//$header = $section->createHeader();
//$header->addPreserveText('CENTRO NACIONAL DE CONSULTORIA');
$table = $header->addTable('myOwnTableStyle');

// Add row
$table->addRow(-300);
// Add cells
$table->addCell(8000, $styleCell)->addText('La pag 2', $fontStyle);
$table->addCell(1500, $styleCell)->addText('Contexto', $fontStyle);
$table->addCell(1500, $styleCell)->addText('Objetivos', $fontStyle);
$table->addCell(1500, $styleCell)->addText(utf8_decode('Solución'), $fontStyle);
$table->addCell(1500, $styleCell)->addText('Anexos', $fontStyle);
$table->addCell(1500, $styleCell)->addText('Comercial', $fontStyle);

//----
$section->addPageBreak();


// Save File
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('AdvancedTable13.docx');
?>
