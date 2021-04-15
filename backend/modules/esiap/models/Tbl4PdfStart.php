<?php

namespace backend\modules\esiap\models;

class Tbl4PdfStart extends \TCPDF {
	
	var $htmlHeader;
	
	var $lineFooterTable;
	var $lineHeaderTable;

    
	
	public function setFooterTable($boo) {
        $this->lineFooterTable = $boo;
    }
	
	public function setHtmlHeader($html) {
        $this->htmlHeader = $html;
    }
	
	public function setHeaderTable($boo) {
        $this->lineHeaderTable = $boo;
    }


    public function Header() {
		
		
		/* $this->setY(18.3);
		$w = 18.5;
		$this ->Line($this->GetX(),$this->GetY(),$w, $this->GetY(), array('width'=>0.8)); */
		
		if($this->lineHeaderTable){
			//$this->setY(22.6);	
			$this->setY(15);
			$w = 198.3;
			$this ->Line($this->GetX(),$this->GetY(),$w, $this->GetY(), array('width'=>0.3));
		}else{
			$this->setY(22.8);	
			//$this->setY(15);
			$w = 198.3;
			$this ->Line($this->GetX(),$this->GetY(),$w, $this->GetY(), array('width'=>0.3));
		}
		
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
		
		
		
		
		if($this->lineFooterTable){
			$this->SetY(-20);
		$w = 198;
		$this ->Line($this->GetX(),$this->GetY(),$w, $this->GetY(), array('width'=>0.3));
		}
        
		$this->SetY(-15);
		 //$html = '';
		//$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

		
		
    }
	
	public function textRotate($text) {
		$str = $text;
		$this->SetFont('arialnarrow', '', 7);
		$this->StartTransform();
		$this->Rotate(90);
		$currX = $this->getX();
		$currY = $this->getY();
		$this->setXY($currX -9,$currY + 2);
		
		$this->Cell($w=0,
				$h = 0,
				$txt = $str,
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
		
		$this->StopTransform();
		$this->ln(3);
    }
}
