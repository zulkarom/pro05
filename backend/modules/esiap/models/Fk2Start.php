<?php

namespace backend\modules\esiap\models;

class Fk2Start extends \TCPDF {
	
	public $header_html;
	
	public $header_first_page_only = false;
	
	public $footer_html;
	
	public $footer_first_page_only = false;
	
	public $top_margin_first_page = -37;
	
	public $font_header = 'times';
	
	public $font_header_size = 10;
	
	public $setY;
	
	public $lineFooterTable;
	

    //Page header
    public function Header() {
		
		/* $page = $this->getPage();
		if($page == 1){
			
		$savedY = $this->y;
		$this->setY(13);
		$this->SetFont('helvetica', '', 10);
		//$this->Cell(0, 10, 'PPJK02', 0, true, 'R', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', '', 8);
			$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $this->header_html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
		
		//echo $html;
		
		
		$this->setY(40);
		$w = 192.5;
		//$this ->Line($this->GetX(),$this->GetY(),$w, $this->GetY(), array('width'=>0.3));
		
		
		$this->setY(30);

	    $this->SetTopMargin($this->GetY() + 10);
		}else{
			
			$this->setY(20);
			
			//$this ->Line($this->GetX(),$this->GetY(),$w, $this->GetY(), array('width'=>0.3));
			
			
			$this->setY(10);

			$this->SetTopMargin($this->GetY() + 10);
			
		} */
		$this->setY(13);
		$w = 192.5;
		$this ->Line($this->GetX(),$this->GetY(),$w, $this->GetY(), array('width'=>0.3));
	    
    }

    // Page footer
    public function Footer() {
        if($this->lineFooterTable){
			$this->SetY(-20);
		$w = 192.5;
		$this ->Line($this->GetX(),$this->GetY(),$w, $this->GetY(), array('width'=>0.3));
		}
		
		$this->SetY(-17);
		 //$html = '';
		//$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
    }
	
	public function myrotate($text) {
        /* if( !isset($this->xywalter) ) {
            $this->xywalter = array();
        }
        $this->xywalter[] = array($this->GetX(), $this->GetY()); */

		
		$this->SetFont('arialnarrow', 'i', 8);
		$this->StartTransform();
		$this->Rotate(90);
		$currX = $this->getX();
		$currY = $this->getY();
		$this->setXY($currX -16,$currY + 1);
		$this->Cell($w=0,
				$h = 0,
				$txt = $text,
				$border = 0,
				$ln = 1,
				$align ='L',
				$fill = false,
				$link = '',
				$stretch = 0,
				$ignore_min_height = false,
				$calign = 'C',
				$valign = 'T' 
			);
		//$this->Cell(0, 0, $text ,0,1,'L',0,'');
		$this->StopTransform();
		$this->ln(6);
    }
	
	public function rotateWeek($text) {
		$this->SetFont('arialnarrow', '', 11);
		$this->StartTransform();
		$this->Rotate(90);
		$currX = $this->getX();
		$currY = $this->getY();
		$this->setXY($currX -18,$currY -0.5);
		$this->writeHTMLCell($w = 0, $h = 0, $x = -5, $y = '', 'Minggu / <br /> <i>Week</i>', $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
		
		//$this->Cell(0, 0, $text ,0,1,'L',0,'');
		
		$this->StopTransform();
		$this->ln(6);
    }
	
	public function rotateOthers($text) {
		$this->SetFont('arialnarrow', 'i', 8);
		$this->StartTransform();
		$this->Rotate(90);
		$currX = $this->getX();
		$currY = $this->getY();
		$this->setXY($currX -16,$currY + 0);
		$this->Cell($w=0,
				$h = 0,
				$txt = 'Lab / Studio /',
				$border = 0,
				$ln = 1,
				$align ='L',
				$fill = false,
				$link = '',
				$stretch = 0,
				$ignore_min_height = false,
				$calign = 'C',
				$valign = 'T' 
			);
		$this->setXY($currX -16,$currY + 3);
		$this->Cell($w=0,
				$h = 0,
				$txt = 'Others',
				$border = 0,
				$ln = 1,
				$align ='L',
				$fill = false,
				$link = '',
				$stretch = 0,
				$ignore_min_height = false,
				$calign = 'C',
				$valign = 'T' 
			);
		//$this->Cell(0, 0, $text ,0,1,'L',0,'');
		$this->StopTransform();
		$this->ln(6);
    }
}
