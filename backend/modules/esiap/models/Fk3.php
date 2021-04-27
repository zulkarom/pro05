<?php

namespace backend\modules\esiap\models;

use Yii;
use common\models\Common;
use backend\models\Faculty;


class Fk3
{
	public $model;
	public $pdf;
	public $directoryAsset;
	
	public $total_lec = 0;
	public $total_tut = 0;
	public $total_prac = 0;
	public $total_hour = 0;
	public $offer = false;
	public $cqi = false;
	
	public $wtab;
	
	public function generatePdf(){

		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new Fk3Start(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$this->pdf->SetFont("arialnarrow", '', 11);
		
		$this->startPage();
		$this->writeHeaderFooter();
		
		$this->doBody();
		
		$this->improvement();
		
		$this->signiture();
		$this->signiturePrepare();
		$this->signiture2();
		
		$this->signitureVerify();

		$this->pdf->Output('FK03 - '.$this->model->course->course_code .'.pdf', 'I');
	}

	
	
	public function writeHeaderFooter(){
		$wtab = 950;
		$this->wtab = $wtab;

		$tabin2 = '<table cellpadding="4" border="0">
		<tr>
		<td width="150">
		<img src="images/logo3.jpg" />
		</td>
		<td align="center" width="640">
		<br /><br />
		<b style="font-size:12pt;">
		PENJAJARAN KONSTRUKTIF KURSUS DAN PROGRAM PENGAJIAN
		<br /><i>CONSTRUCTIVE ALIGNMENT OF STUDY COURSE AND PROGRAMME</i></b></td>
		<td width="150"><div align="right" style="font-size:11pt;">UMK/AKAD/P&P/FK03 </div></td>
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
$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function doBody(){
		$wtab = $this->wtab;
		
		$this->pdf->SetFont('helvetica', '', 9);
		$row1col1 = 180;

		$row1col2 = $wtab - $row1col1; 
		$row2col1 = 510;
		$row2col2 = $wtab - $row2col1;
		$row3col1 = 330;
		$row3col2 = $wtab - $row3col1;
		$row4col1 = $row3col1;
		$row4col2 = 450;
		$row4col3 = $wtab - $row4col1 - $row4col2;
		$row5col1 = $row3col1;
		$row5col2 = 300;
		$row5col3 = $wtab - $row5col1 - $row5col2;
		
		$this->pdf->setY($this->pdf->getY() - 3);
		
		$pre = $this->model->profile->coursePrerequisite;
		
		$slt = $this->model->course->credit_hour * 40;
		 
		 $html ='<table  border="1" cellpadding="5" cellspacing="0" style="font-size:10pt;background-color:#f2f2f2">
	
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
		if($this->model->course->program){
			$pro = $this->model->course->program->pro_name;
			$pro_bi = $this->model->course->program->pro_name_bi;
		}
		$html .= $pro;
		
		$html .= '<br />
		<i><b>Programme:</b> '.$pro_bi .'</i>
		</td>
		
		</tr>
		

		</table>';
		
		


$tbl = <<<EOD
$html
EOD;
$this->pdf->writeHTML($tbl, true, false, false, false, '');

$this->pdf->setY($this->pdf->getY() - 3);


$assess = $this->model->assessments;
$as_span = count($assess) + 1;
$td_head  = '';
$td_assess = '';
foreach($assess as $as){
	$params = $this->pdf->serializeTCPDFtagParameters(array($as->assess_name));
	$td_head .= '<td>
	<tcpdf method="rotateAssess" params="'.$params.'" />
	</td>';
	$td_assess .= '<td></td>';
	
}


//total
$params = $this->pdf->serializeTCPDFtagParameters(array('Total / Weight'));
$td_head .= '<td>
	<tcpdf method="rotateAssess" params="'.$params.'" />
	</td>';
$td_assess .= '<td></td>';

$total = $wtab;

$col2 = 140;

$col3 = 50;
$kira_as = count($assess);
$w_as = 50;
if($kira_as >= 4){
$w_as = 40;
}
$col4 = $w_as * $kira_as;
$col5 = 110;
$col6 = 100;
$col7 =100;

$col1 = $total - $col7 - $col2 - $col3 - $col4 - $col5 - $col6;




$html = '
<table border="1" cellpadding="3">
<tr style="font-weight:bold;font-size:9pt">
<td colspan="2" align="center" width="'.$col1.'" >
HASIL PEMBELAJARAN KURSUS (CLO)<br/>
<i>COURSE LEARNING OUTCOMES (CLOs)</i>
</td>
<td width="'.$col2.'" align="center" colspan="3">

TAHAP TAKSONOMI/
<i>TAXONOMY LEVEL</i> DAN/ <i>AND</i>
HPP/ <i>PLO</i>

</td>

<td width="'.$col3.'" align="center">
KI <i>(SS)*</i>
</td>';




$html .= '<td width="'.$col4.'" align="center" colspan="'.$as_span.'">
KAEDAH PENTAKSIRAN/ ASSESSMENT METHODS
</td>';

$html .= '<td width="'.$col5.'" align="center">
TEKNIK PENYAMPAIAN/ <i>DELIVERY TECHNIQUE</i>
</td>
<td width="'.$col6.'" align="center">
PENCAPAIAN
PELAJAR
<i>STUDENT ACHIEVEMENT
(0-4)**</i>

</td>
<td width="'.$col7.'" align="center">
ANALISIS PENCAPAIAN / <i>ACHIEVEMENT ANALYSIS</i>
</td>
</tr>';

$col1d1 = 30;
$col1d2 = $col1 - $col1d1;




$html.= '<tr style="font-size:10pt">
<td width="'.$col1d1.'"></td>
<td width="'.$col1d2.'"></td>
';
$html .='<td align="center">C</td><td align="center">P</td><td align="center">A</td>
<td align="center">
</td>
';

$html .= $td_head;

$html .= '<td>';



$html .= '</td>
<td></td>
<td></td>
</tr>';

$x=1;
$gtotal = 0;
$plo_num = $this->model->ploNumber;
$clo_assess = $this->model->assessments;
if($this->offer){
	$clo_achieve = $this->offer->cloSummary;
}
foreach($this->model->clos as $clo){
	$idx = $x - 1;
	$html .='
<tr nobr="true" style="font-size:10pt">
<td width="'.$col1d1.'">'.$x.'. </td>
<td width="'.$col1d2.'">'.$clo->clo_text .'<br/><i>'.$clo->clo_text_bi .'</i>
</td>';
$html .='<td align="center">';

$i=1;
for($c=1;$c<=6;$c++){

	$prop = 'C'.$c;
	if($clo->$prop == 1){
		
		$comma = $i == 1 ? '' : ', ';
		$html .= $comma.$prop;
		$i++;
			$html .='<br />(';
			$x=1;
			$html .= $clo->plo;
			$html .=')';
	}
}


$html .='</td>';

$html .='<td align="center">';

$i=1;
for($c=1;$c<=7;$c++){
	$prop = 'P'.$c;
	if($clo->$prop == 1){
		$comma = $i == 1 ? '' : ', ';
		$html .= $comma.$prop;
		$i++;
			$html .='<br />(';
			$html .= $clo->plo;
			$html .=')';

	}
}

$html .='</td>';

$html .='<td align="center" style="font-size:10pt">';

$i=1;
for($c=1;$c<=5;$c++){
	$prop = 'A'.$c;
	if($clo->$prop == 1){
		$comma = $i == 1 ? '' : ', ';
		$html .= $comma.$prop;
		$i++;
		$html .='<br />(';
		$html .= $clo->plo;
		$html .=')';
	}
}

$html .='</td>';

$html .='<td align="center">';

$html.= $clo->softskillStr;
$html .='</td>';


$sub = 0;

$td_total = '';
if($clo_assess){
	$ix = 0;
	$arr = [];
	foreach($clo_assess as $ca){
		$val = $clo->assessPercent($ca->id);
		$val = $val == 0 ? '' : $val;
		$html .= '<td align="center">'. $val .'</td>';
		$per = $clo->assessPercent($ca->id) + 0;
		$sub += $per;
	$ix++;
	}
}
$gtotal += $sub;

$html .= '<td align="center">'.$sub.'</td>';
$html .= '<td>';

$delivers = $clo->cloDeliveries;
if($delivers){
	foreach($delivers as $d){
		$html .= $d->delivery->delivery_name .'/ <i>'. $d->delivery->delivery_name_bi . '</i><br />';
	}
	
}

$html .='</td>';




$html .='<td align="center">';
$s=1;

if($this->offer){
	if(array_key_exists($idx, $clo_achieve)){
		$html .= $clo_achieve[$idx];
	}
	
}

$html .='</td>';


$html .='
<td align="center">';
$s=1;
if($this->offer){
	if(array_key_exists($idx, $clo_achieve)){
		$html .= $this->analysis($clo_achieve[$idx]);
	}
	
}

$html .='</td>
</tr>';
$x++;
}

//row total

$html.= '<tr>
<td width="'.$col1d1.'"></td>
<td width="'.$col1d2.'">Jumlah / <i>Total</i></td>
';
$html .='<td></td>
<td></td>
<td></td>
<td>
</td>
';
if($clo_assess){
foreach($clo_assess as $ca){
	$html .= '<td align="center">'.$ca->assessmentPercentage .'</td>';
}
}

$html .= '<td align="center">'.$gtotal.'</td><td></td>
<td></td>
<td></td>
</tr>';


$html .='
</table>
<br /><br />
<table style="font-size:9.5pt">
<tr>
<td width="4%">Nota:</td><td width="96%">HPP- Hasil Pembelajaran Program/ PLO- Program Learning Outcome; KI- Kemahiran Insaniah/ SS – Soft skills.</td>
</tr>
<tr>
<td></td><td>* Ruberik bagi KI boleh disepadu dengan ruberik pembelajaran taksonomi berkaitan/ <i>Rubrics for soft skills can be integrated in relevant learning taxonomy (A) rubrics</i>.</td>
</tr>
<tr>
<td></td><td>** Purata markah (jumlah markah/ bil. pelajar) dibahagikan dengan pemberat setiap HPK didarab dengan 4.0/ <i>Average mark (total marks/no. of students) divided by weightage of each CLO multiplied by 4.0.</i></td>
</tr>

<tr>
<td></td><td>+ 0.00-0.99 (Sangat Lemah/ <i>Very Poor</i>), 1.00-1.99 (Lemah/ <i>Poor</i>), 2.00-2.99 (Baik/ <i>Good</i>), 3.00-3.69 (Sangat Baik/ <i>Very Good</i>), 3.70-4.00 (Cemerlang/ <i>Excellent</i>). Laporan pencapaian pelajar ini dibuat pada penghujung
               semester kursus ditawarkan/ <i>This achievement report of students is done at the end of the semester of the course offered. </i> </td>
</tr>



</table>
';
$echohtml = $html;
$tbl = <<<EOD
$html
EOD;
$this->pdf->writeHTML($tbl, true, false, false, false, '');





		
	}

	public function improvement(){
		
	$html = '<strong style="font-size:10pt"><u>Rancangan Penambahbaikan Kursus (jika ada)</u><sup>#</sup>:<br/>
<i><u>Plan for Course Improvement (if any)</u><sup>#</sup>:</i>
</strong><br /><br />
<table border="1" cellpadding="30" ><tr><td height="250">';

if($this->offer and $this->cqi){
	$html .= $this->offer->course_cqi;
	
}

$html .= '</td></tr></table>';
	
	
		$tbl = <<<EOD
$html 
<br />
EOD;
$this->pdf->writeHTML($tbl, true, false, false, false, '');


$tbl = <<<EOD
<span style="font-size:9pt"># Berasaskan kepada laporan pencapaian pelajar di atas dan sumber lain (jika mana-mana CLO/ PLO tidak tercapai).
  <br /> <i>  Based on the students’ achievement report above and other sources (if any CLO/ PLO is not achieved).</i></span>

EOD;

$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		
		
	}
	
	public $prepare_y;
	
	public $verify_y;
	
	public function signiture(){
		$tbl = <<<EOD
<p></p>
<table border="0" cellpadding="10" style="font-size:10pt">

<tr><td width="240">

Nama Penyelaras/  Pensyarah Kursus<br />
<i>Course Coordinator/  Lecturer’s Name:</i>	
</td><td width="700">
<br /><br />

</td></tr>


<tr><td>Tandatangan/<i>Signature:</i></td><td>

</td></tr>


<tr><td>Tarikh/<i>Date:</i></td><td>

</td></tr>
</table>
<br />

EOD;

$this->pdf->writeHTML($tbl, true, false, false, false, '');
$this->prepare_y = $this->pdf->getY();
	}
	public function signiture2(){
		$tbl = <<<EOD
<table cellpadding="10" style="font-size:10pt" nobr="true" border="0">
<tr><td width="240">Disahkan oleh/Verified by:</td><td width="700">


</td></tr>  			
<tr><td>Tarikh/<i>Date</i>:</td><td>

</td></tr>	
</table>
<br /><br /><br /><br /><br /><br /><br />
* Sebarang perubahan kepada maklumat atau kandungan kursus perlu mendapat kelulusan Fakulti/ Pusat atau Senat mengikut kesesuaian.<br />
   <i> Any change to the course information or content must be approved by the Faculty/ Centre or the Senate wherever applicable.</i>
	
EOD;

$this->pdf->writeHTML($tbl, true, false, false, false, '');
$this->verify_y = $this->pdf->getY();
	}
	
	
	public function signiturePrepare(){
		if(Yii::$app->params['faculty_id'] != 1){
			return false;
		}
		$sign = $this->model->preparedsign_file;

		$file = Yii::getAlias('@upload/'. $sign);

		$y = $this->prepare_y;
		
		
		$adjy = $this->model->prepared_adj_y;
		
		$posY = $y  - $adjy - 44;
		$this->pdf->setY($posY);
		
		
		$size = 100 + ($this->model->prepared_size * 3);
		if($size < 0){
			$size = 10;
		}
		
		$coor = '';
		$date = '';
		if($this->model->preparedBy){
			$coor = $this->model->preparedBy->staff->niceName;
		}
		if($this->model->prepared_at != '0000-00-00'){
			$date = date('d/m/Y', strtotime($this->model->prepared_at));
		}
		
		$col1 = 250;
		$col_sign = 410 ;
		$html = '<table>

		
		<tr>
		<td width="'. $col1 .'"></td>
		
		<td width="'.$col_sign .'">';
		if($this->model->preparedsign_file){
			if(is_file($file)){
				$html .= '<img width="'.$size.'" src="'.$file.'" />';
			}
		}
		
		$html .= '</td>

		
		</tr>
		
		<tr>
		<td width="'. $col1 .'"></td>
		
		<td width="'.$col_sign .'">';
		
		$html .= $coor.'
		<br /> Course Owner
		<br /> '.$this->model->course->course_code.'
		<br /> '.$this->model->course->course_name.'
		<br /> '.$date ; 
		
		$html .= '</td>
		
		
		
		</tr>
		
		</table>';
		
		
		$tbl = <<<EOD
		$html
EOD;

		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}
	
	public function signitureVerify(){
		if(Yii::$app->params['faculty_id'] != 1){
			return false;
		}
		$sign = $this->model->verifiedsign_file;

		$file = Yii::getAlias('@upload/'. $sign);

		$y = $this->verify_y;
		
		$verifier = '';
		$datev = '';

		if($this->model->verifiedBy){
			$verifier = $this->model->verifiedBy->staff->niceName;
		}
		if($this->model->verified_at != '0000-00-00'){
			$datev = date('d/m/Y', strtotime($this->model->verified_at));
		}
		$faculty = Faculty::findOne(Yii::$app->params['faculty_id']);

		
		
		$adjy = $this->model->verified_adj_y;
		
		$posY = $y  - $adjy - 50;
		$this->pdf->setY($posY);
		
		
		$size = 100 + ($this->model->verified_size * 3);
		if($size < 0){
			$size = 10;
		}
		

		
		$col1 = 250;
		$col_sign = 480 ;
		$html = '<table>

		
		<tr>
		<td width="'. $col1 .'"></td>
		
		<td width="'.$col_sign .'" >';
		if($this->model->verifiedsign_file){
			if(is_file($file)){
				$html .= '<img width="'.$size.'" src="'.$file.'" />';
			}
		}
		
		$html .= '</td>

		
		</tr>
		<tr>
		<td width="'. $col1 .'"></td>
		
		<td width="'.$col_sign .'" >';
		$html .= $verifier.'
		<br /> '.$this->model->verifier_position.'
		<br /> '.$faculty->faculty_name.'
		<br /> '.$datev ;
		
		$html .= '</td>

		
		</tr>
		
		</table>';
		
		
		$tbl = <<<EOD
		$html
EOD;

		$this->pdf->writeHTML($tbl, true, false, false, false, '');
	}


	
	public function analysis($point){
		if($point >= 3.7 and $point <= 4){
			return 'Cemerlang/ Excellent';
		}else if($point >= 3 and $point < 3.7){
			return 'Sangat Baik/ Very Good';
		}else if($point >= 2 and $point < 3){
			return 'Baik/ Good';
		}else if($point >= 1 and $point < 2){
			return 'Lemah/ Poor';
		}else if($point >= 0 and $point < 1){
			return 'Sangat Lemah/ Very Poor';
		}else{
			return '';
		}
	}
	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('Pusat Kokurikulum');
		$this->pdf->SetTitle('FK03 - '.$this->model->course->course_code);
		$this->pdf->SetSubject('FK03 - '.$this->model->course->course_code );
		$this->pdf->SetKeywords('');



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



		// add a page
		$this->pdf->AddPage("L");
	}
	
	
}
