<?php

namespace backend\modules\esiap\models;

class Fk1Start extends \TCPDF {
	
	public $header_html;
	
	public $header_first_page_only = false;
	
	public $footer_html;
	
	public $footer_first_page_only = false;
	
	public $top_margin_first_page = -37;
	
	public $font_header = 'times';
	
	public $font_header_size = 10;
	
	public $setY;
	

    //Page header
    public function Header() {
		//$this->myX = $this->getX();
		//$this->myY = $this->getY();
		//$savedX = $this->x;
		//savedY = $this->y;
		//$this->setY(13);
		
	
		//$this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);
		//$this->setY(33);
		//$this->setX($this->myX);
		//$this->setY($this->myY);
		
		//$this->SetY($savedY);
		//$this->SetX($savedX);
	   

	    //$this->SetTopMargin($this->GetY() + 10);

	    
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
		 $this->SetY(-16);
		 
		 
		
			
			
		 
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
    }
}
