<?php

namespace backend\modules\esiap\models;

use Yii;
use common\models\Common;


class Fk2
{
	public $model;
	public $pdf;
	public $directoryAsset;
	
	public $total_lec = 0;
	public $total_tut = 0;
	public $total_prac = 0;
	public $total_hour = 0;
	
	public $wtab;
	
	public function generatePdf(){
		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new Fk2Start(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$this->pdf->SetFont("arialnarrow", '', 11);
		$this->writeHeaderFooter();
		
		$this->startPage();
		
		
		$this->doBody();

		$this->pdf->Output('FK02 - '.$this->model->course->course_code .'.pdf', 'I');
	}
	
		public function myrotate($text) {
        /* if( !isset($this->xywalter) ) {
            $this->xywalter = array();
        }
        $this->xywalter[] = array($this->GetX(), $this->GetY()); */
		$this->pdf->SetFont('arialnarrow', 'B', 8);
		$this->pdf->StartTransform();
		$this->pdf->Rotate(90);
		$currX = $this->pdf->getX();
		$currY = $this->pdf->getY();
		$this->pdf->setXY($currX -13,$currY + 1);
		$this->pdf->Cell($w=0,
				$h = 0,
				$txt = $text,
				$border = 0,
				$ln = 1,
				$align ='L',
				$fill = false,
				$link = '',
				$stretch = 0,
				$ignore_min_height = false,
				$calign = 'C',
				$valign = 'T' 
			);
		//$this->pdf->Cell(0, 0, $text ,0,1,'L',0,'');
		$this->pdf->StopTransform();
		$this->pdf->ln(6);
    }
	
	
	public function writeHeaderFooter(){
		$wtab = 180 + 450;
		$this->wtab = $wtab;

		$tabin2 = '<table cellpadding="5" border="0">
		<tr>
		<td width="50">
		<img src="images/logo3.jpg" />
		</td>
		<td align="center" width="80"></td>
		<td align="center" width="370">
		<br /><br />
		<b style="font-size:15px;">MAKLUMAT KURSUS
		<br /><i>COURSE INFORMATION</i></b></td>
		<td width="120"><div align="right">UMK/AKAD/P&P/FK02</div></td>
		</tr>
		 </table>';
		 
		$tabin = '<table border="1" cellpadding="1">
		 <tr><td>'.$tabin2.'</td></tr>
		 </table>';
		 
		 $html ='<table border="1" width="'.$wtab.'" cellpadding="5">
		 <tr><td>'.$tabin.'</td></tr>
		 </table>
		 <br /><br />
		 ';
		$this->pdf->header_html = $html;
		$this->pdf->lineFooterTable = false;
	}
	
	public function doBody(){
		
		$wtab = 180 + 450;
		$this->wtab = $wtab;

		$tabin2 = '<table cellpadding="5" border="0">
		<tr>
		<td width="50">
		<img src="images/logo3.jpg" />
		</td>
		<td align="center" width="80"></td>
		<td align="center" width="370">
		<br /><br />
		<b style="font-size:12pt;">MAKLUMAT KURSUS
		<br /><i>COURSE INFORMATION</i></b></td>
		<td width="125"><div align="right" style="font-size:11pt;">UMK/AKAD/P&P/FK02</div></td>
		</tr>
		 </table>';
		 
		$tabin = '<table border="1" cellpadding="1">
		 <tr><td>'.$tabin2.'</td></tr>
		 </table>';
		 
		 $html ='<table border="1" width="'.$wtab.'" cellpadding="5">
		 <tr><td>'.$tabin.'</td></tr>
		 </table>
		 <br /><br />
		 ';
		
		$wtab = $this->wtab;
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
		
		$this->pdf->SetFont('arialnarrow', '', 10);
		$tbl = <<<EOD
$html
EOD;
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		$pre = $this->model->profile->coursePrerequisite;
		 
		 $html ='
		 
		 <table  border="1" cellpadding="5" cellspacing="0" style="font-size:11pt;background-color:#f2f2f2">
	
		 <tr>
		<td width="'.$row3col1.'">
		<b>Kod Kursus</b>: '.$this->model->course->course_code .'<br />
		<i><b>Course Code</b> : '.$this->model->course->course_code .'</i>
		</td>
		<td colspan="3" width="'.$row3col2.'">
		<b>Nama Kursus:</b> '.$this->model->course->course_name  .'<br />
		<i><b>Course Name:</b> '. $this->model->course->course_name_bi .'</i> 
		</td>
		</tr>
		
		<tr>
		<td  width="'.$row4col1.'">
		<b>Prasyarat:</b>  '.$pre[0].'<br />
		<i><b>Pre-requisite(s):</b> '.$pre[1].'</i>
		</td>
		<td colspan="2" width="'.$row4col2.'">';
		
		$slt = $this->model->course->credit_hour * 40;
		
		$html .= '<b>Jam Pembelajaran Pelajar (JPP)</b>: '.$slt.'<br />
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


		</table><br /></br />';

$this->pdf->SetFont('arialnarrow', '', 11);



$html .='<br /><table border="1" width="'.$wtab.'" cellpadding="8">

<thead>

</thead>

<tr>
<td>';


$html .='
<span style="font-size:12pt;">SILIBUS DAN RANCANGAN PENGAJARAN:<br/>
<i>SYLLABUS AND TEACHING PLAN:</i></span>
<br />';

$tab_syl = $wtab - 18;
$hweek = 42;

$clo = 50;

$depend = 32;
$dep_all = $depend * 3;
$ind = 78;
$guided = 63;
$jum = 50;
$hslt = $dep_all + $guided + $ind ;
$htopic = $tab_syl - $hweek - $clo - $hslt - $jum;

$html .='<table border="1" cellpadding="5">
<thead>
</thead>
<tr>
<th width="'.$hweek.'" rowspan="3" align="center" style="font-size:11pt;">';

$params = $this->pdf->serializeTCPDFtagParameters(array("Week"));

$html .= '<tcpdf method="rotateWeek" params="'.$params.'" />';

$html .= '</th>
<th width="'.$htopic.'" rowspan="3" align="center" style="font-size:11pt;">Topik/<br /><i>Topics</i></th>

<th width="'.$clo.'" rowspan="3" align="center" style="font-size:11pt;">HPK<br /><i>CLO</i></th>

<th width="'.$hslt.'" colspan="7" align="center" style="font-size:8pt;">Jam Pembelajaran Pelajar<br /> <i>Student Learning Time</i></th>
<th rowspan="3" width="'.$jum.'" align="center" style="font-size:8pt;">Jumlah<br /><i>Total</i></th>
</tr>
<tr>
<th colspan="3" width="'.$dep_all.'" align="center" style="font-size:8pt;">

Bersemuka <br />
<i>F2F</i>

</th>

<th width="'.$ind.'" align="center" style="font-size:8pt;">
Berpandu<br />
<i>Guided<br />
NF2F</i>

</th>

<th rowspan="2" width="'.$guided.'" align="center" style="font-size:8pt;">Kendiri<br />
<i>Independent<br />
NF2F</i>
</th>

</tr>
<tr>';
$params = $this->pdf->serializeTCPDFtagParameters(array("Lecture"));
$pTut = $this->pdf->serializeTCPDFtagParameters(array("Tutorial"));
$pPrac = $this->pdf->serializeTCPDFtagParameters(array("Lab / Studio"));
$pOth = $this->pdf->serializeTCPDFtagParameters(array("Others"));
$html .= '<th align="center"><b>
<tcpdf method="myrotate" params="'.$params.'" />
</b></th>
<th align="center"><b>
<tcpdf method="myrotate" params="'.$pTut.'" />
</b></th>
<th align="center"><b>
<tcpdf method="rotateOthers" params="'.$pPrac.'" />
</b></th>
<th style="font-size:8pt;">
<i>E-learning, Project, HIEPs, Assignment, LI, SIEP etc.</i>
</th>

</tr>

';

/////////////////
function midbreak($week){
	$html_mid ='<tr nobr="true">';
	$html_mid .='<td align="center">'.$week.'. </td>';
	$html_mid .='<td>';
	
	$html_mid .= '<span style="font-size:10pt;">Cuti Pertengahan Semester<br />
		<i>Mid Semester Break</i></span>';
	$html_mid .='</td><td></td>';
	$html_mid .='<td></td>';
	$html_mid .='<td></td>';
	$html_mid .='<td></td>';
	$html_mid .='<td></td>';
	$html_mid .='<td></td>';
	$html_mid .='<td></td>';
	$html_mid .='</tr>';
	return $html_mid;
}


//////////////

$tlec = 0;
$ttut = 0;
$tprac =0;
$toth = 0;
$tind = 0;
$tass = 0;
$tgrand = 0;
$mid = 8;
$week_num = 1;
$arr_br = json_decode($this->model->syllabus_break);
foreach($this->model->syllabus as $row){
	$show_week = '';
	if($row->duration > 1){
		$end = $week_num + $row->duration - 1;
		$show_week = $week_num . '-' . $end;
	}else{
		$show_week = $week_num;
	}
	
	
	$html .='<tr nobr="true">';
	$html .='<td align="center">'.$show_week.'. </td>';
	$html .='<td>';
	$arr_all = json_decode($row->topics);
	if($arr_all){
	foreach($arr_all as $rt){
		if($rt->top_bm == trim('Cuti Pertengahan Semester') or $rt->top_bi == trim('Mid Semester Break')){
		$mid = true;
			$html .= '<span style="font-size:10pt;">' . $rt->top_bm ."<br /><i>". $rt->top_bi . "</i></span>";
		}else{
		$mid = false;
			$html .= '<span style="font-size:10pt;">' . $rt->top_bm ." / <i>". $rt->top_bi . "</i></span>";
		}
		
		
		if($rt->sub_topic){
		$html .= '<br/><table >';
			foreach($rt->sub_topic as $rst){
			$html .='<tr><td width="5%">- </td><td width="95%"><span style="font-size:9pt;">'.$rst->sub_bm . ' / <i>' . $rst->sub_bi . '</i></span></td></tr>';
			}
		$html .='</table>';
		}
	}
	}
	$clo_str = '';;
	$clos = json_decode($row->clo);
	if($clos and !$mid){
		$clok = 1;
		foreach($clos as $clo){
			$comma = $clok == 1 ? '' : '<br />';
			$clo_str .= $comma . 'CLO'.$clo;
		$clok++;
		}
	}
	$practical_others = $row->pnp_practical + $row->pnp_others;
	$style_number = 'style="vertical-align: middle;text-align:center;font-size:8pt"';
	$html .='</td><td span style="font-size:10pt;">'.$clo_str.'</td>';
	$html .='<td '.$style_number.'>'.$row->pnp_lecture .'</td>';
	$html .='<td '.$style_number.'>'.$row->pnp_tutorial .'</td>';
	$html .='<td '.$style_number.'>'.$practical_others.'</td>';
	//$html .='<td style="vertical-align: middle;text-align:center">'.$row->pnp_others .'</td>';
	
	
	
	$html .='<td '.$style_number.'>'.$row->nf2f .'</td>';
	
	$html .='<td '.$style_number.'>'.$row->independent .'</td>';
	
	$sub = $row->pnp_lecture + $row->pnp_tutorial + $practical_others + $row->independent + $row->nf2f;
	
	$html .='<td '.$style_number.' width="'.$jum.'">'.$sub.'</td>';
	$html .='</tr>';
	
	
	$tlec += $row->pnp_lecture;
	$ttut += $row->pnp_tutorial;
	$tprac += $practical_others;
	//$toth += $row->pnp_others;
	$tind += $row->independent;
	$tass += $row->nf2f;
	$tgrand +=$sub;
	
	//check sem breaks
	
	if(in_array($week_num, $arr_br)){
		
		$week_num = $week_num + 1;
		$html .= midbreak($week_num);
	}
	
	$week_num = $week_num + $row->duration;
		
}

$html .='<tr>';
	$week_study_num = $week_num ;
	$html .='<td align="center">'.$week_study_num .'. </td>';
	$html .='<td align="center">';
		$html .= '<span style="font-size:12p">Minggu Ulangkaji/ <br /><i>Study Week</i></span>';
	$html .='</td><td></td>';
	$html .='<td></td>';
	//$html .='<td></td>';
	$html .='<td></td>';
	$html .='<td></td>';
	$html .='<td></td>';
	$html .='<td></td>';
	$sub = $row->pnp_lecture + $row->pnp_tutorial + $row->pnp_practical + $row->independent + $row->pnp_others;
	$html .='<td></td>';
	$html .='</tr>';
	
	$week_fe_start = $week_num + 1;
	$week_fe_end = $week_num + 3;
	$html .='<tr>';
	$html .='<td align="center">'.$week_fe_start.'-'.$week_fe_end.' </td>';
	$html .='<td>';
		$html .= 'Peperiksaan Akhir/ Pentaksiran Akhir<br />
<i>Final Exam/  Final Assessment</i>
';
	$html .='</td><td></td>';
	$html .='<td colspan="5"></td>';
	$slt_sum = $this->model->sltAssessmentSummative;
	if($slt_sum){
		$ssum = $slt_sum->as_hour;
	}else{
		$ssum = 0;
	}
	$html .='<td align="center" '.$style_number.'>'.$ssum .'</td>';
	$html .='</tr>';
	
	$html .='<tr>';
	$html .='<td align="center"></td>';
	$html .='<td>';
		$html .= 'Pentaksiran Rasmi Lain<br />
<i>Other Formal  Assessments</i>
';
	
	$html .='</td><td></td>';

	$html .='<td colspan="5"></td>';

	
	$slt_form = $this->model->sltAssessmentFormative;
	if($slt_form){
		$sform = $slt_form->as_hour;
	}else{
		$sform= 0;
	}
	$html .='<td align="center" '.$style_number.'>'.$sform.'</td>';
	$html .='</tr>';
	
	$html .='<tr>';
	$html .='<td colspan="2" align="center">';
		$html .= 'Jumlah/ <i>Total</i>';
	$html .='</td><td></td>';
	$html .='<td align="center" '.$style_number.' colspan="5"></td>';

	
	$tgrand += $sform + $ssum;
	
	$html .='<td align="center" '.$style_number.'>'.$tgrand.'</td>';
	$html .='</tr>';
$html .='</table>

<br/>
';
$wnote_text = 60;
$wnote= 20;
$wnote2 = $tab_syl - $wnote - $wnote_text;

$html .='
<table border="0" cellpadding="0" nobr="true" style="font-size:11pt;">
<tr>
	<td width="'.$wnote_text .'">Nota/ Note:</td><td width="'.$wnote.'" align="right"> - </td>
	<td width="'.$wnote2.'">HPK/CLO = Hasil Pembelajaran Kursus/ Course Learning Outcome</td>
</tr>

<tr>
	<td></td><td align="right"> - </td>
	<td>F2F = <i>Face-to-Face</i>; NF2F = <i>Non Face-to-Face</i>; 40 SLT= 1 Kredit/<i>Credit</i></td>
</tr>

<tr>
	<td></td><td align="right"> - </td>
	<td>Kalendar akademik boleh berubah bergantung kepada keputusan pihak Universiti.</td>
</tr>
<tr>
	<td></td><td align="right"> - </td>
	<td><i>Academic calendar may change subject to the decision by the University.</i></td>
</tr>
</table><br /><br />
';

$html .='<table nobr="true"><tr><td>
<span style="font-size:12pt;">SENARAI BAHAN RUJUKAN/ <i>REFERENCE LIST:</i></span><br/><br/>';
if($this->model->references){
	$i = 1;
	$html .= '<table>';
	foreach($this->model->references as $row){
		$html .='<tr>';
		$html .='<td width="4%">'.$i.'. </td>';
		$html .='<td width="96%">'.$row->formatedReference.'</td>';
		$html .='</tr>';
	$i++;
	}
	$html .= '</table>';
}

$html .='<br/><br/>[Rujukan perlu dalam edisi 5 tahun terkini. Dalam kes tertentu, kerja-kerja klasik boleh digunakan. <i>References should be 5 years latest edition. In certain cases, classic works can be used.</i>]
</td></tr></table>
';

$html .='<br/><br/>
<table nobr="true"><tr><td>

<span style="font-size:12pt;">SKIM PENTAKSIRAN:<br /><i>ASSESSMENT SCHEME:</i></span>


<br/><br/>';
$wbil = 50;
$wper = 200;

$wname = $tab_syl - $wbil - $wper;

$form_num = 25;
$wname2 = $tab_syl - $wbil - $wper - $form_num;
$html .='<table border="0" style="font-size:12pt">
<tr>
<td width="'.$wbil.'" style="border:1px solid #000000"> No.</td>
<td width="'.$wname.'" style="border:1px solid #000000;" colspan="2" ><span style="margin:10px;"> Kaedah Pentaksiran/ <i>Assessment Method</i></span></td>
<td width="'.$wper.'" align="center" style="border:1px solid #000000">%</td>
</tr>';
$i=1;
$total = 0;
$total_form = 0;
$rspan = 1;
$html_as  = '';
$per = 0;
 if($this->model->courseAssessmentFormative){
	foreach($this->model->courseAssessmentFormative as $rf){
	//if($rf->percentage > 0){
		$per = $rf->as_percentage + 0;

		$html_as .= '<tr style="padding-top:0px">
		<td style="padding-top:0px" width="'.$form_num.'"> '.$i.' .</td>
		<td width="'.$wname2.'" style="border-right:1px solid #000000;padding-top:0px" > '.$rf->assess_name .' / <i>'.$rf->assess_name_bi .'</i></td>
		<td style="border-right:1px solid #000000;padding-top:0px" align="center">'.$per.'%</td>
		</tr>';

		
		$total +=$per;
		$total_form +=$per;
	//}
		
	$i++;
	$rspan ++;
	}
}

$per_sum = 0;
if($this->model->courseAssessmentSummative){
	foreach($this->model->courseAssessmentSummative as $rs){
		$per_sum +=$rs->as_percentage;
		$total +=$rs->as_percentage;
	} 
		
}

$border_no_bottom = 'style="border-top:1px solid #000000;border-right:1px solid #000000;border-left:1px solid #000000"';
//$rspan = 2;
$html .= '<tr><td style="border:1px solid #000000" rowspan="'.$rspan.'"> A.</td><td style="border-top:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000"  colspan="2"> Pentaksiran Berterusan <br />
 <i> Continuous Assessment</i>
</td><td style="border-top:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" align="center">'.$total_form.'%</td></tr>';

$html .= $html_as;

$html .= '<tr><td style="border:1px solid #000000"> B.</td><td style="border-top:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000"  colspan="2"> Peperiksaan Akhir / Pentaksiran Akhir<br /> <i> Final Exam / Final Assessment*</i></td><td style="border-top:1px solid #000000;border-left:1px solid #000000;border-right:1px solid #000000" align="center">'.$per_sum.'%</td></tr>';

$html .='<tr>
			<td colspan="3" align="right" style="border:1px solid #000000">Jumlah/ <i>Total </i> &nbsp;&nbsp; </td><td align="center" style="border:1px solid #000000">'. $total .'%</td>
			</tr>';
			
$html .='</table></td></tr></table>
 * Pentaksiran Akhir ialah 0% jika kursus melibatkan Peperiksaan Akhir sahaja dan sebaliknya.<br />
  <i> Final Assessment is 0% if the course involves Final Exam only and vice versa. </i>

';
$prepared_by = '';
$prepare = $this->model->preparedBy;
if($prepare){
	$prepared_by = $prepare->fullname;
}
$html .='<br/><br/>


<table border="1" cellpadding="10" nobr="true" style="font-size:12pt">
<tr>
<td>
<b>Disediakan oleh:<br/>
<i>Prepared by:</i></b>
<br/><br/>
Tandatangan:<br/>
<i>Signature:</i>
<br/><br/>
Nama:<br />
<i>Name:</i> '.ucwords(strtolower($prepared_by)).'
<br/><br/>
Tarikh:<br />
<i>Date:</i> '. $this->model->prepareDate .'

</td>

<td>
Tarikh Kelulusan Fakulti/ Pusat<br/>
<i>Date of Faculty/ Centre’s Approval:</i> '. $this->model->senateDate .'
<br/><br/>

            

Tarikh Kelulusan Senat:<br/>
<i>Date of Senate’s Approval:</i> 
<br/><br/>

<b>Disahkan oleh:<br/>
<i>Verified by:</i></b>
<br/><br/>

Tandatangan:<br/>
<i>Signature:</i>
<br/><br/>


Nama & Jawatan<br/>
<i>Name & Designation:</i><br/>
(Cop/ Stamp)



<br/><br/>
Tarikh:<br/>
<i>Date:</i>

</td>
</tr>
</table>';

$ast = 10;
$wnote = $tab_syl - $ast;

$html .= '<br /><table border="0" cellpadding="0" style="font-size:10pt">
<tr><td width="'.$ast.'">*</td><td width="'.$wnote.'">Sebarang perubahan kepada maklumat kursus (kecuali bahan rujukan) perlu mendapat kelulusan Fakulti/ Pusat atau Senat mengikut kesesuaian.</td></tr>
<tr><td></td><td><i>Any changes to the course information (except for sources of references) must be approved by the Faculty/ Centre or the Senate, wherever applicable.</i></td></tr>
</table>




';



$html .='</td>
</tr>
</table>

';



$echohtml = $html;
$tbl = <<<EOD
$html
EOD;
//$pdf->setFooterTable(true);
$this->pdf->lineFooterTable = true;
$this->pdf->writeHTML($tbl, true, false, false, false, '');
//$pdf->setFooterTable(false);
$this->pdf->lineFooterTable = false;
		
		
	}

	
	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('Pusat Kokurikulum');
		$this->pdf->SetTitle('FK02 - '.$this->model->course->course_code );
		$this->pdf->SetSubject('FK02 - '.$this->model->course->course_code );
		$this->pdf->SetKeywords('Maklumat Kursus');



		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$this->pdf->SetMargins(PDF_MARGIN_LEFT, 13, PDF_MARGIN_RIGHT);
		//$this->pdf->SetMargins(0, 0, 0);
		$this->pdf->SetHeaderMargin(15);
		//$this->pdf->SetHeaderMargin(0);

		 //$this->pdf->SetHeaderMargin(0, 0, 0);
		$this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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
