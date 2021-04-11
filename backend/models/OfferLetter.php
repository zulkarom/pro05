<?php

namespace backend\models;

use Yii;
use common\models\Common;
use frontend\models\LoginAsset;
use yii\helpers\Url;



class OfferLetter
{
	public $model;
	public $pdf;
	public $tuan = 'tuan';
	public $directoryAsset;
	public $template;
	public $fontSize = 9.5;
	
	public function generatePdf(){
		
		$this->template = $this->model->semester->offerTemplate;
		

		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new Tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$this->writeHeaderFooter();
		$this->startPage();
		
		$this->writeRef();
		$this->writeTitle();
		$this->writeTable();
		
		$this->pdf->AddPage("P");
		$this->writeEnding();
		///$this->writeSlogan();
		$this->writeSigniture();
		$this->writeSignitureImg();
		$this->writeSk();
		
		$this->pdf->AddPage("P");
		$this->writeTask();

		$this->pdf->Output('surat-tawaran.pdf', 'I');
	}
	
	public function writeHeaderFooter(){
		$this->pdf->header_first_page_only = true;
		$this->pdf->header_html ='<img src="images/letterhead.jpg" />';
		
		$this->pdf->footer_first_page_only = true;
		$this->pdf->footer_html ='<img src="images/letterfoot.jpg" />';
	}
	public function writeRef(){
		$status = $this->model->getWfStatus();
		if($status == 'release' or $status == 'accept'){
			$release = $this->model->released_at;
			$date = strtoupper(Common::date_malay($release));
		}else{
			$date = 'TO BE DETERMINED';
		}
		
		
		$html = '<br /><br /><br />
		<table cellpadding="1">
		<tr>
			<td width="280"></td>
			<td width="120"></td>
			<td width="300" align="right">'.$this->model->ref_letter . '</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td align="right">'. $date .'</td>
		</tr>
		</table>
		<br /><br /><br /><br />
		'. strtoupper($this->model->fasi->user->fullname) .'<br />
		<table>
		<tr>
			<td width="220">'. nl2br(ucwords(strtolower($this->model->fasi->address_postal))) .'</td>
		</tr>
		</table>
		
		<br /><br /><br />
		';
		
		$this->pdf->SetMargins(20, 10, 20);
		
		$this->pdf->SetFont('arial', '', $this->fontSize);
		//echo $html;
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function getSemester(){
		$session = $this->model->semester->session() ;
		$years = $this->model->semester->years();
		return $session . ' Sesi ' . $years;
	}
	
	public function fasiType(){
		$fasi = array();
		$type = $this->model->fasi_type_id;
		if($type == 1){
			return 'fasilitator';
		}else{
			return 'pembantu fasilitator';
		}
	}
	
	public function writeTitle(){
		
		$gender = $this->model->fasi->gender;
		if($gender == 0){
			$this->tuan = 'puan';
		}
		
		
		$html = '
		'.ucfirst($this->tuan) .',<br /><br />
		
		<b>TAWARAN PERLANTIKAN SEBAGAI '.strtoupper($this->fasiType()).' SAMBILAN KURSUS KOKURIKULUM BERKREDIT BAGI SEMESTER '. strtoupper($this->getSemester()) .' DI UNIVERSITI MALAYSIA KELANTAN</b>
		<br /><br />
		
		Dengan hormatnya, saya diarah merujuk kepada perkara di atas.
		<br /><br />
		
		2. &nbsp;&nbsp;&nbsp;Sukacita dimaklumkan bahawa Universiti Malaysia Kelantan bersetuju melantik '.$this->tuan .' sebagai '.ucwords($this->fasiType()).' Sambilan seperti butir-butir berikut:
		<br /><br />
		';
		$this->pdf->SetFont('arial', '', $this->fontSize);
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
			<td>Pusat Kokurikulum</td>
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
		</tr>';
		
		$elaun_note = $this->template->nota_elaun;
		
		$html .= '<tr>
			<td></td>
			<td>g)</td>
			<td>Kadar Elaun</td>
			<td>:</td>
			<td>RM'.$this->model->rate_amount .' Sejam<br/>('.$elaun_note.')</td>
		</tr>
		</table>
		';
		$this->pdf->SetFont('arial', 'B', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeEnding(){
		$per3 = $this->template->per3;
		$per3 = str_replace('{FASILITATOR}', $this->fasiType(), $per3);
		
		$per4 = $this->template->per4;
		$per4 = str_replace('{FASILITATOR}', $this->fasiType(), $per4);
		
		
		//$this->fasiType()
		$html = '<br />
		<table width="700"><tr><td><span style="text-align:justify;">3. &nbsp;&nbsp;&nbsp;
		'.$per3.'
		<br /><br />
		4. &nbsp;&nbsp;&nbsp;
		'.$per4.'
		<br /><br /></span>
		Segala kerjasama dan komitmen '.$this->tuan.' adalah amatlah dihargai.
		<br /><br />
		Sekian, terima kasih.
		<br />
		</td></tr></table>';

		$this->pdf->SetFont('arial', '', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	

	
	public function writeSignitureImg(){
		
		$sign = $this->template->signiture_file;
		if(!$sign){
			die('no signiture - plz upload the signature properly');
		}

		$file = Yii::getAlias('@upload/'. $sign);
		
		$html = '
		<img src="'.$file.'" />
		';
		$tbl = <<<EOD
		$html
EOD;
		$y = $this->pdf->getY();
		$adjy = $this->template->adj_y;
		
		$posY = $y - 42 + $adjy;
		$this->pdf->setY($posY);
		
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeSigniture(){
		$tema = $this->template->tema;
		$tema = nl2br($tema);
		$benar = $this->template->yg_benar;
		$pengarah = $this->template->pengarah;
		
		$html = '<b>'.$tema.'</b>
<br /><br />
'.$benar.',<br />
<br /><br /><br />
<b>'.$pengarah.'</b><br />
Pengarah<br />
Pusat Kokurikulum<br />
		';
		$this->pdf->SetFont('arial', '', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		
	}
	
	
	
	public function writeSk(){
		$html = '
		<br /><br /><br /><br /><br />
		<table cellpadding="5">
		<tr>
			<td width="60">s.k</td><td width="500">Fail Peribadi</td>
		</tr>
		
		</table>
		';
		$this->pdf->SetFont('arial', '', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function writeTask(){
		
		$html = '<br /><table cellpadding="1">
		<tr>
			<td>PUSAT KOKURIKULUM</td>
		</tr>
		<tr>
			<td style="border-bottom: #000000 solid 3px">UNIVERSITI MALAYSIA KELANTAN</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td>SENARAI TUGAS '.strtoupper($this->fasiType()).' SAMBILAN</td>
		</tr>
		<tr>
			<td>KURSUS KOKURIKULUM BERKREDIT</td>
		</tr>
		</table>

		<br /><br />
		
		
		';
		$this->pdf->SetFont('arial', 'B', $this->fontSize);
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
		$this->pdf->SetFont('arial', '', $this->fontSize);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('Pusat Kokurikulum');
		$this->pdf->SetTitle('SURAT TAWARAN');
		$this->pdf->SetSubject('SURAT TAWARAN');
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
		$this->pdf->SetMargins(0, 0, 0);
		//$this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->pdf->SetHeaderMargin(0);

		 //$this->pdf->SetHeaderMargin(0, 0, 0);
		$this->pdf->SetFooterMargin(0);

		// set auto page breaks
		$this->pdf->SetAutoPageBreak(TRUE, -30); //margin bottom

		// set image scale factor
		$this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$this->pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		$this->pdf->setImageScale(1.53);

		// add a page
		$this->pdf->AddPage("P");
	}
	
	
}
