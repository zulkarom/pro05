<?php

namespace backend\modules\project\models;

use Yii;
use common\models\Common;
use common\models\ConvertNumberMalay;
use frontend\models\LoginAsset;


class ApproveLetterPrint
{
	public $model;
	public $pdf;
	public $directoryAsset;
	
	public function generatePdf(){
		
		//LoginAsset::register($this);

		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new ApproveLetterStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$this->writeHeaderFooter();
		$this->startPage();
		
		$this->writeRef();
		$this->writeTitle();
		$this->writeSigniture();
		
		

		$this->pdf->Output('Surat_Kelulusan_'.$this->model->course->course_code  .'_'.$this->model->course->course_name .'_'.$this->model->group->group_name . '.pdf', 'I');
	}
	
	public function writeHeaderFooter(){
		$this->pdf->header_first_page_only = true;
		$this->pdf->header_html ='<img src="images/letterhead.jpg" />';
		
		$this->pdf->footer_first_page_only = true;
		$this->pdf->footer_html ='<img src="images/letterfoot.jpg" />';
	}
	public function writeRef(){
			$release = $this->model->approved_at;
			$date = strtoupper(Common::date_malay($release));

		
		
		$html = '<br /><br /><br />
		<table cellpadding="1">
		<tr>
			<td width="280"></td>
			<td width="300" align="right">'.$this->model->letter_ref . '</td>
		</tr>
		<tr>
			<td></td>
			<td align="right">'. $date .'</td>
		</tr>
		</table>
		<br /><br /><br /><br />
		'. strtoupper($this->model->fasi->user->fullname) .'<br />
		<table>
		<tr>
			<td width="220">'. $this->model->course->course_code  .' '.$this->model->course->course_name .' ('.$this->model->group->group_name . ')<br />
			Kursus Kokurikulum Berkredit
			<br />Semester '. $this->model->semester->niceFormat() .'</td>
		</tr>
		</table>
		
		<br /><br /><br />
		';
		
		$this->pdf->SetMargins(20, 10, 20);
		$this->pdf->SetFont('helvetica', '', 9.5);
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
		$amt = $this->model->resourceCenterAmount->rs_amount;
		
		$jan = $this->model->fasi->gender;
		$saudara = $jan == 1 ? 'tuan' : 'puan' ;
		$html = ucfirst($saudara) . ',<br /><br />
		
		<b>KELULUSAN BAGI MENGADAKAN '.strtoupper($this->model->pro_name .' BAGI KURSUS KOKURIKULUM BERKREDIT '.$this->model->course->course_code  .' '.$this->model->course->course_name .' ('.$this->model->group->group_name . ') SEMESTER '. $this->model->semester->niceFormat()) .'</b>
		<br /><br />
		
		Dengan hormatnya, saya diarah merujuk kepada perkara di atas.
		<br />
		<div style="text-align:justify">
		2. &nbsp;&nbsp;&nbsp;Sukacita dimaklumkan bahawa Pusat Kokurikulum, Pejabat Timbalan Naib Cancelor (Hal Ehwal Pelajar & Alumni) bersetuju meluluskan program sepertimana yang dinyatakan diatas yang akan diadakan pada <b>'. $this->model->projectDate .'</b> bertempat di <b>'.$this->model->location.'</b> dengan kadar peruntukan <b>RM'. number_format($amt, 2) .' (Ringgit Malaysia: '. ucwords(ConvertNumberMalay::convertNumber($amt)).' Sahaja)</b>. Bayaran peruntukan akan disalurkan kepada wakil yang dilantik oleh pihak '.$saudara.' iaitu <b>'.$this->model->eft_name .' (No. K/P: '.$this->model->eftIcString .')</b>
		<br /><br />
		3. &nbsp;&nbsp;&nbsp;Sepanjang tempoh program berlangsung, mohon pihak '.$saudara.' dan fasilitator berkenaan untuk menjaga nama baik Universiti Malaysia Kelantan serta memastikan program tersebut berjalan dengan lancar dan mematuhi peraturan-peraturan universiti.
		
		<br /><br />
		4. &nbsp;&nbsp;&nbsp;Sehubungan dengan itu, pihak '.$saudara.' adalah dipohon untuk mengemukakan laporan aktiviti berserta gambar (dalam bentuk CD) serta laporan kewangan (beserta resit-resit asal pembelian) dalam tempoh satu (1) minggu dari tarikh program diadakan kepada Pusat Kokurikulum. Bersama-sama ini disertakan borang laporan aktiviti pelajar dan borang akuan penerimaan wang untuk tindakan pihak '.$saudara.'.
		
		<br /><br />
		5. &nbsp;&nbsp;&nbsp;Sekiranya terdapat sebarang pertanyaan, pihak '.$saudara.' boleh menghubungi Puan Siti Norhidayah bin Mat Hussin di talian (09-7717094/014-6691481). Sebarang perubahan/pindaan akan dimaklumkan dengan kadar segera.
		</div>

		<br /><br />
		Segala kerjasama dan komitmen daripada pihak '.$saudara.' amatlah dihargai.
<br /><br />
Sekian terima kasih.
<br /><br />';

$html .='<b>"RAJA BERDAULAT, RAKYAT SEPAKAT, NEGERI BERKAT"<br />
"BERKHIDMAT UNTUK NEGARA"</b>
<br /><br />
Saya yang menjalankan amanah,<br />
<br /><br /><br />
<b>DR. MOHD NAZRI BIN MUHAYIDDIN</b><br />
Pengarah<br />
Pusat Kokurikulum<br />

		';
		

		
		
		$this->pdf->SetFont('helvetica', '', 9.5);
		$tbl = <<<EOD
		$html
EOD;
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	
	
	public function writeSigniture(){
		$html = '
		<img src="images/sig-trans.png" />
		';
		$this->pdf->SetFont('helvetica', '', 10);
		$tbl = <<<EOD
		$html
EOD;

		$this->pdf->setY(210);
		
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	
	
	
	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('Pusat Kokurikulum');
		$this->pdf->SetTitle('SURAT KELULUSAN');
		$this->pdf->SetSubject('SURAT KELULUSAN');
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
