<?php
require_once '../PHPWord.php';

// New Word Document
$PHPWord = new PHPWord();

$section = $PHPWord->loadTemplate('templatePropuesta.docx');

// Define table style arrays
//$styleTable = array('border'=>0, 'borderSize'=>0, 'cellMargin'=>0);
//$styleFirstRow = array('valign'=>'left','borderBottomSize'=>50, 'borderBottomColor'=>'BDD2D1', 'bgColor'=>'FFFFFF');
$styleBarra = array('valign'=>'left', 'bgColor'=>'BDD2D1');

// Define cell style arrays
$styleCell = array('valign'=>'center');
$styleCellBTLR = array('valign'=>'center', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);

// Define font style for first row
//$fontStyle = array('bold'=>true, 'align'=>'center');
$fontStyle = array('align'=>'center');
//$cellStyle = array('name'=>'Arial', 'size'=>8, 'color'=>'BDD2D1');
$fontStyle = array('align'=>'center', 'name'=>'Arial', 'size'=>8, 'color'=>'333333');

// Add table style
//$PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);
//$PHPWord->addTableStyle('myOwnTableStyle', $styleTable);

// Add table
//$table = $section->addTable('myOwnTableStyle');
$section->addTable();

// Add row
$table->addRow(-600);

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

// Add more rows / cells
//for($i = 1; $i <= 5; $i++) {
//	$table->addRow();
//	$table->addCell(2000)->addText("Cell $i");
//	$table->addCell(2000)->addText("Cell $i");
//	$table->addCell(2000)->addText("Cell $i");
//	$table->addCell(2000)->addText("Cell $i");
//	$table->addCell(2000)->addText("Cell $i");
//	$table->addCell(2000)->addText("Cell $i");
//	$table->addCell(2000)->addText("Cell $i");
//	
//	$text = ($i % 2 == 0) ? 'X' : NULL;
//	$table->addCell(500)->addText($text);
//}


// Save File
$section->save('AdvancedTable0.docx');
?>