<?php

namespace backend\modules\project\models;

use Yii;
use common\models\Common;


class ProjectPrint
{
	public $model;
	public $pdf;
	public $directoryAsset;

	
	public function generatePdf(){

		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new Tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$this->writeHeaderFooter();
		$this->startPage();
		
		$this->writeCoverPage();
		 
		 $this->writeHeadContent();
		$this->writeContent();
		

		$this->writeSigniture();
		$this->writeTentative();
		$this->writeFinance();
		
		$this->writeCommittee(); 
		
		$this->writeEft();
	

		$this->pdf->Output('kertas-kerja.pdf', 'I');
	}
	
	public function writeHeadContent(){
		$this->pdf->SetMargins(24, 10, 24);
		$this->pdf->SetTopMargin(90);
		$this->pdf->AddPage("P");
		
		$html = '<br /><br />
		
		
		<table align="center">
		<tr>
		<td style="border-bottom:1px #000000 solid">
		
		<b>UNIVERSITI MALAYSIA KELANTAN<br /><br />
		KERTAS KERJA UNTUK KELULUSAN<br />
		PUSAT KOKURIKULUM<br />PEJABAT TIMBALAN NAIB CANSELOR (HAL EHWAL PELAJAR DAN ALUMNI)<br />
		UNIVERSITI MALAYSIA KELANTAN
		<br /><br />
		'. strtoupper($this->model->pro_name) .'
		<br /><br />
		
		</b>
		</td>
		</tr>
		
		</table>
		
		
		
		';
		$this->pdf->SetFont('helvetica', '', 10.5);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
	}
	
	public function writeContent(){
		
		$html = '<br /><br />
		
		
		<table border="0">
		<tr>
		<td width="10%"><b>1.0</b>
		</td>
		<td width="90%"><b>TUJUAN</b>
		<br /><br />
		'.$this->model->purpose .'
		<br />
		</td>
		</tr>
		
		<tr>
		<td><b>2.0</b>
		</td>
		<td><b>PENGENALAN/ LATAR BELAKANG</b>
		<br /><br />
		'.$this->model->background .'
		<br />
		</td>
		
		
		</tr>
		
		<tr>
		<td><b>3.0</b>
		</td>
		<td><b>OBJEKTIF</b>
		<br /><br />
		';
		
		$obj = $this->model->objectives;
		if($obj){
			$html .= '<table>';
			foreach($obj as $ob){
				$html .= '<tr><td width="5%"> - </td><td width="90%">'.$ob->obj_text .'</td></tr>';
			}
			$html .= '</table>';
		}
		
		
		
		$html .= '
		<br />
		</td>
		
		
		</tr>
		
		<tr>
		<td><b>4.0</b>
		</td>
		<td><b>PELAKSANAAN DAN CADANGAN TARIKH PROGRAM</b>
		<br /><br />
		Program ini dicadangkan untuk dilaksanakan seperti berikut:<br />
		<table>
		<tr>
		<td width="10%"></td>
		<td width="24%">Tarikh</td>
		<td width="3%">:</td>
		<td width="65%">'.$this->model->getProjectDate().'</td>
		</tr>
		<tr>
		<td></td>
		<td>Tempat</td>
		<td>:</td>
		<td>'.$this->model->location.'</td>
		</tr>
		
		<tr>
		<td></td>
		<td>Masa</td>
		<td>:</td>
		<td>'.$this->model->getProjectTime().'</td>
		</tr>
		
		<tr>
		<td></td>
		<td>Kumpulan Sasaran</td>
		<td>:</td>
		<td>'.$this->model->pro_target .'</td>
		</tr>';
		
		if($this->model->agency_involved){
			$html .= '<tr>
		<td></td>
		<td>Agensi yang terlibat</td>
		<td>:</td>
		<td>'.$this->model->agency_involved .'</td>
		</tr>';
		}
		
		
		$html .= '</table>
		<br /><br />
		Tentatif program adalah sebagaimana Lampiran 1<br />
		</td>
		
		
		</tr>
		
		<tr nobr="true">
		<td><b>5.0</b>
		</td>
		<td><b>IMPLIKASI KEWANGAN</b>
		<br /><br />
		<table>
		<tr>
		<td width="10%">5.1</td>
		<td width="90%">Anggaran Perbelanjaan untuk mengadakan program ' .$this->model->pro_name .' adalah sebanyak RM'.number_format($this->model->totalExpenses, 2) .'. Perincian berbelanjaan adalah sebagaimana <b>Lampiran</b>. Segala perbelanjaan peruntukan akan menggunakan <b>Tabung Sukan, Kebudayaan dan Kokurikulum UMK</b>.</td>
		</tr>
		</table>
		<br />
		</td>
		
		
		</tr>
		
		<tr nobr="true">
		<td><b>6.0</b>
		</td>
		<td><b>SYOR / KELULUSAN</b>
		<br /><br />
		<table>
		<tr>
		<td width="10%">6.1</td>
		<td width="90%">Dengan segala hormatnya Pengarah, Pusat Kokurikulum dipohon untuk menimbang dan meluluskan permohonan bagi cadangan mengadakan program tersebut.</td>
		</tr>
		</table>
		<br />
		</td>
		
		
		</tr>
		
		</table>
		<br /><br />
		';
		//$this->pdf->SetFont('helvetica', '', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
	}
	
