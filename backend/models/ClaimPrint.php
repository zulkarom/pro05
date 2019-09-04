<?php

namespace backend\models;

use Yii;
use common\models\Common;


class ClaimPrint
{
	public $model;
	public $pdf;
	public $directoryAsset;
	public $bhg_a_Y;
	public $bhg_b_Y;
	public $bhg_bstart_Y;
	public $bhg_bstart_Y_data;
	
	public $sum_begin_y;
	
	public $total_lec = 0;
	public $total_tut = 0;
	public $total_prac = 0;
	public $total_hour = 0;
	
	public function generatePdf(){

		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new Tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$this->writeHeaderFooter();
		$this->startPage();
		
		 $this->writeTitle();
		$this->writeMonthSem();
		
		$this->bahagian_A_form();
		$this->bahagian_A_data();
		
		$this->bahagian_B(); 
		
		
		//$this->pdf->AddPage("P");
		
		$this->writeSummary();
		$this->writeSummary_data();
		
		$this->bahagian_C();
		
		$this->bahagian_D();
		
	

		$this->pdf->Output('borang-tuntutan.pdf', 'I');
	}
	
	public function writeHeaderFooter(){
		$this->pdf->top_margin_first_page = - 4;
		$this->pdf->header_first_page_only = true;
		$this->pdf->header_html ='
		<table cellpadding="10">
		<tr><td align="right">
		UMK.A04/PA-1/2007
		</td></tr>
		</table>
		<div align="center"><img width="300" src="images/logo-umk.png" /></div>
		';
		
		
		
		$this->pdf->footer_first_page_only = true;
		$this->pdf->footer_html ='';
	}

	
	public function getSemester(){
		$session = $this->model->semester->session() ;
		$years = $this->model->semester->years();
		return $session . ' Sesi ' . $years;
	}
	
