<?php

namespace backend\models\pdf;

use Yii;
use common\models\Common;


class AttendanceSummary
{
	public $model;
	public $response;
	public $pdf;
	public $directoryAsset;
	
	public function generatePdf(){
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new AttendanceSummaryStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$this->pdf->model = $this->model;
		
		$this->startPage();
		$this->body();

		$this->pdf->Output('attendance.pdf', 'I');
	}
	
	public function body(){
		$wtable = 1160;
		$bil = 45;
		$box = 50;
		$matrik = 90;
		$boxall = $box * 14;
		$name = $wtable - $bil - $matrik - $boxall;
		
		$html ='
		<table cellpadding="2" border="1" width="'.$wtable.'">
		<thead>
		
		<tr style="background-color:#ebebeb">
			<td width="'.$bil.'" align="center" style="line-height: 250%;"><b>#</b></td>
			<td width="'.$matrik.'"  style="line-height: 250%;"><b>  Student ID</b></td>
			<td width="'.$name.'" style="line-height: 250%;"><b>  Student Name</b></td>
			';
			
			foreach($this->response->colums->result as $col){
			$html .= '<td width="'.$box.'" style="line-height: 250%;" align="center"><b>'.date('d-m', strtotime($col->date)) .'</b></td>';
			
			}
		
		$html .= '
		</tr>
		</thead>
		';
		
		if($this->response){
			if($this->response->student->result){
				$x = 1;
				//style="line-height: 150%;"
				foreach($this->response->student->result as $row){
						$html .= '
						<tr nobr="true">
						<td style="height: 27px;" width="'.$bil.'"  align="center">'.$x.'</td>
						<td width="'.$matrik.'">  '.$row->id .'</td>
						<td width="'.$name.'" style="padding:9px;">
						<table>
						<tr>
						<td width="2%"></td><td width="98%">'.$row->name .'</td>
						</tr>
						</table>
						</td>
						';
						
						foreach($this->response->colums->result as $col){
							$res = $this->response->attend[$col->id]->students[$row->id]->status;
							if(strtotime($col->date) <= time()){
							if($res == 1){
								$hadir = '<b style="font-size:14px;color:#1b3110">H</b>';
							}else{
								$hadir = '<b style="font-size:14px;color:#FF0000">XH</b>';
							}
							}else{
								$hadir = '';
							}
							
						$html .= '<td width="'.$box.'" style="line-height: 250%;" align="center"><b>'.$hadir .'</b></td>';
						
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
		$this->pdf->SetTitle('Overall Attendance');
		$this->pdf->SetSubject('Overall Attendance');
		$this->pdf->SetKeywords('');



		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$this->pdf->SetMargins(15, 40, 15);
		//$this->pdf->SetMargins(0, 0, 0);
		$this->pdf->SetHeaderMargin(10);
		//$this->pdf->SetHeaderMargin(0);

		 //$this->pdf->SetHeaderMargin(0, 0, 0);
		$this->pdf->SetFooterMargin(18);

		// set auto page breaks
		$this->pdf->SetAutoPageBreak(TRUE, 23); //margin bottom

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
