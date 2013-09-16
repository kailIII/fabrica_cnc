<?php

require_once dirname(__FILE__).'/../krumo/class.krumo.php';
require_once dirname(__FILE__).'/class.Propuesta.php';

date_default_timezone_set('America/Bogota');
setlocale(LC_ALL,"es_ES");
set_include_path( dirname(__FILE__).'/../phpPowerPoint/Classes' );

/** PHPPowerPoint */
include 'PHPPowerPoint.php';

class PropuestaPpt extends Propuesta{

    private $color_titulo1 =  "FF047AAD";
    private $size_titulo1 = "28";
    
    private $objPHPPowerPoint;
    private $info_prop;
    
    public function __construct( $id_propuesta ){
        
        parent::__construct($id_propuesta);
        
        $this->info_prop = $this->getProp();
        
        $objPHPPowerPoint = new PHPPowerPoint();
        $objPHPPowerPoint->getProperties()->setCreator("Centro nacional de consultoria");
        $objPHPPowerPoint->getProperties()->setLastModifiedBy("Centro nacional de consultoria");
        $objPHPPowerPoint->getProperties()->setTitle("Presentacion Propuesta ".$this->id_propuesta);
        $objPHPPowerPoint->getProperties()->setSubject("Propuesta presentada a ".$this->info_prop['empresa_cliente']);
        $objPHPPowerPoint->getProperties()->setDescription("Propuesta presentada a ".$this->info_prop['empresa_cliente']);
        $objPHPPowerPoint->getProperties()->setKeywords("Propuesta CNC");
        $objPHPPowerPoint->getProperties()->setCategory("Propuesta");
        $objPHPPowerPoint->removeSlideByIndex(0);
        
        $this->objPHPPowerPoint = $objPHPPowerPoint;
    }
    
    public function makePpt(){

      $this->slide1_Titulo();
      $this->slide2_carretaInvestigacion();
      $this->slide3_Contexto();
      $this->slide4_Objetivos();
	  $this->slide5_Metodologias();
	  $this->slide6_Calendario();

      $this->saveFile();
    }

    private function slide0_Presentacion(){

    }
       