	public function bahagian_A_data(){
		$this->pdf->SetFont('times', '', 10);
		$this->pdf->setY($this->bhg_a_Y + 3);
		
		$html ='
		
		<br />
		<br />
		<table border="0" style="padding:7px">
		<tr>
		<td width="35%" colspan="3">
		</td>

		<td width="60%" colspan="2">'. strtoupper($this->model->application->fasi->user->fullname) .'</td>
		</tr>
		</table>';
		
		
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');

		$this->pdf->setY(87.5);
		
		$html = '<table border="0" style="padding:7px">
		<tr>
		<td width="35%" colspan="3">
		</td>';
			
			if($this->model->application->fasi->staff_no == '0'){
				$staff = '-';
			}else{
				$staff = $this->model->application->fasi->staff_no;
			}
		$html .='<td width="37%">'. strtoupper($staff) .'</td>
		
		<td width="25%">'. $this->model->application->fasi->handphone .'</td>
		</tr>
		
		</table>
		';
		
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		//$y = $this->pdf->getY();
		$this->pdf->setY(96);
		
		$html = '<table border="0" style="padding:7px">
		<tr>
		<td width="35%" colspan="3">
		</td>

		<td width="60%">'. $this->model->application->fasi->nric .'</td>
		
		</tr>
		
		</table>
		';
		
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		$this->pdf->setY(104.5);
		
		$html = '<table border="0" style="padding:7px">
		<tr>
		<td width="35%" colspan="3">
		</td>

		<td width="60%">'. strtoupper($this->model->application->fasi->department) .'</td>
		
		</tr>
		
		</table>
		';
		
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		$this->pdf->setY(112.8);
		
		$html = '<table border="0" style="padding:7px">
		<tr>
		<td width="35%" colspan="3">
		</td>

		<td width="30%">'. ucwords(strtolower($this->model->application->fasi->position_work)) .'</td><td width="15%"></td>
		
		<td width="18%">'. strtoupper($this->model->application->fasi->position_grade) .'</td>
		
		</tr>
		
		</table>
		';
		
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		$this->pdf->setY(121.3);
		
		$html = '<table border="0" style="padding:7px">
		<tr>
		<td width="35%" colspan="3">
		</td>

		<td width="60%">'. strtoupper($this->model->application->fasi->highestEdu->edu_name) .'</td>
		

		
		</tr>
		
		</table>
		';
		
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		$this->pdf->setY(129.8);
		
		$html = '<table border="0" cellpadding="8">
		<tr>
		<td width="35%" colspan="3">
		</td>

		<td width="60%">'. strtoupper($this->model->application->fasi->address_office) .'</td>
		

		
		</tr>
		
		</table>
		';
		
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		$this->pdf->setY(146.1);
		
		$html = '<table border="0" cellpadding="8">
		<tr>
		<td width="35%" colspan="3">
		</td>

		<td width="60%">'. strtoupper($this->model->application->fasi->address_home) .'</td>
		

		
		</tr>
		
		</table>
		';
		
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');

		$html = '<span style="width:400px"></span><img width="11" src="images/fon-icon.png" />';
		$tbl = <<<EOD
		$html
EOD;
		$this->pdf->setY(91.8);
		$this->pdf->setX(124);
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function bahagian_A_form(){
		$this->bhg_a_Y = $this->pdf->getY();
		
		
		$html = '
		
		<b><u>BAHAGIAN A</u></b>
		<br /><br />
		<table style="padding:7px">
		
		<tr>
		<td width="5%">
		1. </td>
		<td width="25%">Nama Pemohon</td>
		<td width="5%">:</td>
		<td width="55%" colspan="2">....................................................................................................</td>
		</tr>
		

		
		<tr>
		<td width="5%">2. </td>
		<td width="25%">No. Pekerja</td>
		<td width="5%">:</td>
		<td width="20%">.................................</td>
		<td width="35%">3. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pejabat / H/P:..............................</td>
		</tr>
		
		<tr>
		<td>4. </td>
		<td>No. Kad Pengenalan</td>
		<td>:</td>
		<td colspan="2">....................................................................................................</td>
		</tr>
		
		<tr>
		<td>5. </td>
		<td>Jabatan/Fakulti</td>
		<td>:</td>
		<td colspan="2">....................................................................................................</td>
		</tr>
		
		<tr>
		<td>6. </td>
		<td>Jawatan</td>
		<td>:</td>
		<td width="30%">....................................................</td>
		<td width="25%">7. Gred Jawatan: ..............</td>
		</tr>
		
		<tr>
		<td>8. </td>
		<td>Kelayakan Tertinggi</td>
		<td>:</td>
		<td colspan="2">....................................................................................................</td>
		</tr>
		
		<tr>
		<td>9. </td>
		<td>Alamat Pejabat</td>
		<td>:</td>
		<td colspan="2">....................................................................................................</td>
		</tr>
		
		<tr>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2">....................................................................................................</td>
		</tr>
		
		<tr>
		<td>10. </td>
		<td>Alamat Rumah</td>
		<td>:</td>
		<td colspan="2">...................................................................................................</td>
		</tr>
		
		<tr>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2">....................................................................................................</td>
		</tr>
		
		
		</table>

		';
		$this->pdf->SetFont('times', '', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function bahagian_B(){
		$this->pdf->setY(170);
		$html = '<b><u>BAHAGIAN B</u></b> (Diisi oleh pemohon)
		<br /><br />
		
		<table border="0" cellpadding="3">
		<tr align="center">
			<td rowspan="2" width="10%" border="1">Tarikh</td>
			<td rowspan="2" width="20%" border="1">Mata Pelajaran</td>
			<td rowspan="2" width="11%" border="1">Kelas</td>
			<td colspan="2" width="23%" border="1">Tempoh Jam</td>
			<td colspan="3" width="30%" border="1">Jumlah Jam</td>
		</tr>
		
		<tr align="center">

			<td border="1">Dari</td>
			<td border="1">Hingga</td>
			<td border="1">Kuliah</td>
			<td border="1">Tutorial</td>
			<td border="1">Amali</td>
		</tr>';

		$group = $this->model->application->groupName;
		$total_lec = 0;
		$total_tut = 0;
		$total_prac = 0;
		$total_hour = 0;
		if($this->model->claimItems){
			foreach($this->model->claimItems as $item){
				
				$duration = $item->hour_end - $item->hour_start;
				$course = $this->model->application->acceptedCourse->course;
				$duration = $duration > 0 ? $duration : 0;
				$lecture = '';
				$tutorial = '';
				$practical = '';
				switch($item->session_type){
					case 1 :
					$lecture = $duration;
					$total_lec += $duration;
					break;
					case 2 :
					$tutorial = $duration;
					$total_tut += $duration;
					break;
					case 3 :
					$practical = $duration;
					$total_prac += $duration;
					break;
					
				}
				
				$total_hour += $duration;
				
				$html .='<tr align="center" nobr="true">

			<td style="border-left: 1px solid #000000">'.date('d/m/y', strtotime($item->item_date)) .'</td>
			<td style="border-left: 1px solid #000000">
			' . $course->course_code . '<br />' . ucwords(strtolower($course->course_name)) .'
			</td>
			<td style="border-left: 1px solid #000000">
			'.$group.'
			</td>
			<td style="border-left: 1px solid #000000">
			'.$item->hourStart->hour_format .'
			</td>
			<td style="border-left: 1px solid #000000">
			'.$item->hourEnd->hour_format .'
			</td>
			<td style="border-left: 1px solid #000000">
			'.$lecture.'
			</td>
			<td style="border-left: 1px solid #000000">
			'.$tutorial.'
			</td>
			<td style="border-left: 1px solid #000000; border-right: 1px solid #000000">
			'.$practical.'
			</td>
		</tr>';
			}
		}
		
		
		
		$html .='<tr>

			<td style="border-left: 1px solid #000000"></td>
			<td style="border-left: 1px solid #000000"></td>
			<td style="border-left: 1px solid #000000"></td>
			<td style="border-left: 1px solid #000000"></td>
			<td style="border-left: 1px solid #000000"></td>
			<td style="border-left: 1px solid #000000"></td>
			<td style="border-left: 1px solid #000000"></td>
			<td style="border-left: 1px solid #000000; border-right: 1px solid #000000"></td>
		</tr>
		
		<tr align="center">

			<td colspan="5" border="1"><b>Jumlah</b></td>';
			
			$this->total_lec = $total_lec;
			$this->total_tut = $total_tut;
			$this->total_prac = $total_prac;
			$this->total_hour = $total_hour;
			
			$total_lec = $total_lec > 0 ? $total_lec : '';
			$total_tut = $total_tut > 0 ? $total_tut : '';
			$total_prac = $total_prac > 0 ? $total_prac : '';
			$html .= '<td border="1">'.$total_lec.'</td>
			<td border="1">'.$total_tut.'</td>
			<td border="1">'.$total_prac.'</td>
		</tr>
		
		</table>
		<br /><br />
		*Sila sediakan lampiran jika ruang tidak mencukupi.
<br /><br /><br /><br /><br />
		';
		$this->pdf->SetFont('times', '', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function bahagian_C(){
		
		$this->pdf->setY($this->bhg_c_y);
		
		$html = '<b><u>BAHAGIAN C</u></b> (Pengesahan Ketua Jabatan)<br /><br />
		
		Adalah disahkan bahawa syarahan sambilan /kerja tambahan telah dilaksanakan seperti di atas.
		<br /><br />
		<table border="0" cellpadding="6">
		
		<tr>
		
			<td width="50%">Tarikh : ....................</td>
			<td width="14%">Tandatangan</td>
			<td width="40%"> : ...............................................</td>
		
		</tr>
		
		<tr>
		
			<td></td>
			<td>Nama/cop</td>
			<td> </td>
		
		</tr>
		
		</table>
		
		';
		$this->pdf->SetFont('times', '', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		$this->bhg_b_Y = $this->pdf->getY();
	}
	
	public function bahagian_D(){
		
		$html = '<b><u>BAHAGIAN D</u></b> (Kelulusan Pengurus Bahagian)<br /><br />
		
		Tuntutan di atas adalah diluluskan / tidak diluluskan.
		<br /><br />
		<table border="0" cellpadding="6">
		
		<tr>
		
			<td width="50%">Tarikh : ....................</td>
			<td width="14%">Tandatangan</td>
			<td width="40%"> : ...............................................</td>
		
		</tr>
		
		<tr>
		
			<td></td>
			<td>Nama/cop</td>
			<td> </td>
		
		</tr>
		
		</table>
		
		';
		$this->pdf->SetFont('times', '', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeTitle(){
		
		$html = '<div align="center"><b>UNIVERSITI MALAYSIA KELANTAN</b><br />
<b>BORANG TUNTUTAN SYARAHAN/DEMONSTATOR SAMBILAN (PENSYARAH LUAR)</b><br />
Tuntutan ini mestilah dikemukakan di Pejabat Bendahari dalam <b>1 salinan </b>sahaja <br />
dan tidak <b>melebihi (3) bulan</b> daripada tarikh akhir semester.
</div>
<br />
<table>
<tr>
<td rowspan="2" width="7%"></td>
<td width="44%"><b>TUNTUTAN BAGI BULAN / TAHUN</b></td>
<td width="10%">:</td>
<td>_____________________</td>
</tr>
<tr>
<td><b>SEMESTER/SESI</b></td>
<td>:</td>
<td>_____________________</td>
</tr>
</table>

		';
		$this->pdf->SetFont('times', '', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeMonthSem(){
		$y = $this->pdf->getY();
		$this->pdf->setY($y - 13.5);
		$html = '<table>
<tr>

<td width="29%"></td>
<td></td>
<td>'. strtoupper($this->model->monthName()) .' / '.$this->model->year .'</td>
</tr>

<tr>
<td></td>
<td></td>
<td>'. strtoupper($this->model->application->semester->shortFormat()) .'</td>
</tr>
</table>

		';
		$this->pdf->SetFont('times', '', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	
	
	public function writeSummary(){
		/* $this->pdf->setY($this->bhg_b_Y); */
		$y = $this->pdf->getY();
		$this->bhg_bstart_Y = $y;
		$this->pdf->setY($y - 13.5);
		$this->sum_begin_y = $this->pdf->getY();
		
		if($this->pdf->PageNo() == 1){
			$this->pdf->AddPage("P");
		}
		

		
		
		$html =  '<table border="0" cellpadding="5" nobr="true">
		<tr>
			<td colspan="6">
			Jumlah masa mengajar sebulan : .................( jam)
			<br />
			</td>
		</tr>
		
		<tr>
			<td>
			Kadar sejam
			</td>
			<td width="5%">:</td>
			<td>Kuliah</td>
			<td width="23%">RM............x............jam</td>
			<td width="5%">=</td>
			<td width="14%">Jumlah</td>
			<td>RM..............</td>
		</tr>
		
		<tr>
			<td>
			
			</td>
			<td width="5%">:</td>
			<td>Tutorial</td>
			<td width="23%">RM............x............jam</td>
			<td width="5%">=</td>
			<td width="14%">Jumlah</td>
			<td>RM..............</td>
		</tr>
		
		<tr>
			<td>
			
			</td>
			<td width="5%">:</td>
			<td>Amali</td>
			<td width="23%">RM............x............jam</td>
			<td width="5%">=</td>
			<td width="14%">Jumlah</td>
			<td>RM..............</td>
		</tr>
		
		<tr>
			<td colspan="5">
			
			</td>
			
			<td width="14%">Jumlah<br />Tuntutan</td>
			<td>RM..............</td>
		</tr>
		
		</table>
		<br /><br /><br />
		<table border="0" cellpadding="6">
		
		<tr>
		
			<td width="50%">Tarikh : ....................</td>
			<td width="14%">Tandatangan</td>
			<td width="40%"> : ...............................................</td>
		
		</tr>
		
		<tr>
		
			<td></td>
			<td>Nama</td>
			<td> : ...............................................</td>
		
		</tr>
		
		</table>
		

		';
		$this->pdf->SetFont('times', '', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		$this->bhg_c_y = $this->pdf->getY();
	}
	
	public function writeSummary_data(){
		
		/* if($this->bhg_bstart_Y  > 200){
			$this->pdf->setY(29);
		}else{
			$this->pdf->setY($this->bhg_bstart_Y - 14.5);
		}  */
		$this->pdf->setY($this->bhg_c_y - 78.5);
		
		
		$html =  '<table border="0" cellpadding="5" nobr="true">
		<tr>
			<td width="30%"></td>
			<td width="6%" colspan="5">'.$this->total_hour .'</td>
			
		</tr>
		</table>';
		
		$this->pdf->SetFont('times', '', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		$this->pdf->setY($this->pdf->getY() - 3);
		$rate = $this->model->application->rate_amount;
		$html = '
		<table border="0" cellpadding="5">
		<tr>
			<td width="43%"></td>
			<td width="7%">'.$rate.'</td>
			<td width="35%">'.$this->total_lec .'</td>';
			$t_lec = $rate * $this->total_lec;
			$html .='<td width="10%">'.$t_lec.'</td>
		</tr>
		<tr>
			<td></td>
			<td>'.$rate.'</td>
			<td>'.$this->total_tut .'</td>';
			$t_tut = $rate * $this->total_tut;
			$html .='<td>'.$t_tut.'</td>
		</tr>
		
		<tr>
			<td></td>
			<td>'.$rate.'</td>
			<td>'.$this->total_prac .'</td>';
			$t_prac = $rate * $this->total_prac;
			$html .='
			<td>'.$t_prac.'</td>
		</tr>
		
		<tr>
			<td colspan="3"></td>';
			$total_amount = $t_lec + $t_tut + $t_prac;
			$html .='<td>'.$total_amount.'</td>
		</tr>
		
		</table>
		
		
		<br /><br /><br /><br />
		<table border="0" cellpadding="6">
		
		<tr>
		
			<td width="8%"></td>
			<td width="58%">'.date('d/m/Y').'</td>
			<td width="35%"></td>
		
		</tr>
		
		<tr>
		
			<td></td>
			<td></td>
			<td>'. strtoupper($this->model->application->fasi->user->fullname) .'</td>
		
		</tr>
		
		</table>
		

		';
		$this->pdf->SetFont('times', '', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	
	public function writeTable(){
		$all = 580;
		$w1 = 50;
		$w2 = 30;
		$w3 = 140;
		$w4 = 40;
		$w5 = $all - $w1 - $w2 - $w3 - $w4;
		$course = $this->model->getAcceptedCourse()->course;
		$html = '
		<table cellpadding="5">
		<tr>
			<td width="'.$w1.'"></td>
			<td width="'.$w2.'">a)</td>
			<td width="'.$w3.'">Komponen</td>
			<td width="'.$w4.'">:</td>
			<td width="'.$w5.'">'.$course->component->name .'</td>
		</tr>';
		$html .='<tr>
			<td></td>
			<td>b)</td>
			<td>Kod dan Nama Kursus</td>
			<td>:</td>
			<td>'.$course->course_code .' '.$course->course_name .' ('. $this->model->applicationGroup->group_name .')</td>
		</tr>
		<tr>
			<td></td>
			<td>c)</td>
			<td>Fakulti/Pusat</td>
			<td>:</td>
			<td>Pusat Ko-Kurikulum</td>
		</tr>
		<tr>
			<td></td>
			<td>d)</td>
			<td>Tempoh Lantikan</td>
			<td>:</td>
			<td>Satu Semester<br/>(Semester '.$this->getSemester().')</td>
		</tr>
		<tr>
			<td></td>
			<td>e)</td>
			<td>Lokasi</td>
			<td>:</td>
			<td>'.$this->model->campus->campus_name .'</td>
		</tr>
		<tr>
			<td></td>
			<td>f)</td>
			<td>Tarikh Kuatkuasa</td>
			<td>:</td>
			<td>'.Common::date_malay_short($this->model->semester->date_start) .' - '.Common::date_malay_short($this->model->semester->date_end).'</td>
		</tr>
		<tr>
			<td></td>
			<td>g)</td>
			<td>Kadar Elaun</td>
			<td>:</td>
			<td>RM'.$this->model->rate_amount .' Sejam<br/>(Tuntutan tidak melebihi 12 Jam untuk satu bulan, maksimum tuntutan 28 jam untuk setiap semester. Tuntutan mestilah dibuat secara bulanan melalui borang yang peroleh di Pusat Ko-Kurikulum berserta salinan surat lantikan dan borang kehadiran pelajar)</td>
		</tr>
		</table>
		';
		$this->pdf->SetFont('helvetica', 'B', 9.5);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeEnding(){

		$html = '<br />
		<table width="600"><tr><td><span style="text-align:justify;">3. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Bersama-sama ini juga disertakan senarai tugas fasilitator sambilan Kursus Ko-Kurikulum Berkredit Pusat Ko-Kurikulum. (Rujuk Lampiran 1)
		<br /><br />
		4. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Sekiranya bersetuju dengan tawaran ini sila penuhi borang penerimaan sebagai fasilitator sambilan dan kembalikan borang berkenaan sama datang sendiri atau fakskan melalui talian 09-771262 ke Pusat Ko-Kurikulum dengan kadar segera.
		<br /><br /></span>
		Segala kerjasama dan komitmen tuan adalah amatlah dihargai.
		<br /><br />
		Sekian, terima kasih.
		<br /><br />
		</td></tr></table>';

		$this->pdf->SetFont('helvetica', '', 9.5);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeSlogan(){
		$html = '<b><i>"ISLAM DIJULANG, RAJA DIJUNJUNG, RAKYAT DISANJUNG"</i></b>
		<br /><br />
		<b>"BERKHIDMAT UNTUK NEGARA"</b>
		<br /><br /><br />
		';
		$this->pdf->SetFont('helvetica', '', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeSignitureImg(){
		$html = '<img src="images/signiture.jpg" />';
		$this->pdf->SetFont('helvetica', '', 9.5);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeSigniture(){
		$html = 'Saya yang menurut perintah,
		<br /><br /><br />
		
		';
		$this->pdf->SetFont('helvetica', '', 9.5);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		$html = '<b>DR. MOHD NAZRI BIN MUHAYIDDIN</b>
		
		';
		$this->pdf->SetFont('helvetica', '', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		$html = 'Pengarah
		<br />Pusat Ko-Kurikulum
		<br /><br />
		
		
		';
		$this->pdf->SetFont('helvetica', '', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	
	
	public function writeSk(){
		$html = '
		<table cellpadding="5">
		<tr>
			<td width="60">s.k</td><td width="500">Fail Peribadi</td>
		</tr>
		
		</table>
		';
		$this->pdf->SetFont('helvetica', '', 9.5);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeTask(){
		
		$html = '<br /><table cellpadding="1">
		<tr>
			<td>PUSAT KO-KURIKULUM</td>
		</tr>
		<tr>
			<td style="border-bottom: #000000 solid 3px">UNIVERSITI MALAYSIA KELANTAN</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td>SENARAI TUGAS FASILITATOR SAMBILAN</td>
		</tr>
		<tr>
			<td>KURSUS KO-KURIKULUM BERKREDIT</td>
		</tr>
		</table>

		<br /><br />
		
		
		';
		$this->pdf->SetFont('helvetica', 'B', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		$html = '<table cellpadding="2">';
		$tasks = FasiTask::find()->all();
		
		$i = 1;
		foreach($tasks as $task){
			$html .='<tr>
			<td width="40">'.$i.'. </td>
			<td width="540"><span style="text-align:justify;">'.$task->task_text .'</span><br /></td>
		</tr>';
		$i++;
		}
		
		
		$html .= '</table>';
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
		$this->pdf->SetTitle('BORANG TUNTUTAN');
		$this->pdf->SetSubject('BORANG TUNTUTAN');
		$this->pdf->SetKeywords('');



		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$this->pdf->SetMargins(25, 10, PDF_MARGIN_RIGHT);
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



		// add a page
		$this->pdf->AddPage("P");
	}
	
	
}
