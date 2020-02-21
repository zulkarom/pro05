<?php

namespace backend\models\pdf;

use Yii;
use common\models\Common;


class Attendance
{
	public $model;
	public $response;
	public $pdf;
	public $directoryAsset;
	
	public function generatePdf(){

		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new AttendanceStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$this->startPage();
		$this->body();


		$this->pdf->Output('borang-tuntutan.pdf', 'I');
	}
	

	
	public function body(){
		
		
		
		$wtable = 1160;
		$bil = 45;
		$box = 50;
		$matrik = 130;
		$boxall = $box * 14;
		$name = $wtable - $bil - $matrik - $boxall;
		
		$html ='
		<table cellpadding="2" border="1" width="'.$wtable.'">
		<thead>
		<tr>
		<td colspan="17" style="line-height: 160%;">
			
		 <b>Semester</b><span>&nbsp;&nbsp;&nbsp;&nbsp;</span>'. strtoupper($this->model->semester->fullFormat()).'<br />
		   
		   <span>&nbsp;</span><b>Subjek</b><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>'.$this->model->acceptedCourse->course->course_code.' - '.strtoupper($this->model->acceptedCourse->course->course_name).'
			

		</td>
		</tr>
		<tr>
		<td colspan="17">
	
		<b>   Kumpulan<span>&nbsp;&nbsp;&nbsp;</span>'.$this->model->applicationGroup->group_name.'</b>

		</td>
		</tr>
		<tr style="background-color:#ebebeb">
			<td rowspan="2" width="'.$bil.'" align="center" style="line-height: 250%;"><b>Bil</b></td>
			<td rowspan="2" width="'.$name.'" align="center" style="line-height: 250%;"><b>Nama</b></td>
			<td rowspan="2" width="'.$matrik.'" align="center" style="line-height: 250%;"><b>No. Matrik</b></td>';
			$html .= '<td colspan="14" width="'.$boxall .'" align="center"><b>Tarikh & Tandatangan</b></td>';
		$html .= '
		</tr>
		<tr style="background-color:#ebebeb">
			';
		for($i=1;$i<=14;$i++){
			$html .= '<td width="'.$box.'"></td>';
		}
		$html .= '
		</thead>
		</tr>
		
		
		';
		
		if($this->response){
			if($this->response->result){
				$x = 1;
				//style="line-height: 150%;"
				foreach($this->response->result as $row){
						$html .= '
						<tr nobr="true">
						<td style="height: 27px;" width="'.$bil.'"  align="center">'.$x.'</td>
						<td width="'.$name.'" style="padding:9px;">
						<table>
						<tr>
						<td width="2%"></td><td width="98%">'.$row->name .'</td>
						</tr>
						</table>
						</td>
						<td width="'.$matrik.'" align="center">'.$row->id .'</td>';
						
						for($d=1;$d<=14;$d++){
							$html .= '<td width="'.$box.'"></td>';
						}
						
						$html .= '</tr>';
					$x++;
				}
			}
		}
	
		
		$html .= '</table>
		';
		
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
	}
	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('eFasi');
		$this->pdf->SetTitle('Attendance List');
		$this->pdf->SetSubject('Attendance List');
		$this->pdf->SetKeywords('');



		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$this->pdf->SetMargins(15, 40, 15);
		//$this->pdf->SetMargins(0, 0, 0);
		$this->pdf->SetHeaderMargin(5);
		//$this->pdf->SetHeaderMargin(0);

		 //$this->pdf->SetHeaderMargin(0, 0, 0);
		$this->pdf->SetFooterMargin(20);

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

		$this->pdf->setImageScale(1.53);
		
		$this->pdf->SetFont('arial', '', 8.5);

		// add a page
		$this->pdf->AddPage("L");
	}
	
	
}
