<?php

namespace backend\models\pdf;

use Yii;
use common\models\Common;


class AttendancePortal
{
	public $model;
	public $date;
	public $response;
	public $pdf;
	public $directoryAsset;
	
	public function generatePdf(){

		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new AttendancePortalStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$this->pdf->model = $this->model;
		$this->pdf->date = $this->date;
		$this->startPage();
		$this->body();


		$this->pdf->Output('attendance-portal.pdf', 'I');
	}
	

	
	public function body(){
		
		
		
		$wtable = 780;
		$bil = 45;
		$matrik = 130;
		$kehadiran = 90;
		$jenis = 100;
		$name = $wtable - $bil - $matrik - $kehadiran - $jenis;
		$line_height = 200;
		
		$html ='
		<table cellpadding="2" border="1" width="'.$wtable.'">
		<thead>
		<tr style="background-color:#cccccc">
			<td width="'.$bil.'" align="center" style="line-height: '.$line_height.'%;"><b>Bil</b></td>
				<td width="'.$matrik.'" style="line-height: '.$line_height.'%;">
				<b>  No. Matrik</b></td>
			<td width="'.$name.'"  style="line-height: '.$line_height.'%;">
			
			<b>  Nama</b>
			
			</td>
		
			<td width="'.$kehadiran.'" align="center" style="line-height: '.$line_height.'%;"><b>Kehadiran</b></td>
			<td width="'.$jenis.'" align="center" style="line-height: '.$line_height.'%;"><b>Jenis Data</b></td>
			
			';
		$html .= '
		</tr>
		</thead>
		
		
		';
		
		if($this->response){
			if($this->response->result){
				$x = 1;
				//style="line-height: 150%;"
				foreach($this->response->result as $row){
						$hadir = '';
						if($row->status == 1){
							$hadir = '<b style="font-size:14px;color:#1b3110">H</b>';
						}else{
							$hadir = '<b style="font-size:14px;color:#FF0000">XH</b>';
						}
						$html .= '
						<tr nobr="true">
						<td style="height: 24px;" width="'.$bil.'"  align="center">'.$x.'</td>
						<td width="'.$matrik.'">  '.$row->id .'</td>
						
						<td width="'.$name.'" style="padding:9px;">
						  '.$row->name .'
						</td>
						
						<td width="'.$kehadiran.'" align="center">'.$hadir .'</td>
						<td width="'.$jenis.'" align="center" ></td>
						
						';
						
						
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
		$this->pdf->SetHeaderMargin(10);
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
		$this->pdf->AddPage("P");
	}
	
	
}