	public function writeSigniture(){
		
		$course = $this->model->course;
		
		$html = '<br /><table border="0" nobr="true">
		<tr>
		<td width="45%">Disediakan oleh:
		<br /><br /><br />
		.......................................................<br />
		';
		
		
		
		if( $this->model->topPosition){
			$html .= '<b>' . strtoupper($this->model->topPosition->student->student_name) .'</b><br />';
			$html .= $this->model->topPosition->position;
		}
		
		$fasi = $this->model->fasiCoorPost;
		
		
		$html .= '<br />
		'.$this->model->pro_name .' <br />
		Tarikh: '.date('d/m/Y').'
		
		</td><td width="10%"></td> 
		<td width="40%">Disemak oleh:
		<br /><br /><br />
		.......................................................<br />
		<b>'.strtoupper($this->model->fasi->user->fullname) .'</b><br />
		'.$fasi.'<br />
		Kumpulan '.$this->model->group->group_name.'<br />
		Kursus '.$this->model->course->course_code.' '.$this->model->course->course_name.'<br />
		Tarikh: '.date('d/m/Y').'
		
		</td>
		</tr>
		</table>';
		
		$html .= '<br /><br /><br />
		<table nobr="true"><tr><td>
		Disokong oleh:
		<br /><br /><br />
		.......................................................<br />
		<b>SITI NORHIDAYAH BINTI MAT HUSSIN</b><br />
		Penolong Pendaftar<br />
		Pusat Kokurikulum<br />
		Pejabat Timbalan Naib Canselor (Hal Ehwal Pelajar dan Alumni)<br />
		Tarikh: ..........................
		</td></tr></table>
		<br /><br /><br />
		<table nobr="true"><tr><td>
		Diluluskan / Tidak Diluluskan:<br /><br /><br />
		.......................................................<br />
		<b>DR. MOHD NAZRI BIN MUHAYIDDIN</b><br />
		Pengarah<br />
		Pusat Kokurikulum<br />
		Pejabat Timbalan Naib Canselor (Hal Ehwal Pelajar dan Alumni)<br />
		Tarikh: ..........................
		<br /><br />
		
		Ulasan Pengarah Pusat Kokurikulum:
		<br />
		<table width="90%" cellpadding="9">
		<tr>
		<td style="border-bottom:1px #000000 solid">&nbsp;</td>
		</tr>
		<tr>
		<td style="border-bottom:1px #000000 solid">&nbsp;</td>
		</tr>
		</table>
		
		</td></tr></table>
		';
		$tbl = <<<EOD
		$html
EOD;
		$this->pdf->SetMargins(24, 10, 24);
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeHeaderFooter(){
	
		$this->pdf->status = $this->model->status;
	}
	
	public function writeCoverPage(){
		$this->pdf->SetMargins(13, 10, 13);
		//$this->pdf->SetMargins(0, 0, 0);
		$this->pdf->SetHeaderMargin(0);
		//$this->pdf->SetHeaderMargin(0);

		 //$this->pdf->SetHeaderMargin(0, 0, 0);
		$this->pdf->SetFooterMargin(20);

		

		// ---------------------------------------------------------

$semester = $this->model->semester;
$course = $this->model->course;

		// add a page
		$this->pdf->AddPage("P");
		$html = '<table border="3" align="center" cellpadding="30">
		<tr>
		<td style="height:900px">
		<br /><br /><br />
		<div align="center"><img src="images/logo4.png" width="110" /></div>
		<br /><br /><br />
<b>KERTAS KERJA UNTUK PERTIMBANGAN</b>
<br /><br /><br />

<b>PUSAT KOKURIKULUM<br />PEJABAT TIMBALAN NAIB CANSELOR (HAL EHWAL PELAJAR DAN ALUMNI)</b>

<br /><br /><br />

<b>'. strtoupper($this->model->pro_name) .'</b>

<br /><br />
<b>PADA:</b>
<br /><br />

'.strtoupper($this->model->getProjectDate()).'

<br /><br />
'. strtoupper($this->model->location) .'

<br /><br /><br />
<b>ANJURAN</b>
<br /><br />
'.strtoupper($course->course_name).' ('.strtoupper($course->course_code).')

<br />KUMPULAN '.$this->model->group->group_name .'
<br />SEMESTER '.strtoupper($semester->session()) .' SESI '.$semester->years();
if($this->model->collaboration){
	$html .= '<br /><br /><br /><b>DENGAN KERJASAMA:</b>
	
	<br /><br /> '.strtoupper($this->model->collaboration) .'
	';
}

$html .= '

</td>
		</tr>
		</table>';
		$this->pdf->SetFont('helvetica', '', 10.5);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeTentative(){
		$this->pdf->SetMargins(24, 10, 24);
		$this->pdf->AddPage("P");
		
		$html = '
		<br />
		<div align="right"><b>LAMPIRAN 1</b></div>
		
		<br /><br />
		<div align="center"><b>TENTATIF<br />
		'.strtoupper($this->model->pro_name) .'<br />
		'.strtoupper($this->model->getProjectDate()) .'
		</b></div>
		<br /><br />';
		
		$days = $this->model->tentativeDays;
		
		if($days){
			foreach($days as $day){
				$html .= '<b>'.Common::getTarikhHari($day->pro_date) .'</b>
		
			<br /><br />';
			$times = $day->tentativeTimes;
			
			if($times){
				$html .= '<table border="1" cellpadding="4">
				<tr>
					<td width="20%"><b>MASA</b></td>
					<td width="55%" align="center"><b>ATURCARA</b></td>
					<td width="25%" align="center"><b>LOKASI</b></td>
				</tr>';
				foreach($times as $time){
					$html .= '<tr>
					<td>'.$this->model->convertTime($time->ttf_time) .'</td>
					<td>'.nl2br($time->ttf_item) .'</td>
					<td>'.$time->ttf_location .'</td>
				</tr>';
				}
				
				$html .=' </table>
				<br /><br />
				';
			}
			
			
		
		
			}
		}
		
		$tbl = <<<EOD
		$html
EOD;
		$this->pdf->SetFont('helvetica', '', 10.5);
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeFinance(){
		$this->pdf->SetMargins(24, 10, 24);
		$this->pdf->AddPage("P");
		
		$html = '
		<br />
		<div align="right"><b>LAMPIRAN 2</b></div>
		
		<br /><br />
		<div align="center"><b>PERINCIAN IMPLIKASI KEWANGAN<br />
		'.strtoupper($this->model->pro_name) .'<br />
		'.strtoupper($this->model->getProjectDate()) .'
		</b></div>
		<br /><br />
		<b>A) SUMBER PENDAPATAN</b>
		<br /><br />
		';
		
		$resources = $this->model->resources;
			
			if($resources){
				$total = 0;
				$html .= '<table border="1" cellpadding="4">
				<tr>
					<td width="8%"><b>BIL</b></td>
					<td width="52%"><b>PERKARA</b></td>
					<td width="15%" align="center"><b>KUANTITI</b></td>
					<td width="25%" align="center"><b>JUMLAH (RM)</b></td>
				</tr>';
				$i = 1;
				foreach($resources as $r){
					$html .= '<tr>
					<td>'.$i.'. </td>
					<td>'.$r->rs_name .'</td>
					<td align="center">'.$r->rs_quantity .'</td>
					<td align="center">RM'.$r->rs_amount .'</td>
				</tr>';
				$total += $r->rs_amount;
				$i++;
				}
				$html .= '
				<tr>
					<td colspan="3" align="right"> <b>JUMLAH</b></td>
					<td align="center"><b>RM'.number_format($total,2) .'</b></td>
				</tr>
				';
				
				$html .=' </table>';
				
			}
				
				$html .= '<br /><br />
				<b>B) ANGGARAN PERBELANJAAN</b>
				<br /><br />
				';
				
				$expenses = $this->model->expenseBasics;
				
				$wbil = 'width="8%"';
				$wperkara = 'width="52%"';
				$wkuantiti = 'width="15%"';
				$wjumlah = 'width="25%"';
				$cellpadding_main = 'cellpadding="5"';
				$cellpadding_item = 'cellpadding="5"';
			
			if($expenses){
				$total = 0;
				$borders = 'style="border-top: 1px solid #000000;border-left: 1px solid #000000; border-right: 1px solid #000000;padding:50"';
				$html .= '
				
				
				<table '.$cellpadding_main.'>
				<tr>
					<td '.$wbil.' border="1"><b>BIL</b></td>
					<td '.$wperkara.' border="1"><b>PERKARA</b></td>
					<td '.$wkuantiti.' align="center" border="1"><b>KUANTITI</b></td>
					<td '.$wjumlah.' align="center" border="1"><b>JUMLAH (RM)</b></td>
				</tr>
				</table>
				';
				$i = 1;
				foreach($expenses as $r){
					$html .= '<table '.$cellpadding_main.'><tr>
					<td '.$wbil.' '.$borders.'>'.$i.'. </td>
					<td '.$wperkara.' '.$borders.'>'.$r->exp_name .'</td>
					<td '.$wkuantiti.' align="center" '.$borders.'>'.$r->quantity .'</td>
					<td '.$wjumlah.' align="center" '.$borders.'>RM'.$r->amount .'</td>
				</tr>
				</table>
				';
				$total += $r->amount;
				$i++;
				}
				
				$tools = $this->model->expenseTools;
				$border_side = 'style="border-left: 1px solid #000000; border-right: 1px solid #000000"';
				
				if($tools){
					$html .= '<table '.$cellpadding_main.'><tr>
							<td '.$wbil.' '.$borders.'>'.$i.'.</td>
							<td '.$wperkara.' '.$borders.'>Alatan Aktiviti</td>
							<td '.$wkuantiti.' align="center" '.$borders.'></td>
							<td '.$wjumlah.' align="center" '.$borders.'></td>
						</tr>
						</table>
						';
					$kirat = count($tools);
					$x = 1;
					foreach($tools as $t){
						$style_pad = $x == $kirat ? '<span style="font-size:18px">&nbsp;</span>' : '';
						$html .= '<table ><tr>
							<td '.$wbil.' '.$border_side.'>'.$style_pad.'</td>
							<td '.$wperkara.' '.$border_side.'><span>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;'.$t->exp_name .'</span></td>
							<td '.$wkuantiti.' align="center" '.$border_side.'>'.$t->quantity .'</td>
							<td '.$wjumlah.' align="center" '.$border_side.'>RM'.$t->amount .'</td>
						</tr></table>';
						$total += $t->amount;
					$x++;
					}
				$i++;
				}
				
				$rents = $this->model->expenseRents;
				if($rents){
					$html .= '<table '.$cellpadding_main.'><tr>
							<td '.$wbil.' '.$borders.'>'.$i.'.</td>
							<td '.$wperkara.' '.$borders.'>Sewaan</td>
							<td '.$wkuantiti.' align="center" '.$borders.'></td>
							<td '.$wjumlah.' align="center" '.$borders.'></td>
						</tr>
						</table>
						';
					$kirat = count($rents);
					$x = 1;
					foreach($rents as $t){
						$style_pad = $x == $kirat ? '<span style="font-size:18px">&nbsp;</span>' : '';
						$html .= '<table ><tr>
							<td '.$wbil.' '.$border_side.'>'.$style_pad.'</td>
							<td '.$wperkara.' '.$border_side.'><span>&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;'.$t->exp_name .'</span></td>
							<td '.$wkuantiti.' align="center" '.$border_side.'>'.$t->quantity .'</td>
							<td '.$wjumlah.' align="center" '.$border_side.'>RM'.$t->amount .'</td>
						</tr></table>';
						$total += $t->amount;
					$x++;
					}
				$i++;
				}
				
				
				$html .= '<table '.$cellpadding_main.'>
				<tr>
					<td border="1" colspan="3" align="right"> <b>JUMLAH PERBELANJAAN</b></td>
					<td border="1" align="center"><b>RM'.number_format($total,2) .'</b></td>
				</tr>
				';
				
				$html .=' </table>';
			}
		
		$tbl = <<<EOD
		$html
EOD;
		$this->pdf->SetFont('helvetica', '', 10.5);
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeCommittee(){
		$this->pdf->SetMargins(24, 10, 24);
		$this->pdf->AddPage("P");
		
		$html = '<br /><div align="center"><b>SENARAI JAWATANKUASA PROGRAM</b></div>
		<br />
		<table border="0" cellpadding="10">';
		
		$main = $this->model->mainCommittees;
		if($main){
			foreach($main as $m){
				$html .= '<tr>
			<td width="30%"><b>'.$m->position .'</b></td>
			<td width="5%">:</td>
			<td width="68%">'.$m->student->student_name .'</td>
		</tr>
		
		';
			}
		}
		
		
		
		$html .= '</table>
		
		<br /><br />
		
		<b>AHLI JAWATANKUASA</b>
		<br /><br />
		<table border="0" cellpadding="10">';
		
		$main = $this->model->committeePositions;
		if($main){
			foreach($main as $m){
				$html .= '<tr nobr="true">
			<td width="38%"><b>'.$m->position .'</b></td>
			<td width="5%">:</td>
			<td width="50%">';
			$members = $m->committeeMembers;
			if($members){
				foreach($members as $mem){
					$html .= $mem->student->student_name . '<br />';
				}
			}
			
			$html .= '</td>
		</tr>
		
		';
			}
		}
		$html .= '</table>';
		
		$tbl = <<<EOD
		$html
EOD;
		$this->pdf->SetFont('helvetica', '', 11);
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeEft(){
		$this->pdf->SetMargins(13, 10, 13);
		$this->pdf->AddPage("P");
		$this->pdf->SetFont("arialnarrow", '', 11);
		$this->pdf->hasPageNumber = false;
		
		$html = '<table border="1" cellpadding="2">
		<tr><td><b style="font-size:12pt">&nbsp; UMK(B03.06)(16-15)</b></td><td></td><td> &nbsp;Tarikh Kuatkuasa :  8 MAC 2015</td></tr>
		
		<tr><td colspan="3" align="center">
		
		
		<table cellpadding="5">
		<tr>
		<td width="10%"><img src="images/logo5.jpg" /></td>
		<td width="90%" align="center"><b><br />BORANG MAKLUMAT AKAUN BANK BAGI TUJUAN BAYARAN SECARA EFT<br /><br />
		Honorarium/Tuntutan Perjalanan/Tuntutan Pelbagai Bagi Tetamu Jemputan Dan Pensyarah Sambilan<br /><br />
		PTJ: <u>PUSAT KOKURIKULUM</u><br /></b></td>
		</tr>
		</table>
		
		
		
		</td></tr>
		
		</table>
<br /><br />
		';
		
		$tbl = <<<EOD
		$html
EOD;
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		$this->pdf->SetMargins(20, 10, 13);
		
		$html = '&nbsp;&nbsp;<table border="1" cellpadding="8">
		
		<tr>
		<td width="27%"><b>*NAMA PENUH:</b>
		<br />
		</td>
		<td width="73%">&nbsp; ';
		$html .= '<b>' . strtoupper($this->model->eft_name) . '</b>';
		$html .= '</td>
		</tr>
		
		<tr>
		<td><b>*NO. KAD PENGENALAN:</b>
		<br />
		</td>
		<td>
		
		
		
		
		
		&nbsp;
		
		<table border="1" cellpadding="6">
		<tr>';
		$ic = $this->model->eft_ic;
		$aic = str_split($ic, 1);
		$lg = count($aic) - 1;
		for($i=0;$i<=$lg;$i++){
			if($i== 6 or $i == 8){
				$html .= '<td width="31px" height="35" align="center"><b style="font-size:12pt">-</b></td>';
			}
			$html .= '<td width="31px" height="35" align="center"><b style="font-size:12pt">'.$aic[$i].'</b></td>';
		}
		
		$html .= '</tr>
		</table>
		
		</td>
		</tr>
		
		<tr>
		<td><b>*NO. AKAUN:</b>
		<br />
		</td>
		<td>
		
		&nbsp;
		
		<table border="1" cellpadding="6">
		<tr>';
		$acc = $this->model->eft_account;
		
		$aacc = str_split($acc, 1);
		$lg = count($aacc) - 1;
		$x_str = '';
		for($i=0;$i<=$lg;$i++){
			
			if($i <= 13){
				$html .= '<td width="31px" height="35" align="center"><b style="font-size:12pt">'.$aacc[$i].'</b></td>';
			}else{
				$x_str .= $aacc[$i];
			}
		}
		
		$html .= '</tr>
		</table>';
		
		if($x_str){
		$html .= '<table border="1" cellpadding="6">
		<tr>';
		$acc = $x_str;
		$aacc = str_split($acc, 1);
		$lg = count($aacc) - 1;
		for($i=0;$i<=$lg;$i++){
			if($i <= 13){
				$html .= '<td width="31px" height="35" align="center"><b style="font-size:12pt">'.$aacc[$i].'</b></td>';
			}
		}
		
		$html .= '</tr>
		</table>';
		}
		
		
		$html .= '</td>
		</tr>
		
		<tr>
		<td><b>*NAMA BANK:</b>
		<br />
		</td>
		<td>&nbsp; ';
		
		$html .= '<b>' . strtoupper($this->model->eft_bank) . '</b>';
		$html .= '</td>
		</tr>
		
		<tr>
		<td><b>ALAMAT  EMAIL:</b><br />
	(bagi tujuan makluman<br />
	pembayaran)
		
		</td>
		<td>&nbsp; ';
		
		$html .= '<span style="font-size:12pt">' . $this->model->eft_email . '</span>';
		$html .= '</td>
		</tr>
		
		<tr>
		<td><b>TANDATANGAN:</b><br />
		<br />
		</td>
		<td></td>
		</tr>

		
		
		</table>
		
<br />

<table>
<tr>
<td>*Wajib diisi. Sila pastikan maklumat lengkap dimasukkan.<br /><br />
* PTJ berkaitan diminta membuat satu simpanan borang untuk tujuan rekod Jabatan.</td>
</tr>
</table>

		
		
		';
		
		$tbl = <<<EOD
		$html
EOD;
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('Pusat Kokurikulum');
		$this->pdf->SetTitle('KERTAS KERJA');
		$this->pdf->SetSubject('KERTAS KERJA');
		$this->pdf->SetKeywords('');



		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set auto page breaks
		$this->pdf->SetAutoPageBreak(TRUE, 20); //margin bottom

		// set image scale factor
		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$this->pdf->setLanguageArray($l);
		}
		
	}

	
	
}
