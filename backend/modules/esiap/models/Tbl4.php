<?php

namespace backend\modules\esiap\models;

use Yii;
use common\models\Common;


class Tbl4
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
		
		$this->pdf = new Tbl4Start(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$this->pdf->SetFont("arialnarrow", '', 11);
		$this->writeHeaderFooter();
		
		$this->startPage();
		
		
		$this->doBody();

		$this->pdf->Output('TABLE 4 - '.$this->model->course->course_code .'.pdf', 'I');
	}
	
	
	
	
	public function writeHeaderFooter(){
		$wtab = 180 + 450;
		$this->wtab = $wtab;

		//$this->pdf->lineFooterTable = false;
	}
	
	public function doBody(){

	$this->pdf->lineFooterTable = true;
$wtab = 180 + 480;
$this->wtab = $wtab;
		

$colnum = 23;
$col_label = 81;
$col_content = $wtab - $colnum - $col_label;



$colcontent = $wtab - $colnum;
$style_shade = 'style="background-color:#d9d9d9; border: 1px solid #000000"';
$style_black = 'style="background-color:#757575; border: 1px solid #000000"';
$border = 'style="border: 1px solid #000000"';


$html = '<table border="0" width="'.$wtab.'" cellpadding="5">

<tr>
<td width="'.$colnum.'" '.$style_shade.' rowspan="2" align="center">1. </td>

<td width="'.$col_label.'" '.$style_shade.'>Name of Course:</td>
<td width="'.$col_content.'" colspan="14" '.$border.'>'. strtoupper($this->model->course->course_name_bi) . '</td>
</tr>

<tr>
<td '.$style_shade.'>Course Code: </td>
<td width="'.$col_content.'" colspan="14" '.$border.'>'.$this->model->course->course_code .'</td>
</tr>


<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center">2. </td>

<td width="'.$col_label.'" '.$style_shade.'>Synopsis:</td>
<td width="'.$col_content.'" colspan="14" '.$border.'>'.$this->model->profile->synopsis_bi .'</td>
</tr>

<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center">3. </td>

<td width="'.$col_label.'" '.$style_shade.'>Name(s) of academic staff:</td>
<td width="'.$col_content.'" colspan="14" '.$border.'>';

$staff = $this->model->profile->academicStaff;

if($staff){
	foreach($staff as $st){
		$html .= $st->staff->niceName . '<br />';
	}
}

$html .= '</td>
</tr>';

$col_sem = 120;
$col_sem_num = 30;
$col_year = 40;
$col_year_num = 30;
$col_sem_bal = $wtab - $colnum - $col_label - $col_sem - $col_sem_num - $col_year - $col_year_num;


$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center">4. </td>

<td width="'.$col_label.'" '.$style_shade.'>Semester and Year Offered:</td>
<td width="'.$col_sem.'" colspan="4" align="center" '.$style_shade.'>Semester</td>
<td width="'.$col_sem_num.'" '.$border.' align="center">';

$offer_sem = $this->model->profile->offer_sem;
if($offer_sem == 0){
	$offer_sem = '';
}
$html .= $offer_sem;
$html .= '</td>
<td width="'.$col_year.'" align="center" '.$style_shade.'>Year</td>
<td width="'.$col_year_num.'" '.$border.' align="center">';
$offer_year = $this->model->profile->offer_year;
if($offer_year == 0){
	$offer_year = '';
}
$html .= $offer_year;
$html .= '</td>
<td width="'.$col_sem_bal.'" colspan="7" '.$style_black.'></td>
</tr>

<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center">5. </td>

<td width="'.$col_label.'" '.$style_shade.'>Credit Value:</td>
<td width="'.$col_content.'" colspan="14" '.$border.'>'.$this->model->course->credit_hour .'</td>
</tr>';


$pre = $this->model->profile->coursePrerequisite;

$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center">6. </td>

<td width="'.$col_label.'" '.$style_shade.'>Prerequisite/co-requisite (if any):</td>
<td width="'.$col_content.'" colspan="14" '.$border.'>'.$pre[1].'</td>
</tr>';
//////////////////////////CLO/////////////////////
$col_wide = $wtab - $colnum;
$html_clo = '';

if($this->model->clos){
	$clo_row = count($this->model->clos) + 1;
	$i=1;
	foreach($this->model->clos as $c){
	$html_clo .= '<tr>
<td width="'.$col_label.'" '.$style_shade.' align="center">CLO '.$i.'</td>
<td width="'.$col_content.'" colspan="14" '.$border.'>'.$c->clo_text_bi .' '.$c->taxoPloBracket.'</td>
</tr>';
	$i++;	
	}
}else{
	$clo_row = 2;
	$html_clo .= '<tr>
<td width="'.$col_label.'" '.$style_shade.' align="center">CLO 1</td>
<td width="'.$col_content.'" colspan="14" '.$border.'></td>
</tr>';

}
$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center" rowspan="'.$clo_row.'">7. </td>

<td width="'.$col_wide.'" colspan="15" '.$style_shade.'>
Course Learning Outcomes (CLO) :  At the end of the course the students will be able to: (example)
<br />
-  explain the basic principles of immunisation (C2,PLO1)

</td>
</tr>
';
$html .= $html_clo;

$col_assess = 88;
$col_unit = 32;
$col_unit2 = 36.5;
$col_learning = $col_content - $col_assess - ($col_unit * 9) - ($col_unit2 * 3);
$col_plo_label = ($col_unit * 9) + ($col_unit2 * 3);

///////////////////////// plo ////////////////////////

$html_plo= '';
if($this->model->clos){
	$clo_row = count($this->model->clos) + 7;
	$i=1;
	foreach($this->model->clos as $c){
	$html_plo .= '<tr>
<td width="'.$col_label.'" '.$style_shade.' align="center">CLO '.$i.'</td>';

for($e=1;$e<=12;$e++){
	$plo_str = 'PLO'.$e;
	$html_plo .='<td align="center" '.$border.'>';
	if($c->{$plo_str} == 1){
		$html_plo .= '<span style="font-size:14px;"><span>√</span></span>';
	}
	$html_plo .= '</td>';
}

$html_plo .= '<td '.$border.'>';

$s=1;
if($c->cloDeliveries){
$html_plo .='<table border="0">';
foreach($c->cloDeliveries as $row){
	$html_plo .= '<tr>';
	$html_plo .= '<td>';
	$html_plo .= $row->delivery->delivery_name_bi ;
	$html_plo .= '</td>';
	$html_plo .= '</tr>';
$s++;
}
$html_plo .='</table>';
}
$html_plo .='</td><td '.$border.'>';

if($c->cloAssessments){
$html_plo .='<table border="0">';
foreach($c->cloAssessments as $row){
	$html_plo  .= '<tr>';
	$html_plo  .= '<td>';
	if($row->assessment){
		$html_plo  .= $row->assessment->assess_name_bi ;
	}
	
	$html_plo  .= '</td>';
	$html_plo  .= '</tr>';
}
$html_plo  .='</table>';
}


$html_plo .='</td>


</tr>';
	$i++;	
	}
}else{
	$clo_row = 8;
	$html_plo .= '<tr>
<td width="'.$col_label.'" '.$style_shade.' align="center">CLO 1</td>
<td width="'.$col_content.'" colspan="14" '.$border.'></td>
</tr>';

}
$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center" rowspan="'.$clo_row.'">8. </td>

<td width="'.$col_wide.'" colspan="15" '.$style_shade.'>
Mapping of the Course Learning Outcomes to the Programme Learning Outcomes, Teaching Methods and Assessment :<br />
Please select the Learning Outcome Domain (LOD) for each PLO in the cells above it. E.g. PLO1 - Knowledge, PLO2 - Cognitive, PLO3 - Practical Skills

</td>
</tr>';

$html .= '
<tr>
<td width="'.$col_label.'" '.$style_shade.' align="center" rowspan="3"><b>Course Learning Outcomes (CLO)</b></td>
<td width="'.$col_plo_label.'" align="center" colspan="12" '.$style_shade.'><b>Programme Learning Outcomes (PLO)</b></td>
<td width="'.$col_learning.'" rowspan="3" align="center" '.$style_shade.'><b>Learning and Teaching Method</b></td>
<td width="'.$col_assess.'" rowspan="3" align="center" '.$style_shade.'><b>Assessment Method</b></td>
</tr>


<tr>';

$vert = $this->model->versionType;

for($i=1;$i<=9;$i++){
	$pattr = 'plo' .$i. '_bi';
	$html .= '<td width="'.$col_unit.'" style="font-size:8px; border:1px solid #000000">'.$vert->{$pattr}.'</td>';
}
//make separate due to width difference
for($i=10;$i<=12;$i++){
	$pattr = 'plo' .$i. '_bi';
	$html .= '<td width="'.$col_unit2.'" style="font-size:8px; border:1px solid #000000">'.$vert->{$pattr}.'</td>';
}
$html .='</tr>


<tr>';
//row PLO NUMBER
for($i=1;$i<=9;$i++){
	$html .= '<td align="center" '.$border.'><b>PLO'.$i.'</b></td>';
}

for($i=10;$i<=12;$i++){
	$html .= '<td align="center" '.$border.'><b>PLO'.$i.'</b></td>';
}
$html .='</tr>

';
$html .= $html_plo;

$html .= '<tr>
<td width="'.$col_wide.'" colspan="15" style="border-right:1px solid #000000">

</td>
</tr>
<tr>
<td width="'.$col_wide.'" colspan="15" style="border-right:1px solid #000000">
<i>Indicate the relevancy between the CLO and PLO by ticking “√“ the appropriate relevant box.</i>
</td>
</tr>
<tr>
<td width="'.$col_wide.'" colspan="15" style="border-right:1px solid #000000">
<i>(This description must be read together  with Standards 2.1.2 , 2.2.1 and 2.2.2 in  Area 2 - pages 16 & 18) </i>
</td>
</tr>';

///////////////////////////////////////////// transferable
$col_trans_label = $col_label + ($col_unit * 5);
$col_trans_number = $col_unit;
$col_trans_bal = $wtab - $colnum - $col_trans_label - $col_trans_number;

$trans_text = $this->model->profile->transfer_skill_bi;

$version_type = $this->model->version_type_id;

$transferables = $this->model->profile->transferables;


$html_transfer = '';
$rowspan_transfer = 1;
if($version_type == 1){
$html_transfer .= '<td width="'.$col_trans_number.'" '.$style_shade.' align="center">1</td>
	<td colspan="8" width="'.$col_trans_bal.'" '.$border.'>
	'.$trans_text.'
	</td>
	</tr>';
}elseif($version_type == 2){

if($transferables){
	$kira = 1;
	foreach($transferables as $transfer){
		if($kira == 1){
			$html_transfer .= '<td width="'.$col_trans_number.'" '.$style_shade.' align="center">1</td>
					<td colspan="8" width="'.$col_trans_bal.'" '.$border.'>
					'.$transfer->transferable->transferable_text_bi.'
					</td>
					</tr>';
		}else{
			$html_transfer .= '<tr>
				<td width="'.$col_trans_number.'" '.$style_shade.' align="center">'.$kira.'</td>
				<td colspan="8" width="'.$col_trans_bal.'" '.$border.'>'. $transfer->transferable->transferable_text_bi.'</td>
				</tr>';
		}
	$kira++;
	}
	$rowspan_transfer = $kira - 1;
}else{
	$html_transfer .= '<td width="'.$col_trans_number.'" '.$style_shade.' align="center">1</td>
				<td colspan="8" width="'.$col_trans_bal.'" '.$border.'>
				
				</td>
				</tr>';
}

	
}else{ // if no version type
	$html_transfer .= '<td width="'.$col_trans_number.'" '.$style_shade.' align="center">1</td>
	<td colspan="8" width="'.$col_trans_bal.'" '.$border.'>
	NO_APPLICATION_VERSION_TYPE_ERROR
	</td>
	</tr>';
}


$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center" rowspan="'.$rowspan_transfer.'">9. </td>

<td width="'.$col_trans_label.'" colspan="6" '.$style_shade.' rowspan="'.$rowspan_transfer.'">
Transferable Skills (if applicable)
(Skills learned in the course of study which can be useful and utilized in other settings)<br />

</td>';
$html .= $html_transfer;
//////////////////
//////////////////
/////////////////

$syl_row = count($this->model->syllabus);
if($this->model->courseAssessmentFormative){
	$formative_row = count($this->model->courseAssessmentFormative);
}else{
	$formative_row = 1;
}
if($this->model->courseAssessmentSummative){
	$summative_row = count($this->model->courseAssessmentSummative);
}else{
	$summative_row = 1;
}

$span_10 = 14 + $syl_row + $formative_row + $summative_row;
$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center" rowspan="'.$span_10.'">10. </td>

<td width="'.$col_wide.'" colspan="15" '.$style_shade.'>
<b>Distribution of Student Learning Time (SLT)</b>
</td>
</tr>';
$tab_syl = $wtab - $colnum;
$htopic = $col_trans_label + $col_unit;
$hclo = $col_unit;

$depend = 35;
$dep_all = $depend * 4;
$gui = 63;
$ind = 73;
$hslt = $dep_all + $gui + $ind;
$flex = $wtab - $colnum - $htopic - $hclo - $hslt;
$assess_percent = ($dep_all / 4) + $hclo;
$assess_f2f = ($dep_all / 4) * 3;
$assess_nf2f = $gui + $ind;

$html .= '<tr nobr="true">
<th width="'.$htopic.'" rowspan="3" align="center" '.$style_shade.'><b>Course Content Outline</b></th>
<th width="'.$hclo.'" rowspan="3" align="center" '.$style_shade.'><b>CLO*</b></th>
<th width="'.$hslt.'" colspan="6" align="center" '.$style_shade.'>
<b>Teaching and Learning Activities </b>
</th>

<th rowspan="3" width="'.$flex.'" align="center" '.$style_shade.'>
<b>SLT</b>
</th>

</tr>
<tr nobr="true" '.$style_shade.'>
<th colspan="4" width="'.$dep_all.'" align="center" '.$style_shade.'><b>Guided Learning<br />(F2F)</b></th>
<th rowspan="2" width="'.$gui.'" align="center" '.$style_shade.'><b>Guided Learning<br />(NF2F)</b><br />eg: 
e-Learning</th>
<th rowspan="2" width="'.$ind.'" align="center" '.$style_shade.'><b>Independent Learning (NF2F)</b></th>
</tr>
<tr>';
$html .= '<th align="center" '.$style_shade.'><b>L</b></th>
<th align="center" '.$style_shade.'><b>T</b></th>
<th align="center" '.$style_shade.'><b>P</b></th>
<th align="center" '.$style_shade.'><b>O</b></th>
</tr>';



$tlec = 0;
$ttut = 0;
$tprac =0;
$toth = 0;
$tind = 0;
$tass = 0;
$tgrand = 0;
if($this->model->syllabus ){
	$week_num = 1;
	foreach($this->model->syllabus as $row){
	if($row->duration > 1){
		$end = $week_num + $row->duration - 1;
		$show_week = $week_num . '-<br />' . $end;
	}else{
		$show_week = $week_num;
	}
	$week_num = $week_num + $row->duration;
	$html .='<tr nobr="true">';
	$html .='<td '.$border.'>';
	$arr_all = json_decode($row->topics);
	if($arr_all){
	$i = 1;
	$html .= '<table><tr><td width="7%">'.$show_week.'. </td><td width="93%">';
	foreach($arr_all as $rt){
		$wk = $i == 1 ? $row->week_num . ".  " : '';
		$br = $i == 1 ? '' : "<br />";
		$html .= $br . $rt->top_bi;
		
		if($rt->sub_topic){
		$html .= '<br/><table>';
			foreach($rt->sub_topic as $rst){
			$html .='<tr><td width="5%">- </td><td width="95%">' . $rst->sub_bi . '</td></tr>';
			}
		$html .='</table>';
		}
	$i++;
	}
	$html .= '</td></tr></table>';
	}
	$html .='</td>';
	$clo = json_decode($row->clo);
	$str="";
	if($clo){
		$kk=1;
		foreach($clo as $clonum){
			$comma = $kk == 1 ? "" : "<br />";
			$str .= $comma. 'CLO'.$clonum;
			$kk++;
		}
	}
	$html .= '<td align="center" '.$border.'>'.$str.'</td>';
	$html .='<td align="center" '.$border.'>'.$row->pnp_lecture .'</td>';
	$html .='<td align="center" '.$border.'>'.$row->pnp_tutorial .'</td>';
	$html .='<td align="center" '.$border.'>'.$row->pnp_practical .'</td>';
	$html .='<td align="center" '.$border.'>'.$row->pnp_others .'</td>';
	$html .='<td align="center" '.$border.'>'.$row->nf2f .'</td>';
	$html .='<td align="center" '.$border.'>'.$row->independent .'</td>';
	$sub = $row->pnp_lecture + $row->pnp_tutorial + $row->pnp_practical + $row->pnp_others + $row->independent + $row->nf2f;
	$html .='<td align="center" '.$style_shade.'>'.$sub.'</td>';
	$html .='</tr>';
	$tlec += $row->pnp_lecture;
	$ttut += $row->pnp_tutorial;
	$tprac += $row->pnp_practical;
	$toth += $row->pnp_others;
	$tind += $row->nf2f;
	$tass += $row->independent;
	$tgrand +=$sub;
		
}
}



	$html .='<tr>';
	$html .='<td colspan="8" align="right" >';
		$html .= '<b>Total</b>';
	$html .='</td>';
	$html .='<td align="center" '.$style_shade.'>'.$tgrand.'</td>';
	$html .='</tr>';
	$gran_total_slt = $tgrand;
	$html .='<tr>
<td width="'.$col_wide.'" colspan="15" style="border-right:1px solid #000000"></td>
</tr>';

	
	$html .='<tr style="font-weight:bold">
	<td width="'.$htopic.'" colspan="7" align="center" '.$style_shade.'>Continuous Assessment</td>

	<td width="'.$assess_percent.'" colspan="2" align="center" '.$style_shade.'>Percentage (%)</td>
	<td width="'.$assess_f2f .'" colspan="3" align="center" '.$style_shade.'>F2F</td>
	<td width="'.$assess_nf2f .'" colspan="2" align="center" '.$style_shade.'>NF2F</td>
	<td width="'.$flex.'" align="center" '.$style_shade.'>SLT</td>
	</tr>';
	
	$i=1;
	$total = 0;
	$slt_assess = 0;
	$total_form = 0;
	
	$num = $htopic / 4;
	$as_width = $htopic / 4 * 3;
	
	if($this->model->courseAssessmentFormative){
	
	foreach($this->model->courseAssessmentFormative as $rf){
			$per = $rf->as_percentage + 0;
			$f2f = $rf->assess_f2f;
			$nf2f = $rf->assess_nf2f;
			$sub_total = $f2f + $nf2f;
			$slt_assess += $sub_total;
			$c=1;
			$cc=1;
			$str="";

			$html .='<tr>
			<td width="'.$num.'" '.$style_shade.' align="center">'.$i.'</td><td width="'.$as_width.'" colspan="2" '.$border.'>'.$rf->assess_name_bi .'</td>
			
			<td width="'.$assess_percent .'" colspan="3" align="center" '.$border.'>'. $per .'</td>
			<td width="'.$assess_f2f .'" colspan="2" align="center" '.$border.'>'.$f2f.'</td>
			<td width="'.$assess_nf2f .'" align="center" '.$border.'>'.$nf2f.'</td>
			<td width="'.$flex.'" align="center" '.$style_shade.'>'.$sub_total .'</td>
			</tr>';
			$total +=$per;
	$i++;
	}
	}else{
		$html .='<tr>
			<td width="'.$num.'" '.$style_shade.' align="center">'.$i.'</td><td width="'.$as_width.'" colspan="2" '.$border.'></td>
			<td width="'.$assess_percent .'" colspan="3" align="center" '.$border.'></td>
			<td width="'.$assess_f2f .'" colspan="2" align="center" '.$border.'></td>
			<td width="'.$assess_nf2f .'" align="center" '.$border.'></td>
			<td width="'.$flex.'" align="center" '.$style_shade.'></td>
			</tr>';
	}
	
	
	$html .='<tr>';
	$html .='<td colspan="9" align="right" >';
		$html .= '<b>Total</b>';
	$html .='</td>';
	$html .='<td align="center" '.$style_shade.'>'.$slt_assess.'</td>';
	$html .='</tr>';
	$gran_total_slt += $slt_assess;
	$html .='<tr>
<td width="'.$col_wide.'" colspan="15" style="border-right:1px solid #000000"></td>
</tr>';


$html .='<tr style="font-weight:bold">
	<td width="'.$htopic.'" colspan="7" align="center" '.$style_shade.'>Final Assessment</td>

	<td width="'.$assess_percent.'" colspan="2" align="center" '.$style_shade.'>Percentage (%)</td>
	<td width="'.$assess_f2f .'" colspan="3" align="center" '.$style_shade.'>F2F</td>
	<td width="'.$assess_nf2f .'" colspan="2" align="center" '.$style_shade.'>NF2F</td>
	<td width="'.$flex.'" align="center" '.$style_shade.'>SLT</td>
	</tr>';
	
	$i=1;
	$total = 0;
	$slt_assess = 0;
	$total_form = 0;
	if($this->model->courseAssessmentSummative){
	
	foreach($this->model->courseAssessmentSummative as $rf){
			$per = $rf->as_percentage + 0;
			$f2f = $rf->assess_f2f;
			$nf2f = $rf->assess_nf2f;
			$sub_total = $f2f + $nf2f;
			$slt_assess += $sub_total;
			$c=1;
			$cc=1;
			$str="";

			$html .='<tr>
			<td width="'.$num.'" '.$style_shade.' align="center">'.$i.'</td><td width="'.$as_width.'" colspan="2" '.$border.'>'.$rf->assess_name_bi .'</td>
			
			<td width="'.$assess_percent .'" colspan="3" align="center" '.$border.'>'. $per .'</td>
			<td width="'.$assess_f2f .'" colspan="2" align="center" '.$border.'>'.$f2f.'</td>
			<td width="'.$assess_nf2f .'" align="center" '.$border.'>'.$nf2f.'</td>
			<td width="'.$flex.'" align="center" '.$style_shade.'>'.$sub_total .'</td>
			</tr>';
			$total +=$per;
	$i++;
	}
	}else{
		$html .='<tr>
			<td width="'.$num.'" '.$style_shade.' align="center">'.$i.'</td><td width="'.$as_width.'" colspan="2" '.$border.'></td>
			<td width="'.$assess_percent .'" colspan="3" align="center" '.$border.'></td>
			<td width="'.$assess_f2f .'" colspan="2" align="center" '.$border.'></td>
			<td width="'.$assess_nf2f .'" align="center" '.$border.'></td>
			<td width="'.$flex.'" align="center" '.$style_shade.'></td>
			</tr>';
	}
	
	
	$html .='<tr>';
	$html .='<td colspan="9" align="right" >';
		$html .= '<b>Total</b>';
	$html .='</td>';
	$html .='<td align="center" '.$style_shade.'>'.$slt_assess.'</td>';
	$html .='</tr>';
	$gran_total_slt += $slt_assess;
	
	$total_ind_text = $htopic + $assess_percent + $assess_f2f ;
$box_practical = $gui - 20;
$grand_slt_text = $assess_nf2f - $box_practical;
	
	$html .='<tr>
	<td colspan="11" rowspan="2" width="'.$total_ind_text.'" >
	<br /><br /><b>**Please tick (√) if this course is Latihan Industri/ Clinical Placement/ Practicum/ WBL <br />using Effective Learning Time(ELT) of 50%</b>
	</td>
<td width="'.$box_practical.'"></td>
	<td colspan="2" width="'.$grand_slt_text.'" align="right"></td>
	
	';
	$html .='<td align="center" width="'.$flex.'" style="border-right:1px solid #000000"></td>
</tr>';

if($this->model->slt->is_practical == 1){
	$tick_prac = '√';
}else{
	$tick_prac = '';
}

$html .='<tr>';
	$html .='
	<td style="border:1px solid #000000;font-size:15px" align="center" width="'.$box_practical.'">'.$tick_prac.'</td>
	<td colspan="2" width="'.$grand_slt_text.'" align="right"><b>GRANT TOTAL SLT</b></td>
	
	';
	$html .='<td align="center" '.$style_shade.' width="'.$flex.'"><b>'.$gran_total_slt.'</b></td>';
	$html .='</tr>';
	
	$html .='<tr>
<td width="'.$col_wide.'" colspan="15" style="border-right:1px solid #000000">
<i>L = Lecture, T = Tutorial, P= Practical, O= Others, F2F=Face to Face, NF2F=Non Face to Face</i><br />
<i>*Indicate the CLO based on the CLO’s numbering in Item 8.</i>
</td>
</tr>';

$special = $col_label + 90;
$special_content = $col_content - 90;
$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center">11. </td>

<td width="'.$special.'" '.$style_shade.' colspan="3">Identify special requirement to deliver the course (e.g: software, nursery, computer lab, simulation room, etc): </td>


<td width="'.$special_content.'" colspan="12" '.$border.'>'.$this->model->profile->requirement_bi.'</td>
</tr>';


$ref = $special + 80;
$ref_content = $special_content -80;
$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center">12. </td>

<td width="'.$ref.'" '.$style_shade.' colspan="3">References (include required and further readings, and should be the most current) </td>


<td width="'.$ref_content.'" colspan="12" '.$border.'>';


$i = 1;
if($this->model->mainReferences){
	
	$html .= '<table>';
	foreach($this->model->mainReferences as $row){
		$html .='<tr>';
		$html .='<td width="5%">'.$i.'. </td>';
		$html .='<td width="95%">'.$row->formatedReference.'</td>';
		$html .='</tr>';
	$i++;
	}
	$html .= '</table>';
}

if($this->model->additionalReferences){
	$html .= '<table>';
	foreach($this->model->additionalReferences as $row){
		$html .='<tr>';
		$html .='<td width="5%">'.$i.'. </td>';
		$html .='<td width="95%">'.$row->formatedReference.'</td>';
		$html .='</tr>';
	$i++;
	}
	$html .= '</table>';
}




$html .= '</td>
</tr>';

$html .= '<tr>
<td width="'.$colnum.'" '.$style_shade.' align="center">13. </td>

<td width="'.$ref .'" '.$style_shade.' colspan="3">Other additional information : </td>


<td width="'.$ref_content.'" colspan="12" '.$border.'>'.$this->model->profile->additional_bi.'</td>
</tr>';
	

$html .= '</table>
';

//echo $html;die();

$this->pdf->SetFont('calibri', '', 8); // 8
$tbl = <<<EOD
$html
EOD;

$this->pdf->writeHTML($tbl, true, false, false, false, '');
		
		


$this->pdf->lineFooterTable = false;
		
		
	}

	
	
	
	public function startPage(){
		// set document information
		$this->pdf->SetCreator(PDF_CREATOR);
		$this->pdf->SetAuthor('Table 4');
		$this->pdf->SetTitle('Table 4 - '.$this->model->course->course_code );
		$this->pdf->SetSubject('Table 4 - '.$this->model->course->course_code );
		$this->pdf->SetKeywords('Maklumat Kursus');



		// set header and footer fonts
		$this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$this->pdf->SetMargins(12, 18, 12);
		//$this->pdf->SetMargins(0, 0, 0);
		$this->pdf->SetHeaderMargin(13);
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
