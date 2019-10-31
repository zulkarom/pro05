<?php

namespace backend\modules\project\models;

class BatchPrintStart extends \TCPDF {
	
	public $header_html;
	
	public $header_first_page_only = false;
	
	public $footer_html;
	
	public $footer_first_page_only = false;
	
	public $top_margin_first_page = -37;
	
	public $font_header = 'times';
	
	public $font_header_size = 10;
	

    //Page header
    public function Header() {
		
        $this->SetFont('times', '', 10);
		
		$this->SetTopMargin(15);

	    
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
		 $this->SetY(-20);
		 
		
		
    }
}
