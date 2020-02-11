<?php

namespace backend\modules\esiap\models;

use Yii;
use common\models\Common;


class Fk1
{
	public $model;
	public $pdf;
	public $directoryAsset;
	
	public $total_lec = 0;
	public $total_tut = 0;
	public $total_prac = 0;
	public $total_hour = 0;
	
	public function generatePdf(){

		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new Fk1Start(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$this->pdf->SetFont("arialnarrow", '', 11);
		
		$this->startPage();
		
		$this->writeHeaderFooter();
		$this->doBody();

		$this->pdf->Output('FK01 - '.$this->model->course->course_code .'.pdf', 'I');
	}
	
	public function writeHeaderFooter(){
		
		//$this->pdf->setY = 13;
		$this->pdf->header_first_page_only = true;
		
		$wtab = 180 + 450;
		 
		 $tabin2 = '<table cellpadding="5" border="0">
		<tr>
		<td width="50">
		<img src="images/logo3.jpg" />
		</td>
		<td align="center" width="80"></td>
		<td align="center" width="370">
		<br /><br />
		<b style="font-size:12pt;">PRO FORMA KURSUS
		<br /><i>COURSE PRO FORMA</i></b></td>
		<td width="125"><div align="right" style="font-size:11pt;">UMK/AKAD/P&P/FK01</div></td>
		</tr>
		 </table>';
		 
		$tabin = '<table border="1" cellpadding="1">
		 <tr><td>'.$tabin2.'</td></tr>
		 </table>';
		 
		 $html ='<table border="1" width="'.$wtab.'" cellpadding="5">
		 <tr><td>'.$tabin.'</td></tr>
		 </table>
		 ';
		 
		$tbl = <<<EOD
$html
EOD;
		
		//$this->pdf->SetFont('helvetica', '', 10);
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		$y = $this->pdf->getY();
		$this->pdf->setY($y - 3);
	}
	
	public function doBody(){
		

	$wtab = 180 + 450;

		$row1col1 = 180;
		$row1col2 = $wtab - $row1col1; 
		$row2col1 = 510;
		$row2col2 = $wtab - $row2col1;
		$row3col1 = 200;
		$row3col2 = $wtab - $row3col1;
		$row4col1 = $row3col1;
		$row4col2 = 300;
		$row4col3 = $wtab - $row4col1 - $row4col2;
		$row5col1 = $row3col1;
		$row5col2 = 200;
		$row5col3 = $wtab - $row5col1 - $row5col2;
		 $slt = $this->model->course->credit_hour * 40;
		 $pre = $this->model->profile->coursePrerequisite;
		 $html ='
		 
		 <table  border="1" cellpadding="5" cellspacing="0" style="font-size:11pt;background-color:#f2f2f2">
	
		 <tr>
		<td width="'.$row3col1.'">
		<b>Kod Kursus</b>: '.$this->model->course->course_code .'<br />
		<i><b>Course Code</b> : '.$this->model->course->course_code .'</i>
		</td>
		<td colspan="3" width="'.$row3col2.'">
		<b>Nama Kursus:</b> '.$this->model->course->course_name .'<br />
		<i><b>Course Name:</b> '.$this->model->course->course_name_bi .'</i> 
		</td>
		</tr>
		
		<tr>
		<td  width="'.$row4col1.'">
		<b>Prasyarat:</b>  '.$pre[0].'<br />
		<i><b>Pre-requisite(s):</b> '.$pre[1].'</i>
		</td>
		<td colspan="2" width="'.$row4col2.'">
		<b>Jam Pembelajaran Pelajar (JPP)</b>: '.$slt.'<br />
		<i><b>Student Learning Time (SLT)</b>: '.$slt.'</i>
		</td>
		<td width="'.$row4col3.'">
		<b>Kredit</b>: '.$this->model->course->credit_hour .'<br />
		<i><b>Credit:</b> '.$this->model->course->credit_hour .'</i>
		</td>
		</tr>

		
		<tr>
		<td  width="'.$row5col1.'">
		<b>Fakulti/Pusat:</b> '.$this->model->course->faculty->faculty_name .'<br />
		<i><b>Faculty/Centre:</b> '.$this->model->course->faculty->faculty_name .'</i> 
		</td>
		
		<td width="'.$row5col2.'">
		<b>Jabatan:</b> ';
		$dep = ' - ';
		$dep_bi = ' - ';
		if($this->model->course->department){
			$dep = $this->model->course->department->dep_name;
			$dep_bi = $this->model->course->department->dep_name_bi;
		}
		$html .= $dep;
		$html .= '<br />
		<i><b>Department:</b> '.$dep_bi .'</i>
		</td>
		
		<td colspan="2" width="'.$row5col3.'">
		<b>Program:</b> ';
		$pro = ' - ';
		$pro_bi = ' - ';
		if($this->model->course->program->id > 0){
			$pro = $this->model->course->program->pro_name;
			$pro_bi = $this->model->course->program->pro_name_bi;
		}
		$html .= $pro;
		
		$html .= '<br />
		<i><b>Programme:</b> '.$pro_bi .'</i>
		</td>
		
		</tr>
		

		</table>';



$html .='<br /><br /><table border="1" cellpadding="10" style="font-size:11pt;">


<tr nobr="true"><td width="200">
Sinopsis Kursus<br /><i>Course Synopsis</i>:
<br />
</td><td width="430">'.$this->model->profile->synopsis .'<br /><br />
<i>'.$this->model->profile->synopsis_bi .'</i>
</td></tr>

<tr nobr="true"><td width="200">
Rational:<br /><i>Rationale</i>:
<br />
</td><td width="430">'.$this->model->profile->rational .'<br /><br />
<i>'.$this->model->profile->rational_bi .'</i>
</td></tr>

<tr nobr="true"><td width="200">
Objectif:<br /><i>Objective</i>:
<br />
</td><td width="430">'.$this->model->profile->objective .'<br /><br />
<i>'.$this->model->profile->objective_bi .'</i>
</td></tr>



';


$html .= '<tr nobr="true"><td>
Hasil Pembelajaran Kursus (HPK) <br /><i>Course Learning Outcomes (CLOs)</i>:
<br />



</td><td>

Pada akhir kursus ini, pelajar dapat:<br /><i>At the end of this course, students are able to:</i><br /><br />';

$html .= '<table>';
$i=1;
foreach($this->model->clos as $c){
$html .='<tr>';	
$html .='<td width="20">'.$i.'. </td>';	
$html .='<td width="390">'.$c->clo_text .'<br /><i>'.$c->clo_text_bi .' '.$c->taxoPloBracket.'</i> </td>';	
$html .='</tr>';
$i++;	
}
$html .='</table>'; 

$html .= '</td></tr>

<tr nobr="true"><td>
Kemahiran Boleh Pindah<br />
<i>Transferable Skills</i>
</td><td>
'.$this->model->profile->transfer_skill .'<br />
<i>'.$this->model->profile->transfer_skill_bi .'</i>
</td></tr>



<tr nobr="true">
<td>
Teknik Penyampaian (Kuliah, Tutorial, Bengkel, dll):<br />
<i>Techniques of Delivery (Lecture, Tutorial, Workshop, etc):</i>

</td><td>';
$bi='';
$bm='';
$i=1;
foreach($this->model->courseDeliveries as $rm){
	$comma = $i == 1 ? "" : ", " ;
	$bm .= $comma.$rm->delivery_name;
	$bi .= $comma.$rm->delivery_name_bi;
$i++;
}
$html .= $bm.'<br /><i>'.$bi.'</i>'; 
$html .='</td></tr>

<tr nobr="true"><td>
Kaedah Penilaian/<br />	
<i>Methods of Assessment </i>
</td><td>
';
$form = 0;
$sum = 0;

$as_col1 = 40;
$as_col2 = 200;
$as_span = $as_col1 + $as_col2 ;
$as_col3 = 60;
$as_table = '';

$html .= '<table>';

if($this->model->courseAssessmentFormative){
	$as_table = '';
	foreach($this->model->courseAssessmentFormative as $rf){
		$as_table .= '<tr>';
		$as_table .= '<td width="'.$as_col1.'"></td><td width="'.$as_col2.'">'. $rf->assess_name .'/<i>'.$rf->assess_name_bi.'</i></td><td>'.$rf->as_percentage .'%</td>';
		$form +=$rf->as_percentage;
		$as_table .= '</tr>';
	}
	
}
$as_sum_text = '';
if($this->model->courseAssessmentSummative){
	foreach($this->model->courseAssessmentSummative as $rs){
		$as_sum_text = $rs->assess_name .'/<i>'.$rs->assess_name_bi.'</i>';
		$sum +=$rs->as_percentage;
	} 
}

$html .='<tr><td width="'.$as_span.'" colspan="2">Penilaian berterusan/ Continuous assessment:<br /></td><td width="'.$as_col3.'"> '.$form.'%</td></tr>';
$html .= $as_table;
$html .= '<tr><td colspan="3"></td></tr>';
if($sum > 0){
	$html .= '<tr><td colspan="2"> Peperiksaan Akhir / Pentaksiran Akhir<br />
 <i>Final Exam / Final Assessment:</i></td><td>'.$sum.'%</td></tr>';
}


$html .= '</table>';
$html .='
</td></tr>


<tr nobr="true"><td>
Kaedah Maklumbalas Prestasi <br />
<i>Methods for Feedback on Performance </i>
</td><td>
'.$this->model->profile->feedback .'<br />
<i>'.$this->model->profile->feedback_bi .'</i>
</td></tr>


</table>';

$echohtml = $html;

$tbl = <<<EOD
$html
EOD;

$this->pdf->SetFont("arialnarrow", '', 11);
$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	

	
	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator('Pusat Kokurikulum');
		$this->pdf->SetAuthor('Pusat Kokurikulum');
		$this->pdf->SetTitle('FK01 - '.$this->model->course->course_code );
		$this->pdf->SetSubject('FK01 - '.$this->model->course->course_code );
		$this->pdf->SetKeywords('Pusat Kokurikulum');



		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
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


		//$this->pdf->setImageScale(1.53);
		// add a page
		$this->pdf->AddPage("P");
	}
	
	
}
