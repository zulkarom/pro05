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
		PUSAT KOKURIKULUM DAN PEMBANGUNAN PELAJAR<br />PEJABAT TIMBALAN NAIB CANSELOR (HAL EHWAL PELAJAR DAN ALUMNI)<br />
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
		<td></td>
		</tr>
		
		<tr>
		<td></td>
		<td>Agensi yang terlibat</td>
		<td>:</td>
		<td></td>
		</tr>
		
		</table>
		<br /><br />
		Tentatif program adalah sebagaimana lampiran 1<br />
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
		<td width="90%">Anggaran Perbelanjaan untuk mengadakan program ' .$this->model->pro_name .' adalah sebanyak [jumlah]. Perincian berbelanjaan adalah sebagaimana <b>Lampiran</b>. Segala perbelanjaan peruntukan akan menggunakan <b>Tabung Kokurikulum UMK</b></td>
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
		<td width="90%">Dengan segala hormatnya Pengarah, Pusat Kokurikulum dan Pembangunan Pelajar dipohon untuk menimbang dan meluluskan permohonan bagi cadangan mengadakan program tersebut.</td>
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
		$this->pdf->SetMargins(24, 10, 24);
		$application = $this->model->application;
		$course = $application->acceptedCourse->course;
		$html = '<table border="0">
		<tr nobr="true">
		<td width="45%">Disediakan oleh:
		<br /><br /><br />
		.......................................................<br />
		<b>'.strtoupper($this->model->topPosition->student->student_name) .'</b><br />
		'.$this->model->topPosition->position .'<br />
		'.$this->model->pro_name .' <br />
		Tarikh: '.date('d/m/Y').'
		
		</td><td width="15%"></td> 
		<td width="35%">Disemak oleh:
		<br /><br /><br />
		.......................................................<br />
		<b>'.strtoupper($application->fasi->user->fullname) .'</b><br />
		Kumpulan '.$application->applicationGroup->group_name.'<br />
		Kursus '.$course->course_code.'<br />
		Tarikh: '.date('d/m/Y').'
		
		
		</td>
		</tr>
		</table>
		
		<br /><br /><br />
		Disokong oleh:
		<br /><br /><br />
		.......................................................<br />
		<b>SITI NORHIDAYAH BINTI MAT HUSSIN</b><br />
		Penolong Pendaftar<br />
		Pusat Kokurikulum<br />
		Pejabat Timbalan Naib Canselor (Hal Ehwal Pelajar dan Alumni)
		<br /><br />
		
		Diluluskan / Tidak Diluluskan:<br /><br /><br />
		.......................................................<br />
		<b>DR. MOHD NAZRI BIN MUHAYIDDIN</b><br />
		Pengarah<br />
		Pusat Kokurikulum<br />
		Pejabat Timbalan Naib Canselor (Hal Ehwal Pelajar dan Alumni)
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
		
		
		';
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeHeaderFooter(){
	
		$this->pdf->footer_html ='';
	}
	
	public function writeCoverPage(){
		$this->pdf->SetMargins(13, 10, 13);
		//$this->pdf->SetMargins(0, 0, 0);
		$this->pdf->SetHeaderMargin(0);
		//$this->pdf->SetHeaderMargin(0);

		 //$this->pdf->SetHeaderMargin(0, 0, 0);
		$this->pdf->SetFooterMargin(20);

		

		// ---------------------------------------------------------

$application = $this->model->application;
$semester =$application->semester;
$course = $application->acceptedCourse->course;

		// add a page
		$this->pdf->AddPage("P");
		$html = '<table border="3" align="center" >
		<tr>
		<td style="height:900px">
		<br /><br /><br />
		<div align="center"><img src="images/logo4.png" width="110" /></div>
		<br /><br /><br />
<b>KERTAS KERJA UNTUK PERTIMBANGAN</b>
<br /><br /><br />

<b>PUSAT KOKURIKULUM DAN PEMBANGUNAN PELAJAR<br />PEJABAT TIMBALAN NAIB CANSELOR (HAL EHWAL PELAJAR DAN ALUMNI)</b>

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

<br />KUMPULAN '.$application->applicationGroup->group_name .'
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
					<td>'.$time->ttf_item .'</td>
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
				$html .= '<tr>
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
