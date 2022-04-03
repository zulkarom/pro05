<?php

namespace backend\models;

use Yii;
use common\models\Common;
use frontend\models\LoginAsset;


class AcceptLetter
{
	public $model;
	public $pdf;
	public $directoryAsset;
	
	public function generatePdf(){
		
		//LoginAsset::register($this);

		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new Tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$this->startPage();
		
		$this->writeRef();
		$this->writeTitle();
		$this->writeTable();
		$this->writeSigniture();
		
		

		$this->pdf->Output('slip-penerimaan.pdf', 'I');
	}

	public function writeRef(){
		$html = '<br /><br /><br />
		<table cellpadding="5" align="center">
		<tr>
			<td align="center" style="font-weight:bold;font-size:13px;border-bottom: 1px solid #000000">SLIP PENERIMAAN TAWARAN
			<br /><br /></td>
		</tr>
		</table>
		<br /><br />
		<table>
		<tr>
			<td width="300">Pengarah<br />
			Pusat Ko-Kurikulum<br />
			Universiti Malaysia Kelantan<br />
			Karung Berkunci 36<br />
			16100 Pengkalan Chepa<br />
			Kelantan<br />
			
			</td>
		</tr>
		</table>
		
		<br /><br /><br />
		';
		
		$this->pdf->SetMargins(25, 10, 20);
		$this->pdf->SetFont('helvetica', '', 10);
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
	
	public function writeTitle(){
		
		$html = '
		Tuan,<br /><br />
		
		<b>PENERIMAAN TAWARAN SEBAGAI FASILITATOR SAMBILAN KURSUS KO-KURIKULUM BERKREDIT BAGI '. strtoupper($this->getSemester()) .'</b>
		<br /><br />
		
		Dengan hormatnya, perkara di atas adalah dirujuk.
		<br /><br />
		
		2. &nbsp;&nbsp;&nbsp;Saya <b>bersetuju</b> menjadi fasilitator sambilan kursus ko-kurikulum berkredit berdasarkan syarat-syarat yang telah ditetapkan.
		<br /><br />
		';
		$this->pdf->SetFont('helvetica', '', 10);
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
		$w4 = 20;
		$w5 = $all - $w1 - $w2 - $w3 - $w4;
		$course = $this->model->getAcceptedCourse()->course;
		$html = '
		<table cellpadding="5">
		<tr>
			<td width="'.$w1.'"></td>

			<td width="'.$w3.'">Nama Komponen</td>
			<td width="'.$w4.'">:</td>
			<td width="'.$w5.'"><b>'.$course->component->name .'</b></td>
		</tr>';
		$html .='<tr>
			<td></td>

			<td>Kod dan Nama Kursus</td>
			<td>:</td>
			<td><b>'.$course->course_code .' '.$course->course_name .' ('. $this->model->applicationGroup->group_name .')</b></td>
		</tr>
		
		</table>
		';
		$this->pdf->SetFont('helvetica', '', 10);
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
	

	
	public function writeSigniture(){
		$name = $this->model->fasi->user->fullname;
		$html = 'Sekian, terima kasih.
		<br /><br />
		Yang benar,
		
		<br /><br /><br />
		......................................................................<br/>
		<table>
			<tr><td width="130">Nama</td><td width="20">:</td>
			<td width="800"><b>'. strtoupper($name) . '</b></td></tr>
			
			<tr><td>No. Kad Pengenalan</td><td>:</td><td><b>'.$this->model->fasi->nric . '</b></td></tr>
			
			<tr><td>No. Telefon</td><td>:</td><td><b>'.$this->model->fasi->handphone . '</b></td></tr>
			
			<tr><td>Emel</td><td>:</td><td><b>'.$this->model->fasi->user->email . '</b></td></tr>
			
			<tr><td>Tarikh</td><td>:</td><td><b>'. Common::date_malay($this->model->accept_at) .'</b></td></tr>
		</table>
		
		';
		$this->pdf->SetFont('helvetica', '', 10);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		
	}
	
	

	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('Pusat Kokurikulum');
		$this->pdf->SetTitle('SLIP PENERIMAAN TAWARAN');
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



		// add a page
		$this->pdf->AddPage("P");
	}
	
	
}
