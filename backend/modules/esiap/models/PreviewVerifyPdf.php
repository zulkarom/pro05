<?php

namespace backend\modules\esiap\models;

use Yii;
use common\models\Common;
use backend\models\Faculty;

class PreviewVerifyPdf
{
	public $model;
	public $pdf;
	public $html;
	public $directoryAsset;
	

	
	public function generatePdf(){

		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new Tbl4PdfStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$this->pdf->SetFont("arialnarrow", '', 11);
		
		$this->setDocStyle();
		$this->writeHeaderFooter();
		
		$this->startPage();

		$this->preparedBy();
		
		$this->signiture();
		$this->signitureVerify();
		$this->pdf->Output('Preview Signiture.pdf', 'I');
	}
	
	public function preparedBy(){
		$coor = '-- not set --';
		$verifier = '-- not set --';
		$date = '-- date --';
		$datev = '-- date --';

		if($this->model->verifiedBy){
			$verifier = $this->model->verifiedBy->staff->niceName;
		}

		if($this->model->verified_at != '0000-00-00'){
			$datev = date('d/m/Y', strtotime($this->model->verified_at));
		}
		$col_sign = ($this->wall /2 ) - $this->colnum;
		$faculty = Faculty::findOne(Yii::$app->params['faculty_id']);
		
		$html = '<table >
		<tr>
		<td width="'.$this->colnum.'"></td>
		
		<td width="'.$col_sign .'" colspan="18" style="font-size:12px">Prepared by:
		<br /><br /><br /> 
___________________________<br />
		'.$coor.'
		<br /> Course Owner
		<br /> '.$date.'
		
		</td>
		<td width="'.$this->colnum.'"></td>
		<td width="'.$col_sign .'" colspan="18" style="font-size:12px">Approved by:
<br /><br /><br /> 
___________________________<br />
		'.$verifier.'
		<br /> '.$this->model->verifier_position.'
		<br /> '.$faculty->faculty_name_bi.'
		<br /> '.$datev.'
		
		
		</td>
		
		</tr></table>';
		
		
		$tbl = <<<EOD
		$html
EOD;

		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public $verify_y;
	
	public function signitureVerify(){
		$sign = $this->model->verifiedsign_file;

		$file = Yii::getAlias('@upload/'. $sign);
		
		$y = $this->verify_y;
		
	
		$adjy = $this->model->verified_adj_y;
		
		$posY = $y - 40 - $adjy;
		$this->pdf->setY($posY);
		

		
		$size = 100 + ($this->model->verified_size * 3);
		if($size < 0){
			$size = 10;
		}
		//echo $size;die();
		$col1 = $this->colnum + 10;
		$col_sign = $this->wall /2 ;
		$html = '<table>

		
		<tr>
		<td width="'. $col1 .'"></td>
		
		<td width="'.$col_sign .'" colspan="18" >';

		
		$html .= '</td>
		<td width="'.$col_sign .'" colspan="18" >';
		
		if($this->model->verifiedsign_file){
			if(is_file($file)){
				$html .= '<img width="'.$size.'" src="'.$file.'" />';
			}
		}
		
		$html .= '</td>
		
		</tr></table>';
		
		
		$tbl = <<<EOD
		$html
EOD;

		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('Table 4');
		$this->pdf->SetTitle('Table 4 - '.$this->model->course->course_code );
		$this->pdf->SetSubject('Table 4 - '.$this->model->course->course_code );
		$this->pdf->SetKeywords('Maklumat Kursus');



		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$this->pdf->SetMargins(12, 15, 12);
		//$this->pdf->SetMargins(0, 0, 0);
		$this->pdf->SetHeaderMargin(13);
		//$this->pdf->SetHeaderMargin(0);

		 //$this->pdf->SetHeaderMargin(0, 0, 0);
		$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$this->pdf->SetAutoPageBreak(TRUE, 20); //margin bottom

		// set image scale factor
		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$this->pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------



		// add a page
		$this->pdf->AddPage("P");
		$this->pdf->lineHeaderTable = false;
	}
	
	
}
