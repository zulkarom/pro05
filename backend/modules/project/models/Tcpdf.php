<?php

namespace backend\modules\project\models;

class Tcpdf extends \TCPDF {
	
	public $header_html;
	
	public $status;
	
	public $header_first_page_only = false;
	
	public $footer_html;
	
	public $footer_first_page_only = false;
	
	public $top_margin_first_page = -37;
	
	public $font_header = 'times';
	
	public $font_header_size = 10;
	
	public $hasPageNumber = true;
	

    //Page header
    public function Header() {
		
		if($this->status == 0 or $this->status == 10){
			
		$image_file = $this->status == 10 ? 'semak' : 'deraf' ;
			
		// get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = 'images/'.$image_file.'.jpg';
        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
		}
		$this->SetTopMargin(20);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
		 $this->SetY(-22);
		 
		 
		$page = $this->getPage();
		
		if($page > 1){
			 // Set font
        $this->SetFont('helvetica', '', 10);
		$num = $page - 1;
		if($this->hasPageNumber){
			$this->Cell(0, 10, $num, 0, false, 'C', 0, '', 0, false, 'T', 'M');
		}
        
		}
			
			
		 
       
		
    }
}
