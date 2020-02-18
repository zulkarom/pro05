<?php

namespace backend\modules\esiap\models;

class Tbl4Start extends \TCPDF {
	
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
	
	public function myrotate($text) {
        /* if( !isset($this->xywalter) ) {
            $this->xywalter = array();
        }
        $this->xywalter[] = array($this->GetX(), $this->GetY()); */
		$this->SetFont('helvetica', 'B', 8);
		$this->StartTransform();
		$this->Rotate(90);
		$currX = $this->getX();
		$currY = $this->getY();
		$this->setXY($currX -13,$currY + 1);
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
	

    public function Header() {
		
		
		$this->setY(13);
		$w = 192.5;
		$this ->Line($this->GetX(),$this->GetY(),$w, $this->GetY(), array('width'=>0.3));
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
		
		
		if($this->lineFooterTable){
			$this->SetY(-30);
		$w = 192.5;
		$this ->Line($this->GetX(),$this->GetY(),$w, $this->GetY(), array('width'=>0.3));
		}
        
		$this->SetY(-25);
		 //$html = '';
		//$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
    }
}
