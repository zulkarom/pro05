<?php

namespace backend\modules\esiap\models;

class Fk3Start extends \TCPDF {
	
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
		
    }
	
	public function rotateAssess($text){
		$len = strlen($text);
		if($len > 14){
			
			$arr_text = explode(" ",trim($text));
			$kira = count($arr_text);
			if($kira == 1){
				$this->noBreakRotate($text);
			}else if($kira == 2){
				
				$this->breakRotate($arr_text[0], $arr_text[1]);
			}else{
				if(strlen($arr_text[0]) > 14){
					$this->noBreakRotate($arr_text[0]);
				}else{
					$bal = 14 - strlen($arr_text[0]);
					if(strlen($arr_text[1]) > $bal){
						$this->breakRotate($arr_text[0], $arr_text[1] .' '. $arr_text[2]);
					}else{
						$more = $kira > 3 ? ' ...' : '';
						$this->breakRotate($arr_text[0] .' '.$arr_text[1], $arr_text[2].$more);
					}
				}
				
				
			}
		}else{
			$this->noBreakRotate($text);
		} 
	}
	
	public function noBreakRotate($text) {
		$str = $text;
		if(strlen($text) > 14){
			$str = substr($text,0 ,14) . '...';
		}
		
		$this->SetFont('arialnarrow', 'i', 10);
		$this->StartTransform();
		$this->Rotate(90);
		$currX = $this->getX();
		$currY = $this->getY();
		$this->setXY($currX -22,$currY + 4);
		
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
		$this->ln(12);
    }
	
	public function breakRotate($text1, $text2) {
		$str1 = $text1;
		if(strlen($text1) > 14){
			$str1 = substr($text1, 0 ,14) . '...';
		}
		$str2 = $text2;
		if(strlen($text2) > 14){
			$str2 = substr($text2, 0 ,14) . '...';
		}
		$this->SetFont('arialnarrow', 'i', 10);
		$this->StartTransform();
		$this->Rotate(90);
		$currX = $this->getX();
		$currY = $this->getY();
		$this->setXY($currX -22,$currY + 2.5);
		
		$this->Cell($w=0,
				$h = 0,
				$txt = $str1,
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
		$this->setXY($currX -22,$currY + 6);
		
		$this->Cell($w=0,
				$h = 0,
				$txt = $str2,
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
		$this->ln(12);
    }
	
	
    // Page footer
    public function Footer() {
  
		 
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        //$this->Cell(0, 10, 'FK03 | Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(). ' | Printed on ' . date('d M Y'), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
    }
}
