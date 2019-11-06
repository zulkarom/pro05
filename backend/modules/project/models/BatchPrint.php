<?php

namespace backend\modules\project\models;

use Yii;



class BatchPrint
{
	public $model;
	public $pdf;
	public $semester;
	public $batchno;
	public $directoryAsset;
	
	public function generatePdf(){
		
		//LoginAsset::register($this);

		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new BatchPrintStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$this->writeHeaderFooter();
		$this->startPage();
		
		$this->writeTop();
		
		

		$this->pdf->Output('Senarai_Peruntukan_'.$this->batchno . '.pdf', 'I');
	}
	
	public function writeHeaderFooter(){

	}
	public function writeTop(){
		$col_bil = 4;
		$col_nama = 14;
		$col_ic = 13;
		$col_acc = 13;
		$col_bank = 9;
		$col_course = 10;
		$col_program = 14;
		$col_jumlah = 7;
		$col_kampus = 8;
		$sub_total = $col_bil + $col_nama + $col_ic + $col_acc + $col_bank + $col_course + $col_program + $col_jumlah + $col_kampus;
		
		$col_tarikh = 100 - $sub_total;
		
		$html = '
		<div align="right"><b>LAMPIRAN</b></div>
		<div align="center"><b>SENARAI PROGRAM KURSUS KOKURIKULUM BERKREDIT<br />
SEMESTER '. strtoupper($this->semester->niceFormat()) .' BIL. '.$this->batchno .'</b></div><br />
		<table border="1" cellpadding="5">
			<tr nobr="true" style="font-weight:bold">
				<td width="'. $col_bil .'%">BIL.</td>
				<td width="'. $col_nama .'%">NAMA</td>
				<td width="'. $col_ic .'%">NO. KAD PENGENALAN</td>
				<td width="'. $col_acc .'%">NO. AKAUN</td>
				<td width="'. $col_bank .'%">BANK</td>
				<td width="'. $col_course .'%">KOD KURSUS / NAMA KURSUS</td>
				<td width="'. $col_program .'%">NAMA PROGRAM</td>
				<td width="'. $col_jumlah .'%">JUMLAH (RM)</td>
				<td width="'. $col_kampus .'%">KAMPUS</td>
				<td width="'. $col_tarikh .'%">TARIKH LULUS</td>
			</tr>
<tbody>';
$total = 0;
if($this->model){
	$i = 1;
	foreach($this->model as $row){
		$amount = $row->resourceCenterAmount->rs_amount + 0;
		$html .= '<tr nobr="true">
		<td>'.$i.'. </td>
		<td>'.strtoupper($row->eft_name).'</td>
		<td>'. $row->eftIcString .'</td>
		<td>'. $row->eft_account .'</td>
		<td>'.strtoupper($row->eft_bank).'</td>
		<td>'. strtoupper($row->course->course_name . ' ('. $row->group->group_name.')') .'</td>
		<td>'. strtoupper($row->pro_name) .'</td>
		<td>'. strtoupper($row->campus->campus_name) .'</td>
		<td>'.  date('d/m/Y', strtotime($row->approved_at)) .'</td>
		<td>'. $amount .'</td>
	</tr>';
	$total += $amount;
$i++;
	}
}


$html .='</tbody>';

$html .= '<tr nobr="true">
	<td colspan="9" align="center"><b>JUMLAH</b></td><td><b>RM'.$total.'</b></td>

</tr>';


$html .= '</table>
		';
		$this->pdf->SetFont('helvetica', '', 9.5);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('Pusat Kokurikulum');
		$this->pdf->SetTitle('SENARAI PERUNTUKAN');
		$this->pdf->SetSubject('SENARAI PERUNTUKAN');
		$this->pdf->SetKeywords('');

		// set default header data
		$this->pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		//$this->pdf->writeHTML("<strong>hai</strong>", true, 0, true, true);
		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		//$this->pdf->SetMargins(25, 10, PDF_MARGIN_RIGHT);
		$this->pdf->SetMargins(18, 10, 18);
		//$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->pdf->SetHeaderMargin(0);

		 //$this->pdf->SetHeaderMargin(0, 0, 0);
		$this->pdf->SetFooterMargin(0);

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
		$this->pdf->AddPage("L");
	}
	
	
}