    private function slide1_Titulo(){
     
      $currentSlide = $this->createTemplatedSlide($this->objPHPPowerPoint); // local function

      // Create a shape (text)
      // echo date('H:i:s') . " Create a shape (rich text)\n";
      $shape = $currentSlide->createRichTextShape();
      $shape->setHeight(146)
            ->setWidth(715)
            ->setOffsetX(205)
            ->setOffsetY(20);

      $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
      $textRun = $shape->createTextRun( utf8_encode($this->info_prop['empresa_cliente']).' - '.utf8_encode($this->info_prop['titulo']) );

      $textRun->getFont()->setBold(true)
              ->setSize( $this->size_titulo1 )
              ->setColor( new PHPPowerPoint_Style_Color( $this->color_titulo1 ) )
              ->setBold(true);

      $shape = $currentSlide->createRichTextShape();
      $shape->setHeight(50)
            ->setWidth(900)
            ->setOffsetX(20)
            ->setOffsetY(160);
      $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

      $textRun = $shape->createTextRun('Presentada a:');
      $textRun->getFont()->setSize(16)
              ->setBold(true)
              ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) )
              ->setItalic(true);

      $x_offset = 20;
      $y_offset = 200;
      foreach( $this->getPropClientes() as $key => $cli ){


        if( ($key+1) % 3 == 0 ){
            $y_offset+=110;
            $x_offset = 20;
        }

        $shape = $currentSlide->createRichTextShape();
        $shape->setHeight(110);
        $shape->setWidth( 465 );
        $shape->setOffsetX( $x_offset );
        $shape->setOffsetY( $y_offset );
        $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

        $textRun = $shape->createTextRun( utf8_encode( $cli['nombre'] ) );
        $textRun->getFont()->setSize(16)
                ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) )
                ->setBold(true)
                ->setItalic(true);

        $shape->createBreak();

        $textRun = $shape->createTextRun( utf8_encode( $cli['cargo'] ) );
        $textRun->getFont()->setSize(16)
                ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) );

        $shape->createBreak();

        $textRun = $shape->createTextRun( utf8_encode( $cli['email'] ) );
        $textRun->getFont()->setSize(16)
                ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) );

        $shape->createBreak();

        $textRun = $shape->createTextRun( utf8_encode( $cli['telefono'] ).' - '.utf8_encode($cli['celular']) );
        $textRun->getFont()->setSize(16)
                ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) );

        $x_offset+=465;
      }

      $revisa_elabora = $this->getElaboraRevisa();
      
      // Elaborada por
      $elabora = $revisa_elabora['elabora'];
      $x_offset = 20;
      $y_offset+=125;

      $shape = $currentSlide->createRichTextShape();
      $shape->setHeight(150);
      $shape->setWidth( 465 );
      $shape->setOffsetX( $x_offset );
      $shape->setOffsetY( $y_offset );
      $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

      $textRun = $shape->createTextRun( utf8_encode( 'Presentada por:' ) );
      $textRun->getFont()->setSize(16)
      ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) )
      ->setBold(true)
      ->setItalic(true);

      $shape->createBreak();

      $textRun = $shape->createTextRun( utf8_encode( $elabora['nombre'] ) );
      $textRun->getFont()->setSize(16)
      ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) );

      $shape->createBreak();

      $textRun = $shape->createTextRun( utf8_encode( $elabora['cargo'] ) );
      $textRun->getFont()->setSize(16)
      ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) );

      $shape->createBreak();

      $textRun = $shape->createTextRun( utf8_encode( $elabora['email'] ) );
      $textRun->getFont()->setSize(16)
      ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) );

      $shape->createBreak();

      $elabora['celular'] == '' ?
      $textRun = $shape->createTextRun( utf8_encode( $elabora['telefono'] )) :
      $textRun = $shape->createTextRun( utf8_encode( $elabora['telefono'].' - '.$elabora['celular'] ) );

      $textRun->getFont()->setSize(16)
      ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) );

      // Revisa
      $x_offset+=465;
      $revisa = $revisa_elabora['revisa'];

      $shape = $currentSlide->createRichTextShape();
      $shape->setHeight(150);
      $shape->setWidth( 465 );
      $shape->setOffsetX( $x_offset );
      $shape->setOffsetY( $y_offset );
      $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

      $textRun = $shape->createTextRun( utf8_encode( 'Revisada por:' ) );
      $textRun->getFont()->setSize(16)
      ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) )
      ->setBold(true)
      ->setItalic(true);

      $shape->createBreak();

      $textRun = $shape->createTextRun( utf8_encode( $revisa['nombre'] ) );
      $textRun->getFont()->setSize(16)
      ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) );

      $shape->createBreak();

      $textRun = $shape->createTextRun( utf8_encode( $revisa['cargo'] ) );
      $textRun->getFont()->setSize(16)
      ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) );

      $shape->createBreak();

      $textRun = $shape->createTextRun( utf8_encode( $revisa['email'] ) );
      $textRun->getFont()->setSize(16)
      ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) );

      $shape->createBreak();

      $revisa['celular'] == '' ?
      $textRun = $shape->createTextRun( utf8_encode( $revisa['telefono'] )) :
      $textRun = $shape->createTextRun( utf8_encode( $revisa['telefono'].' - '.$revisa['celular'] ) );

      $textRun->getFont()->setSize(16)
      ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) );

      // Ciudad mas fecha
      $shape = $currentSlide->createRichTextShape();

      $shape->setHeight(50);
      $shape->setWidth( 300 );
      $shape->setOffsetX( 620 );
      $shape->setOffsetY( 620 );
      $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );

      $textRun = $shape->createTextRun( 'Bogotá '.strftime('%e de %B de %Y'));
      $textRun->getFont()->setSize(16)
      ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) );


      $this->saveFile();

    }

    private function slide2_carretaInvestigacion(){
       $currentSlide = $this->createTemplatedSlide($this->objPHPPowerPoint); // local function

       $shape = $currentSlide->createRichTextShape();
       $shape->setHeight(73)
       ->setWidth(715)
       ->setOffsetX(205)
       ->setOffsetY(55);

       $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
       $textRun = $shape->createTextRun( 'Investigación + Conversación = Acción' );

       $textRun->getFont()->setBold(true)
       ->setSize( $this->size_titulo1 )
       ->setColor( new PHPPowerPoint_Style_Color( $this->color_titulo1 ) )
       ->setBold(true);

       $shape = $currentSlide->createRichTextShape();
       $shape->setHeight(500)
       ->setWidth(900)
       ->setOffsetX(20)
       ->setOffsetY(240);
       $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
       
       

       $textRun = $shape->createTextRun('El Centro Nacional de Consultoría es una firma de investigación y consultoría, centrada en la creación de valor a través de la escucha generosa de sus necesidades, el estudio cuidadoso de sus problemas y el desarrollo de soluciones comercialmente viables que les garanticen el progreso.');
       $textRun->getFont()->setSize(16)
       ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) );
       
       $shape->createBreak();
       $shape->createBreak();
       
       $textRun = $shape->createTextRun('El Centro se compromete con un nuevo liderazgo de servicio construido sobre cuatro dimensiones: el sentido de realidad, la ética, la visión y el coraje para hacer siempre la tarea.');
       $textRun->getFont()->setSize(16)
       ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ) );
       
    }
    
    private function slide3_Contexto(){
        
        $contexto = $this->info_prop['contexto'];
        $currentSlide = $this->createTemplatedSlide($this->objPHPPowerPoint); // local function

        $shape = $currentSlide->createRichTextShape();
        $shape->setHeight(73)
        ->setWidth(715)
        ->setOffsetX(205)
        ->setOffsetY(55);

        $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
        $textRun = $shape->createTextRun( 'Contexto' );

        $textRun->getFont()->setBold(true)
        ->setSize( $this->size_titulo1 )
        ->setColor( new PHPPowerPoint_Style_Color( $this->color_titulo1 ) )
        ->setBold(true);

        $shape = $currentSlide->createRichTextShape();
        $shape->setHeight(500)
        ->setWidth(900)
        ->setOffsetX(20)
        ->setOffsetY(160);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
        
        
        $spaced_text = explode( "\n", $contexto );
        foreach( $spaced_text as $txt ){
            
            if( $txt[0] == '*' && $txt != '' ){
                $txt2 = substr_replace($txt ,"",0,1);
                $textRun = $shape->createParagraph()->createTextRun(utf8_encode( '    - '.$txt2 ) );
                $textRun->getFont()->setSize(16)
                ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ));
                
            } else if( $txt!= '' ) {
                $textRun = $shape->createTextRun(utf8_encode( $txt ) );
                $textRun->getFont()->setSize(16)
                ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ));
            }
        }
    }
            
    private function slide4_Objetivos(){
        $contexto = $this->info_prop['contexto'];
        $currentSlide = $this->createTemplatedSlide($this->objPHPPowerPoint); // local function

        $shape = $currentSlide->createRichTextShape();
        $shape->setHeight(73)
        ->setWidth(715)
        ->setOffsetX(205)
        ->setOffsetY(55);

        $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
        $textRun = $shape->createTextRun( 'Objetivos' );

        $textRun->getFont()->setBold(true)
        ->setSize( $this->size_titulo1 )
        ->setColor( new PHPPowerPoint_Style_Color( $this->color_titulo1 ) )
        ->setBold(true);
        
        $shape = $currentSlide->createRichTextShape();
        $shape->setHeight(500)
        ->setWidth(900)
        ->setOffsetX(20)
        ->setOffsetY(160);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
        
        $textRun = $shape->createTextRun(utf8_decode( 'General:' ) );
                $textRun->getFont()->setSize(16)
                ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ))
                ->setBold(true);
       
        $shape->createBreak();
        
        $textRun = $shape->createTextRun(utf8_decode( $this->info_prop['objetivo_general'] ) );
                $textRun->getFont()->setSize(16)
                ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ));
                
        $shape->createBreak();
        $shape->createBreak();
        
        $textRun = $shape->createTextRun( 'Especificos:' );
                $textRun->getFont()->setSize(16)
                ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ))
                ->setBold(true);
        
        $shape->createBreak();
        
        $ob_especificos = explode("||", $this->info_prop['objetivos_especificos'] );
        
        foreach( $ob_especificos as $ob_especifico ){

            if( $ob_especifico != '' ):
               
                $spaced_text = explode("\n", $ob_especifico );
                foreach( (array)$spaced_text as $txt ){
                    
                    if( $txt[0] == '*' && $txt != '' ){
                        $txt2 = substr_replace($txt ,"",0,1);
                        $textRun = $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT )
                              ->setMarginLeft(25)
                              ->setIndent(-25); 
                        $textRun = $shape->createTextRun( '-'. utf8_encode($txt2) );
                        $textRun->getFont()->setSize(16)
                        ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ));
                    } else if( $txt != '' ) {
                        $textRun = $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
                        $textRun = $shape->createTextRun( '-'. utf8_encode($txt) );
                        $textRun->getFont()->setSize(16)
                        ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ));
                    }
                    
                    $shape->createBreak();
                }
                
                endif;
        }
        
    }
    
    private function slide5_Metodologias(){
        
       $currentSlide = $this->createTemplatedSlide($this->objPHPPowerPoint); // local function

        $shape = $currentSlide->createRichTextShape();
        $shape->setHeight(73)
        ->setWidth(715)
        ->setOffsetX(205)
        ->setOffsetY(55);

        $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
        $textRun = $shape->createTextRun( 'Metodologías' );

        $textRun->getFont()->setBold(true)
        ->setSize( $this->size_titulo1 )
        ->setColor( new PHPPowerPoint_Style_Color( $this->color_titulo1 ) )
        ->setBold(true);
	
	   $y_offset = 160;
		
		if( ! empty( $this->info_prop['introduccion_met'] ) ){
		
		   $shape = $currentSlide->createRichTextShape();
	       $shape->setHeight(200)
	       ->setWidth(900)
	       ->setOffsetX(20)
	       ->setOffsetY($y_offset);
	       $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_CENTER );
		   
		   $textRun = $shape->createTextRun( utf8_encode($this->info_prop['introduccion_met'] ) );
		   $textRun->getFont()->setSize( 16 )
	        ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ))
			->setItalic(TRUE);
			
			$y_offset+=200;
		}
		
	   $shape = $currentSlide->createRichTextShape();
       $shape->setHeight(50)
       ->setWidth(900)
       ->setOffsetX(20)
       ->setOffsetY($y_offset);
       $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
	   
	   $textRun = $shape->createTextRun('En el estudio se usarán las siguientes metodologías:');
	   $textRun->getFont()->setBold(true)
        ->setSize( 16 )
        ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ));
		
		$y_offset+=50;
		$shape = $currentSlide->createRichTextShape();
       $shape->setHeight(400)
       ->setWidth(900)
       ->setOffsetX(20)
       ->setOffsetY($y_offset);
       $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
		
		$query ="SELECT * FROM prop_metodologia_rta pmr
		INNER JOIN prop_metodologia pme ON pme.id_metodologia = pmr.id_metodologia
		WHERE pmr.id_propuesta = {$this->id_propuesta} ORDER BY pmr.id_row_metodologia";
		foreach( $this->adoDbFab->GetAll($query) as $met ){
			
			$textRun = $shape->createTextRun( '    -  '. utf8_encode( $met['nom_metodologia'] ));
		    $textRun->getFont()->setSize( 16 )
	        ->setColor( new PHPPowerPoint_Style_Color( 'FF333333' ));
			
			$shape->createBreak();
			
		}
		
		foreach( $this->adoDbFab->GetAll($query) as $met ){
			$currentSlide = $this->createTemplatedSlide($this->objPHPPowerPoint); // local function

	        $shape = $currentSlide->createRichTextShape();
	        $shape->setHeight(73)
	        ->setWidth(715)
	        ->setOffsetX(205)
	        ->setOffsetY(55);
	
	        $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
	        $textRun = $shape->createTextRun( utf8_encode( $met['nom_metodologia'] ));
	
	        $textRun->getFont()->setBold(true)
	        ->setSize( $this->size_titulo1 )
	        ->setColor( new PHPPowerPoint_Style_Color( $this->color_titulo1 ) )
	        ->setBold(true);
			
			$id_tipo_metodologia = $met['id_tipo_metodologia'];
			$sqlR = "SELECT * FROM prop_seg_metodologia_rta R
		    		WHERE R.id_propuesta= {$this->id_propuesta} AND R.id_row_metodologia= {$met['id_row_metodologia']} ";
			
			
			   	$shape = $currentSlide->createTableShape(2);
			   	$shape->setHeight(200);
				$shape->setWidth(900);
				$shape->setOffsetX(20);
				$shape->setOffsetY(160);
				
			   
			   // titulo
			   $row = $shape->createRow();
			   $row->setHeight(20);
			   
			   $pair_row = 0;
			   
			   if( ! empty( $met['titulo'] ) ){
			   		$row->nextCell()->createTextRun( 'Titulo: '.utf8_encode($met['titulo']) )->getFont()->setSize(16)
				    ->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
					$pair_row++;
			   }
			   
			   // nom metodologia
			   if( ! empty( $met['nom_metodologia'] ) ){
					
					$row->nextCell()->createTextRun( 'Metodología: '.utf8_encode($met['nom_metodologia']) )->getFont()->setSize(16)
				    ->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
					$pair_row++;	
			   }
			   
			   // temas			   
			   if( ! empty( $met['temas'] ) ){
			   		
			   		if( $pair_row % 2 == 0 ){
				   		$row = $shape->createRow();
				   		$row->setHeight(20);
			   		}
				   	
					$row->nextCell()->createTextRun( 'Temas: '.utf8_encode($met['temas']) )->getFont()->setSize(16)
				    ->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
					$pair_row++;
			   } 
			   
			   // universo
			   if( ! empty($met['universo']) && $id_tipo_metodologia == 3 ) {
			   	
					if( $pair_row % 2 == 0 ){
				   		$row = $shape->createRow();
				   		$row->setHeight(20);
				   	}
					
					$row->nextCell()->createTextRun( 'Universo: '.utf8_encode($met['universo']) )->getFont()->setSize(16)
				    ->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
					$pair_row++;
			   }
			   
			   
			   if( ! empty( $met['marco_estadistico'] ) ){
			   		
					if( $pair_row % 2 == 0 ){
				   		$row = $shape->createRow();
				   		$row->setHeight(20);
			   		}
							
					$row->nextCell()->createTextRun( 'Marco estadístico: '.utf8_encode($met['marco_estadistico']) )->getFont()->setSize(16)
				    ->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
					$pair_row++;
			   }
			   
			   
			   // remueve bordes a todas las celdas
			   foreach( $shape->getRows() as $row ){
			   		foreach( $row->getCells() as $cell ){
					   $cell->getBorders()->getTop()->setLineWidth(1)->setLineStyle( PHPPowerPoint_Style_Border::LINE_NONE );
					   $cell->getBorders()->getLeft()->setLineWidth(1)->setLineStyle( PHPPowerPoint_Style_Border::LINE_NONE );
					   $cell->getBorders()->getRight()->setLineWidth(1)->setLineStyle( PHPPowerPoint_Style_Border::LINE_NONE );
					   $cell->getBorders()->getBottom()->setLineWidth(1)->setLineStyle( PHPPowerPoint_Style_Border::LINE_NONE );
					}
			   }
			
			
				$shape = $currentSlide->createTableShape(2);
			   	$shape->setHeight(400);
				$shape->setWidth(900);
				$shape->setOffsetX(20);
				$shape->setOffsetY(300);
				
				$pair_row = 0;					
			foreach( $this->adoDbFab->GetALL($sqlR) as $camposR ){
				
				$nom_segmento			= $camposR["nom_segmento"];
				$universo				= $camposR["universo"];
				$muestra				= $camposR["muestra"];
				$error_muestral			= $camposR["error_muestral"];
				$lugar					= $camposR["lugar"];
				$duracion				= $camposR["duracion"];
				
				$id_pob_objetivo_r		= $camposR["id_pob_objetivo"];
				$id_duracion_r			= $camposR["id_duracion"];
				$id_nivel_aceptacion_r	= $camposR["id_nivel_aceptacion"];
				$id_cobertura_r			= $camposR["id_cobertura"];
				
				
				
				switch( $id_tipo_metodologia ){
					
					case 1:
						$row = $shape->createRow();
			   			$row->setHeight(20);
						if(!empty($nom_segmento)){

							$row->nextCell()->createTextRun( 'Ciudad: '.utf8_encode($nom_segmento) )->getFont()->setSize(16)
				    		->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
							$pair_row++;
						}
					
						if(!empty($muestra)){
							
							$row->nextCell()->createTextRun( 'Número de sesiones: '.utf8_encode($muestra) )->getFont()->setSize(16)
				    		->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
							$pair_row++;
						}
						
						if(!empty($lugar)){
								
							if( $pair_row % 2 == 0 ){
								$row = $shape->createRow();
					   			$row->setHeight(20);
							}
							
							$row->nextCell()->createTextRun( 'Lugar donde se va a realizar: '.utf8_encode($lugar))->getFont()->setSize(16)
				    		->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
				    		$pair_row++;
						} 
						
						if(!empty($duracion)){
							
							if( $pair_row % 2 == 0 ){
								$row = $shape->createRow();
					   			$row->setHeight(20);
							}
							
							$row->nextCell()->createTextRun( 'Duración: '.utf8_encode($duracion))->getFont()->setSize(16)
				    		->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
							$pair_row++;
						} 
						break;
					
					case 2:
						
						$row = $shape->createRow();
			   			$row->setHeight(20);
						if(!empty($nom_segmento)){
							
							$row->nextCell()->createTextRun( 'Segmento: '.utf8_encode($nom_segmento))->getFont()->setSize(16)
				    		->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
						} 
						
						if(!empty($muestra)){
							
							$row->nextCell()->createTextRun( 'Muestra: '.utf8_encode($muestra))->getFont()->setSize(16)
				    		->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
						} 
						break;
					
					case 3:
						
						$row = $shape->createRow();
			   			$row->setHeight(20);
						if(!empty($nom_segmento)){
							$row->nextCell()->createTextRun( 'Segmento: '.utf8_encode($nom_segmento) )->getFont()->setSize(16)
				    		->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
							$pair_row++;
						}
						
						if(!empty($universo)){
							$row->nextCell()->createTextRun( 'Universo: '.utf8_encode($universo) )->getFont()->setSize(16)
				    		->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
							$pair_row++;
						}
						
						if(!empty($muestra)){
							
							if( $pair_row % 2 == 0 ){
								$row = $shape->createRow();
					   			$row->setHeight(20);
							}
							
							$row->nextCell()->createTextRun( 'Muestra: '.utf8_encode($muestra) )->getFont()->setSize(16)
				    		->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
							$pair_row++;
						} 
						
						if(!empty($error_muestral)){
							
							if( $pair_row % 2 == 0 ){
								$row = $shape->createRow();
					   			$row->setHeight(20);
							}
							
							$row->nextCell()->createTextRun( 'Error muestral: '.utf8_encode($error_muestral).'%' )->getFont()->setSize(16)
				    		->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
							$pair_row++;
						} 
						break;
				} // end switch
			} // end foreach segmentos
			
			
			// remueve bordes a todas las celdas de segmentos
			   foreach( $shape->getRows() as $row ){
			   		foreach( $row->getCells() as $cell ){
					   $cell->getBorders()->getTop()->setLineWidth(1)->setLineStyle( PHPPowerPoint_Style_Border::LINE_NONE );
					   $cell->getBorders()->getLeft()->setLineWidth(1)->setLineStyle( PHPPowerPoint_Style_Border::LINE_NONE );
					   $cell->getBorders()->getRight()->setLineWidth(1)->setLineStyle( PHPPowerPoint_Style_Border::LINE_NONE );
					   $cell->getBorders()->getBottom()->setLineWidth(1)->setLineStyle( PHPPowerPoint_Style_Border::LINE_NONE );
					}
			   }
			
		} // end foreach metodologias
		
    }

	private function slide6_Calendario(){
	   $currentSlide = $this->createTemplatedSlide($this->objPHPPowerPoint); // local function

       $shape = $currentSlide->createRichTextShape();
       $shape->setHeight(73)
       ->setWidth(715)
       ->setOffsetX(205)
       ->setOffsetY(55);

       $shape->getActiveParagraph()->getAlignment()->setHorizontal( PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT );
       $textRun = $shape->createTextRun( 'Calendario' );

       $textRun->getFont()->setBold(true)
       ->setSize( $this->size_titulo1 )
       ->setColor( new PHPPowerPoint_Style_Color( $this->color_titulo1 ) )
       ->setBold(true);
	   
		$calendario = $this->getCalendario();
		$cols = 2; // columnas inicales table calendario (actividades - responsable)
		$max_semanas = 0; // maximo de semanas del calendario
		
		// determina el maximo de semanas
		foreach( $calendario as $cal ){
			
			if( end(explode(",", $cal['semanas'] )) > $max_semanas  ){
				$max_semanas = end(explode(",", $cal['semanas'] ));
			}
		}
		
		$shape = $currentSlide->createTableShape( $cols+$max_semanas );
		$shape->setHeight(200);
		$shape->setWidth(900);
		$shape->setOffsetX(20);
		$shape->setOffsetY(160);	   
	    
		$row = $shape->createRow();
		$row->setHeight(20);
			   
		$row->nextCell()->setWidth(200)
		->createTextRun( 'Actividades')->getFont()->setSize(12)
		->setColor( new PHPPowerPoint_Style_Color( 'FF333333') )
		->setBold(true);
		
		$row->nextCell()->setWidth(105)
		->createTextRun( 'Responsable' )->getFont()->setSize(12)
		->setColor( new PHPPowerPoint_Style_Color( 'FF333333') )
		->setBold(true);
		
		// max ancho columnas = 600 , w = 600 / cols siendo cols nro de smanas
		
		$w_cols = 600 / $max_semanas;
		
		// realiza columnas de semanas
		for( $j = 1; $j <= $max_semanas; $j++ ){
			$row->nextCell()->setWidth( $w_cols )
			->createTextRun( $j )
			->getFont()
			->setColor( new PHPPowerPoint_Style_Color( 'FF333333') )
			->setBold(true)
			->setSize(8);
		}
		
		// llena contenidos del calendario
		foreach( $calendario as $cal ){
			$row = $shape->createRow();
			$row->setHeight(20);
			
			$row->nextCell()
			->createTextRun( utf8_encode($cal['nom_proceso']) )
			->getFont()->setSize(12)
			->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
			
			$row->nextCell()
			->createTextRun( utf8_encode($cal['responsable']) )
			->getFont()->setSize(12)
			->setColor( new PHPPowerPoint_Style_Color( 'FF333333') );
			
			// evalua la semanas a rellenar en el calendario
			for( $j = 1; $j <= $max_semanas; $j++ ){
				
				$semanas = explode( ',', $cal['semanas'] );
				if( in_array($j, $semanas) ) {
					$row->nextCell()->getFill()->setFillType(PHPPowerPoint_Style_Fill::FILL_GRADIENT_LINEAR)
               ->setRotation(0)
               ->setStartColor(new PHPPowerPoint_Style_Color('FF4589F7'))
               ->setEndColor(new PHPPowerPoint_Style_Color('FF4589F7'));
				} else {
					$row->nextCell()->createTextRun(' ');
				}
				
			}
		}
		
		foreach( $shape->getRows() as $row ){
			foreach( $row->getCells() as $cell ){
				$cell->getBorders()->getTop()->setLineWidth(1)->setLineStyle( PHPPowerPoint_Style_Border::LINE_SINGLE )
				->setColor( new PHPPowerPoint_Style_Color('FFCCCCCC') );
				$cell->getBorders()->getLeft()->setLineWidth(1)->setLineStyle( PHPPowerPoint_Style_Border::LINE_SINGLE )
				->setColor( new PHPPowerPoint_Style_Color('FFCCCCCC') );
				$cell->getBorders()->getRight()->setLineWidth(1)->setLineStyle( PHPPowerPoint_Style_Border::LINE_SINGLE )
				->setColor( new PHPPowerPoint_Style_Color('FFCCCCCC') );
				$cell->getBorders()->getBottom()->setLineWidth(1)->setLineStyle( PHPPowerPoint_Style_Border::LINE_SINGLE )
				->setColor( new PHPPowerPoint_Style_Color('FFCCCCCC') );
			}
		}
		
	}
    
    private  function saveFile(){
        $objWriter = PHPPowerPoint_IOFactory::createWriter($this->objPHPPowerPoint, 'PowerPoint2007');
        $objWriter->save( dirname(__FILE__).'/../propuestas/propuesta_Id'.$this->id_propuesta.'.pptx' );
    }
    
    
   /**
    * Creates a templated slide
    * 
    * @param PHPPowerPoint $objPHPPowerPoint
    * @return PHPPowerPoint_Slide
    */
   private function createTemplatedSlide(PHPPowerPoint $objPHPPowerPoint){
       // Create slide
       $slide = $objPHPPowerPoint->createSlide();
       // Add logo
       $slide->createDrawingShape()
          ->setName('PHPPowerPoint logo')
          ->setDescription('PHPPowerPoint logo')
          ->setPath( dirname(__FILE__).'/../../imagenes/prop_ppt/cnc_logo.png' )
          ->setHeight(110)
          ->setWidth(170)
          ->setOffsetX(20)
          ->setOffsetY(25);

      $slide->createDrawingShape()
        ->setName('Footer')
        ->setDescription('Footer')
        ->setPath( dirname(__FILE__).'/../../imagenes/prop_ppt/cnc_footer.png' )
        ->setHeight(20)
        ->setWidth(295)
        ->setOffsetX(600)
        ->setOffsetY(720-10-40);
       //Return slide
       return $slide;
   }
            
}