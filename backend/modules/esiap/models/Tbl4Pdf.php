<?php

namespace backend\modules\esiap\models;

use Yii;
use common\models\Common;
use backend\models\Faculty;
use yii\helpers\FileHelper;

class Tbl4Pdf
{
	public $model;
	public $pdf;
	public $html;
	public $directoryAsset;
	
	public $total_lec = 0;
	public $total_tut = 0;
	public $total_prac = 0;
	public $total_hour = 0;
	
	public $wtab = 660;
	public $colnum = 23;
	public $col_label = 98;
	public $col_content;
	public $font_size = 8;
	public $font_blue = 'color:#0070c0';
	public $font_brown = 'color:#c65911';
	
	/* $bgcolor = 'E7E6E6';
	$bgcolor_green = '548235';
	$bgcolor_dark = 'AEAAAA';
	$bgcolor_blue = '002060'; */
	
	public function generatePdf(){

		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new Tbl4PdfStart(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$this->pdf->SetFont("arialnarrow", '', 11);
		
		$this->setDocStyle();
		$this->writeHeaderFooter();
		
		$this->startPage();
		$this->courseName();
	 	$this->synopsis();
		$this->academicStaff();
		$this->semYear();
		$this->creditValue();
		$this->prerequisite();
		$this->clo();
		$this->mapping(); 
		$this->transferable(); 
		$this->sltColums();
		$this->sltHead();
		$this->sltSyllabus(); 
		$this->sltContAssessHead();
		$this->sltSumAssessHead(); 
		$this->sltSummary();
		$this->specialRequirement();
		$this->references(); 
		$this->additionalInfomation();
		$this->htmlWriting();
		$this->preparedBy();
		
		$this->signiture();
		$this->signitureVerify();
		
		

		$this->pdf->Output('TABLE 4 - '.$this->model->course->course_code .'.pdf', 'I');
	}
	
	public $shade_dark;
	public $shade_light;
	public $shade_green;
	public $shade_credit;
	public $border;
	public $sborder;
	public $border_top_left;
	public $border_right_left;
	public $border_top_right;
	public $border_top_bottom;
	public $border_not_top;
	public $border_not_bottom;
	public $border_bottom;
	public $border_left;
	public $border_right;
	public $border_left_bottom;
	public $border_right_bottom;
	public $wall;
	
	public function setDocStyle(){
		$this->shade_light = 'style="background-color:#e7e6e6; border: 1px solid #000000"';
		$this->shade_dark = 'style="background-color:#aeaaaa; border: 1px solid #000000"';
		$this->shade_credit = 'style="color:#FFFFFF;line-height:20px;font-weight:bold;background-color:#548235; border: 1px solid #000000"';
		$this->shade_green = 'style="color:#FFFFFF;font-weight:bold;background-color:#548235; border: 1px solid #000000"';
		$this->border = 'style="border: 1px solid #000000"';
		$this->sborder = 'border: 1px solid #000000';
		$this->border_top_left = 'style="border-top: 1px solid #000000;border-left: 1px solid #000000;"';
		$this->border_left = 'style="border-left: 1px solid #000000;"';
		$this->border_right = 'style="border-right: 1px solid #000000;"';
		$this->border_right_left = 'style="border-right: 1px solid #000000;border-left: 1px solid #000000;"';
		$this->border_top_right = 'style="border-top: 1px solid #000000;border-right: 1px solid #000000;"';
		
		$this->border_top_bottom = 'style="border-top: 1px solid #000000;border-bottom: 1px solid #000000"';
		$this->border_right_bottom = 'style="border-right: 1px solid #000000;border-bottom: 1px solid #000000"';
		$this->border_left_bottom = 'style="border-left: 1px solid #000000;border-bottom: 1px solid #000000"';
		$this->border_not_top = 'style="border-right: 1px solid #000000;border-left: 1px solid #000000;border-bottom: 1px solid #000000"';
		$this->border_not_bottom = 'style="border-right: 1px solid #000000;border-left: 1px solid #000000;border-top: 1px solid #000000"';
		$this->border_bottom = 'style="border-bottom: 1px solid #000000"';
	}
	
	
	
	
	public function writeHeaderFooter(){
		//$wtab = 180 + 450;
		//$this->wtab = $wtab;

		//$this->pdf->lineFooterTable = false;
	}
	
	public function courseName(){
		$this->pdf->lineFooterTable = true;
		$this->pdf->lineHeaderTable = true;
		$wtab = $this->wtab;
		$colnum = $this->colnum;
		$col_label = $this->col_label;
		$col_content = $wtab - $colnum - $col_label;
		$this->col_content = $col_content;
		$this->wall = $wtab - $colnum;
		$col1 = $col_content / 3;
		$col2 = $col1 * 2;
		$border = $this->border;


		if($this->model->course->classification){
			$class = $this->model->course->classification->class_name_bi;
		}else{
			$class = '';
		}

		$html = '
		<div style="font-size:12px"><b>Table 4</b>: Summary of Course Information</div><br />
		
		<table border="0" width="'.$wtab.'" cellpadding="5">

		<tr>

		<td style="border: 1px solid #000000;line-height:1px" colspan="27"></td>
		</tr>

		<tr>
		<td width="'.$colnum.'" rowspan="3" align="center" '.$border.'>1</td>

		<td width="'.$col_label.'" colspan="3">Name of Course:</td>
		<td width="'.$col_content.'" colspan="23" '.$border.'>'. strtoupper($this->model->course->course_name_bi) . '</td>
		</tr>

		<tr>
		<td width="'.$col_label.'" '.$border.' colspan="3">Course Code: </td>
		<td width="'.$col_content.'" colspan="23" '.$border.'>'.$this->model->course->course_code .'</td>
		</tr>
		<tr>
		<td width="'.$col_label.'" '.$border.'  colspan="3">Course Classification: </td>
		<td width="'.$col1.'" colspan="7" '.$border.'>'.$class .'</td>
		<td width="'.$col2.'" colspan="16" '.$this->shade_light.'></td>
		</tr>


		';



		$this->html .= $html;



	}
	
	public function synopsis(){

		$html = '<tr>
		<td width="'.$this->colnum.'" align="center" '.$this->border.'>2</td>

		<td width="'.$this->col_label.'" colspan="3" '.$this->border.'>Synopsis:</td>
		<td width="'.$this->col_content.'" colspan="23" '.$this->border.'>'.$this->model->profile->synopsis_bi .'</td>
		</tr>';
		$this->html .= $html;

	}
	
	public function academicStaff(){
		$staff = $this->model->profile->academicStaff;
		$col_num_staff = 28;
		$col_name = $this->col_content - $col_num_staff;
		$arr_staff = array();
		if($staff){foreach($staff as $st){
			$arr_staff[] = $st->staff->niceName;
		}}
		$total = count($arr_staff) > 3 ? count($arr_staff) : 3;
		$rowspan =  $total;
		$html = '<tr>
		<td width="'.$this->colnum.'" align="center" '.$this->border.' rowspan="'. $rowspan .'" >3</td>

		<td width="'.$this->col_label.'" colspan="3" '.$this->border.' rowspan="'. $rowspan .'" >Name(s) of academic staff:</td>';
		
		for($i = 0;$i< $total;$i++){
			$num = $i + 1;
			$td = '<td width="'.$col_num_staff.'"  '.$this->shade_light.' align="center">';
			$td .= $num;
			$td .= '</td>';
			$td .= '<td width="'.$col_name.'" colspan="22" '.$this->border.'>';
			if(array_key_exists($i, $arr_staff)){
				$td .= $arr_staff[$i];
			}
			
			$td .= '</td>';
			
			if($i == 0){
				$html .= $td . '</tr>';
			}else{
				$html .= '<tr>';
				$html .= $td;
				$html .= '</tr>';
			}
		}

		$this->html .= $html;

	}
	
	public function semYear(){
		$col_sem = 70;
		$col_sem_num = 30;
		$col_year = 60;
		$col_year_num = 30;
		$col_sem_bal = $this->wtab - $this->colnum - $this->col_label - $col_sem - $col_sem_num - $col_year - $col_year_num;
		
		$html = '<tr>
		<td width="'.$this->colnum.'" align="center" '.$this->border.'>4</td>
		<td width="'.$this->col_label.'" '.$this->border.' colspan="3">Semester and Year Offered:</td>
		<td width="'.$col_sem.'" colspan="3" align="center" '.$this->border.'>Year Offered</td>
		<td width="'.$col_sem_num.'" '.$this->border.' align="center">';
		$offer_year = $this->model->profile->offer_year;
		if($offer_year == 0){
			$offer_year = '';
		}
		$html .= $offer_year;
		
		
		$html .= '</td>
		<td width="'.$col_year.'" align="center" '.$this->border.'>Semester</td>
		<td width="'.$col_year_num.'" '.$this->border.' align="center">';
		$offer_sem = $this->model->profile->offer_sem;
		if($offer_sem == 0){
			$offer_sem = '';
		}
		$html .= $offer_sem;
		
		$html .= '</td>
		<td width="'.$col_sem_bal.'" colspan="16" '.$this->border.'>Remarks: '.$this->model->profile->offer_remark.'</td>
		</tr>';
		$this->html .= $html;
	}
	
	public function creditValue(){
		$col_credit = 70;
		$col_bal = $this->col_content - $col_credit;
		$html = '<tr>
		
		<td width="'.$this->colnum.'" '.$this->border.' align="center">5</td>
		<td width="'.$this->col_label.'" '.$this->border.' colspan="3">Credit Value:</td>
		<td width="'.$col_credit.'" colspan="3" align="center" '.$this->shade_credit.'>'.$this->model->course->credit_hour .'</td>
		<td width="'.$col_bal.'" colspan="20" '.$this->shade_light.'></td>
		
		</tr>';
		$this->html .= $html;
	}
	
	public function prerequisite(){
		$pre = $this->model->profile->coursePrerequisite;
		$html = '<tr>
<td width="'.$this->colnum.'" align="center" '.$this->border.'>6</td>

<td width="'.$this->col_label.'" colspan="3" '.$this->border.'>Prerequisite/co-requisite (if any):</td>
<td width="'.$this->col_content.'" colspan="23" '.$this->border.'>'.$pre[1].'</td>
</tr>';
	$this->html .= $html;
	

	}
	
	public $total_clo;
	
	public function clo(){
		$kira = count($this->model->clos);
		$arr_clo = array();
		if($this->model->clos){
			foreach($this->model->clos as $clo){
				$arr_clo[] = $clo;
			}
		}
		$total = $kira > 8 ? $kira : 8;
		$this->total_clo = $total;
		$col_last = 28;
		$col_clo_num = 60;
		$col_bal = $this->col_content - $col_last;
		$col_rest = $this->col_content - $col_last - $col_clo_num;
		$rowspan_number =  $total + 1;
		$rowspan_clo =  $total ;
		
		
		$html = '<tr style="line-height:1%">
		<td width="'.$this->colnum.'" align="center" '.$this->border_top_left .'></td>
		<td width="'.$this->col_label.'" colspan="3" '.$this->border_top_bottom.'></td>
		<td width="'.$col_bal.'" colspan="22" '.$this->border_top_bottom.'></td>
		<td width="'.$col_last.'" '.$this->border_top_right .'></td>
		</tr>';
		
		$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@backend/views/myasset');
		
		$html .= '<tr>
		<td width="'.$this->colnum.'" align="center" '.$this->border_left_bottom .' rowspan="'. $rowspan_number .'">7</td>
		<td width="'.$this->col_label.'" rowspan="'.$rowspan_clo.'" colspan="3" '.$this->border .' align="center">Course Learning Outcomes (CLO)<br /><br />
		<img src="cloinfo.png" width="35" />
		</td>';
		
		////
		if(array_key_exists(0, $arr_clo)){
			$clo = $arr_clo[0];
			$html .= '<td colspan="2" width="'.$col_clo_num.'" align="center">CLO1</td>';
			$html .= '<td width="'.$col_rest.'" colspan="2" '.$this->border .'>'.$clo->clo_text_bi .' '.$clo->taxoPloBracket.'</td>';
		}else{
			$html .= '<td colspan="2" width="'.$col_clo_num.'"></td>';
			$html .= '<td width="'.$col_rest.'" colspan="2" '.$this->border .'></td>';
		}
		
		///
		
		$html .= '<td width="'.$col_last.'" '.$this->border_right_left .'></td>
		</tr>';
		
		
		
		
		$start =  1;
		
		for($i=1;$i<=$total;$i++){
			
			$index = $i - 1;
			$row =  + $i;
			if(array_key_exists($index, $arr_clo)){
				$html .= $this->cloItem($row, $i, $arr_clo[$index],$col_rest, $col_last, $col_clo_num);
			}else{
				$html .= $this->cloItem($row, $i, '', $col_rest, $col_last, $col_clo_num);
			}
			
		}
		
		
		
		$html .= '<tr style="line-height:1%">
		
		<td width="'.$this->col_label.'" colspan="3" '.$this->border_top_bottom .'></></td>
		<td width="'.$col_bal.'" colspan="22" '.$this->border_bottom .'></></td>
		<td width="'.$col_last.'" '.$this->border_right_bottom .'></></td>
		</tr>';
		
		
		$this->html .= $html;
	}
	
	public $clo_plo_html = '';
	
	public function cloItem($row, $clonumber, $clo, $col_rest, $col_last, $col_clo_num){
		
		$html = '';
		$this->clo_plo_html .= '<tr>
		
		<td align="center" '.$this->border_right_left.'></td>';
		
		$border = $this->border;
		
		$text = '';
		$clo_n = '';
		if($clonumber > 1){
			if($clonumber > 5 and $clo == ''){
				$border = $this->shade_dark;
			}
			if($clo){
				$text = $clo->clo_text_bi .' '.$clo->taxoPloBracket;
			}
			$html .= '<tr>';
			$html .= '<td colspan="2" width="'.$col_clo_num.'" '. $border .' align="center">CLO'.$clonumber.'</td>';
			$html .= '<td width="'.$col_rest.'" colspan="20" '. $border .'>'.$text.'</td>
			<td width="'.$col_last.'" '.$this->border_right_left .'></td>
			</tr>';
		}
		
		if($clo){
			$clo_n = 'CLO'.$clonumber;
		}
		
		
		
		$this->clo_plo_html .= '<td align="center" '. $border .'>'.$clo_n.'</td>';
		for($e=1;$e<=12;$e++){
			$plo_str = 'PLO'.$e;
			$this->clo_plo_html .='<td align="center" '.$border.'>';
			if($clo){
				if($clo->{$plo_str} == 1){
					$this->clo_plo_html .= '<span style="font-size:14px;"><span>√</span></span>';
				}
			}
			
			$this->clo_plo_html .= '</td>';
		}

		
		$s=1;
		$teach = '';
			if($clo){
				if($clo->cloDeliveries){
				foreach($clo->cloDeliveries as $row){
					$comma = $s == 1 ? '':', ';
					$teach .= $comma.$row->delivery->delivery_name_bi ;
				$s++;
				}
				}
			}
		$this->clo_plo_html .= '<td '.$border.'>'.$teach.'</td>';
		
		$assess = '';
		if($clo){
			if($clo->cloAssessments){
			$s=1;
			foreach($clo->cloAssessments as $row){
				if($row->assessment){
					$comma = $s == 1 ? '':', ';
					$assess  .= $comma.$row->assessment->assess_name_bi ;
				}
			$s++;
			}
			}
		}
		

		$this->clo_plo_html .= '<td '.$border.'>'.$assess.'</td>';
		
		$this->clo_plo_html .= '<td align="center" '.$this->border_right_left.'></td>
		</tr>';
		
		return $html;
		
	}
	
	public function mapping(){
	$wall = $this->wall;
	$col_first = 10;
	$col_last = 9;
	$col_clo = 80;
	$col_unit = 27;
	$col_plo_label = ($col_unit * 12);
	$col_teach_assess = $wall - $col_first - $col_clo - $col_plo_label - $col_last;
	$col_teach_assess = $col_teach_assess / 2;
	$col_learning =  $col_teach_assess;
	$col_assess = $col_teach_assess;
	$rowspan1 = $this->total_clo + 7;
	
	
	$html = '<tr>
<td width="'.$this->colnum.'" align="center" '.$this->border.' rowspan="'.$rowspan1.'">8</td>

<td width="'.$wall.'" colspan="26" '.$this->border_not_bottom.'>Mapping of the Course Learning Outcomes to the Programme Learning Outcomes, Teaching Methods and Assessment Methods.
<br />
</td>
</tr>';

$html .= '<tr>

<td width="'.$col_first.'" align="center" '.$this->border_right_left.'></td>
<td width="'.$col_clo.'" align="center" '.$this->shade_light.' rowspan="2">Course Learning Outcomes</td>
<td width="'.$col_plo_label.'" align="center" '.$this->shade_light.' colspan="12">Programme Learning Outcomes (PLO)</td>
<td width="'.$col_learning.'" align="center" '.$this->shade_light.' rowspan="2">Teaching Methods</td>
<td width="'.$col_assess.'" align="center" '.$this->shade_light.' rowspan="2">Assessment Methods</td>
<td width="'.$col_last.'" colspan="26" '.$this->border_right_left.'></td>
</tr>';



$html .= '<tr>

<td width="'.$col_first.'" align="center" '.$this->border_right_left.'></td>';
for($i=1;$i<=12;$i++){
	$params = $this->pdf->serializeTCPDFtagParameters(['PLO'. $i]);
	$html .= '<td width="'.$col_unit.'" '.$this->shade_light.'>';
	if($i<12){
		$html .= '<tcpdf method="textRotate" params="'.$params.'" />';
	}
	
	$html .='</td>';
}

$html .= '<td width="'.$col_last.'" '.$this->border_right_left.'></td>
</tr>';

//MQF
$html .= $this->clo_plo_html;

for($q=1;$q<=3;$q++){
	$rowspan='';
	
	$html .= '<tr nobr="true">';
	$html .= '	<td align="center" '.$this->border_right_left.' ></td>';
	$others = '';
	if($q == 1){
		$html .= '<td align="center" '.$this->shade_light.' rowspan="3">
		 Mapping with MQF Cluster of Learning Outcomes </td>';
		$others = '<td align="center" '.$this->shade_light.' rowspan="3"></td>
		<td align="center" '.$this->shade_light.' rowspan="3"></td>';
	}
	$arr = ['C1','C2', 'C3A', 'C3B', 'C3C', 'C3D', 'C3E', 'C3F', 'C4A', 'C4B', 'C5'];

	for($e=1;$e<=12;$e++){
		$html .='<td align="center" style="'.$this->sborder.';line-height:90%">';
		$idx = $e - 1;
		if($idx < 11 and $q == 1){
			$html .= $arr[$idx];
		}
		
		$html .= '</td>';
	}
	
	$html .= $others;
	$html .= '<td align="center" '.$this->border_right_left.'></td>
	</tr>
	';
}

$wd = $wall - $col_first;
$html .= '<tr>

<td width="'.$col_first.'"  '.$this->border_left_bottom.'></td>
<td width="'.$wd.'" colspan="25" '.$this->border_right_bottom.'>
<br />
<br />
Indicate the primary causal link between the CLO and PLO by ticking  \'√\' in the appropriate box.<br />
<span style="'. $this->font_blue.'"><b>C1</b> = Knowledge & Understanding, <b>C2</b> = Cognitive Skills, <b>C3A</b> = Practical Skills, <b>C3B</b> = Interpersonal Skills, <b>C3C</b> = Communication Skills, <b>C3D</b> = Digital Skills,<br />
<b>C3E</b> = Numeracy Skills, <b>C3F</b> = Leadership, Autonomy & Responsibility, <b>C4A</b> = Personal Skills, <b>C4B</b> = Entrepreneurial Skills, <b>C5</b> = Ethics & Professionalism</span>
</td>
</tr>';
	$this->html .= $html;

	}
	
	public function transferable(){
		$wall = $this->wall;
		$col_label = $this->col_label + 70;;
		$col_num = 28;
		$col_last = 50;
		$col_content = $wall - $col_label - $col_last - $col_num;
		
		$transferables = $this->model->profile->transferables;
		$kira = count($transferables);
		$total = $kira > 3 ? $kira : 3;
		$arr_transfer = array();
		$x = 1;
		if($transferables){
			foreach($transferables as $transfer){
				$arr_transfer[$x] = $transfer->transferable->transferable_text_bi;
				$x++;
			}
		
		}
		$rowspan_num = $total + 4;
		$rowspan_desc = $total + 2;

	$html = '<tr>
<td width="'.$this->colnum.'" align="center" '.$this->border.' rowspan="'.$rowspan_num.'">9</td>
<td width="'.$wall.'" colspan="26" '.$this->border_not_bottom.'>Transferable Skills (if applicable)
</td>
</tr>';

$html .= '<tr>
<td width="'.$col_label.'" colspan="6" '.$this->border_right_left.' rowspan="'.$total.'"><i>(Skills learned in the course of study which can be useful and utilized in other settings)</i></td>
<td width="'.$col_num.'" '.$this->shade_light.' align="center">1</td>
<td width="'.$col_content.'" '.$this->border.' colspan="17">';

if(array_key_exists(1, $arr_transfer)){
	$html .= $arr_transfer[1];
}

$html .='</td>
<td width="'.$col_last.'" '.$this->border_right_left.' colspan="17"></td>
</tr>';

for($i=1;$i<=$total;$i++){
	if($i > 1){
		$html .= '<tr>
		<td width="'.$col_num.'" '.$this->shade_light.' align="center">'.$i.'</td>
		<td width="'.$col_content.'" '.$this->border.' colspan="17">';
		if(array_key_exists($i, $arr_transfer)){
			$html .= $arr_transfer[$i];
		}
		$html .= '</td><td width="'.$col_last.'" '.$this->border_right_left.' colspan="17"></td>
		</tr>';
	}
}

$span = $col_num + $col_content;
$html .= '<tr style="line-height:6px">
		<td width="'.$col_label.'" colspan="6" '.$this->border_left.'></td>
		<td width="'.$span.'"  colspan="18">Open-ended response (if any)';
		$html .= '</td><td width="'.$col_last.'" '.$this->border_right.' colspan="17"></td>
		</tr>';
//open 
$trans_text = $this->model->profile->transfer_skill_bi;
$html .= '<tr>
		<td width="'.$col_label.'" colspan="6" '.$this->border_right_left.'></td>
		<td width="'.$col_num.'" '.$this->shade_light.' align="center">'.$i.'</td>
		<td width="'.$col_content.'" '.$this->border.' colspan="17">'.$trans_text;

		$html .= '</td><td width="'.$col_last.'" '.$this->border_right_left.' colspan="17"></td>
		</tr>';

	$html .= '<tr style="line-height:6px">
<td width="'.$wall.'" colspan="26" '.$this->border_not_top.'> 
</td>
</tr>';

$this->html .= $html;
	}
	
	public	$col_topic ;
	public	$col_clo;
	public	$col_learning ;
	public	$col_total_slt;
	public	$col_last ;
	public	$col_f2f ;
	public	$col_nf2f;
	public	$col_phy_online;
	public	$col_unit;
	public	$col_first;
	public $col_subtotal;
	public $col_week;
	public $col_topic_text;
	
	public function sltColums(){
		$wall = $this->wall;
		$this->col_topic = 225;
		$this->col_clo = 35;
		$this->col_learning = 300;
		$this->col_total_slt = 48;
		$this->col_last = 15;
		$this->col_f2f = 225;
		$this->col_nf2f = $this->col_learning - $this->col_f2f;
		$this->col_phy_online = $this->col_f2f / 2;
		$this->col_unit = $this->col_phy_online / 4;
		$this->col_first = $wall - $this->col_topic - $this->col_clo - $this->col_learning - $this->col_total_slt - $this->col_last;
		$this->col_subtotal = $this->col_topic + $this->col_clo + $this->col_learning;
		
		$this->col_week = 27;
		$this->col_topic_text = $this->col_topic - $this->col_week ;
	}
	
	public $count_week = 0;
	public $countSumAssess = 0;
	public $countContAssess = 0;
	
	public function sltHead(){
		$this->countSumAssess = count($this->model->courseAssessmentSummative);
		$this->countContAssess = count($this->model->courseAssessmentFormative);
		
		if($this->countSumAssess == 0){$this->countSumAssess = 1;}
		if($this->countContAssess == 0){$this->countContAssess = 1;}
		
		$this->count_week = count($this->model->syllabus);
		
		$rowspan_dy =  $this->count_week + $this->countContAssess + $this->countSumAssess;
		$rowspan_fix = 18;
		$rowspan_all = $rowspan_dy + $rowspan_fix;
		$rowspan_num = $rowspan_all + 4;
		
		$rowspan_topic = 4;
		$style_head = 'style="background-color:#e7e6e6; border: 1px solid #000000;line-height:9"';
		
		$html = '<tr>
		<td width="'.$this->colnum.'" align="center" '.$this->border.' rowspan="'.$rowspan_num .'">10</td>
		<td width="'.$this->wall.'" colspan="26" '.$this->border_not_bottom .'>Distribution of Student Learning Time (SLT)
		<br />Note: This SLT calculation is designed for home grown programme only.
		<br />
		</td>
		</tr>';
		
		
		$html .= '<tr align="center">
		
		
		<td width="'.$this->col_first.'" '.$this->border_right_left.' rowspan="'.$rowspan_all.'"></td>
		
		<td width="'.$this->col_topic.'" '.$style_head .' colspan="7" rowspan="'.$rowspan_topic.'">Course Content Outline and Subtopics</td>
		<td width="'.$this->col_clo.'" '.$style_head.' colspan="2" rowspan="'.$rowspan_topic.'">CLO*</td>
		<td width="'.$this->col_learning.'" '.$this->shade_light.' colspan="11">Learning and Teaching Activities**</td>
		<td width="'.$this->col_total_slt.'" '.$style_head.' colspan="3" rowspan="'.$rowspan_topic.'">Total SLT</td>
		<td width="'.$this->col_last.'" '.$this->border_right_left.' colspan="2" rowspan="'.$rowspan_all.'"></td>
		</tr>';
		
		$html .= '<tr align="center">
		
		


		<td width="'.$this->col_f2f.'" '.$this->shade_light.' colspan="8">Face-to-Face (F2F)</td>
		<td width="'.$this->col_nf2f.'" '.$this->shade_light.' colspan="3" rowspan="3">NF2F
	Independent Learning
	(Asynchronous)</td>
		
		</tr>';
		
		$html .= '<tr align="center">
		
		


		<td width="'.$this->col_phy_online.'" '.$this->shade_light.' colspan="4">Physical</td>
		<td width="'.$this->col_phy_online.'" '.$this->shade_light.' colspan="4">Online/ Technology-mediated (Synchronous)</td>
		
		
		</tr>';
		
		$html .= '<tr align="center">
		
	


		<td width="'.$this->col_unit.'" '.$this->shade_light.'>L</td>
		<td width="'.$this->col_unit.'" '.$this->shade_light.'>T</td>
		<td width="'.$this->col_unit.'" '.$this->shade_light.'>P</td>
		<td width="'.$this->col_unit.'" '.$this->shade_light.'>O</td>
		<td width="'.$this->col_unit.'" '.$this->shade_light.'>L</td>
		<td width="'.$this->col_unit.'" '.$this->shade_light.'>T</td>
		<td width="'.$this->col_unit.'" '.$this->shade_light.'>P</td>
		<td width="'.$this->col_unit.'" '.$this->shade_light.'>O</td>
		
		
		</tr>';
		
		

		$this->html .= $html;
		
	}
	
	public $sub_total_syll = 0;
	public $slt_physical = 0;
	public $slt_online_ind = 0;
	public $slt_practical_physical = 0;
	public $slt_practical_online = 0;
	
	public function sltSyllabus(){
		if($this->model->syllabus ){
		$week_num = 1;
		$k = 1;
		foreach($this->model->syllabus as $row){
			if($row->duration > 1){
				$end = $week_num + $row->duration - 1;
				$show_week = $week_num . '<br/>-<br />' . $end;
			}else{
				$show_week = $week_num;
			}
			$week_num = $week_num + $row->duration;
			$arr_all = json_decode($row->topics);
			$topic = '';
			if($arr_all){
				$i = 1;
				$topic .= '<table><tr><td width="93%">';
				foreach($arr_all as $rt){
					$wk = $i == 1 ? $row->week_num . ".  " : '';
					$br = $i == 1 ? '' : "<br />";
					$topic .= $br . $rt->top_bi;
					
					if($rt->sub_topic){
					$topic .= '<br/><table>';
						foreach($rt->sub_topic as $rst){
						$topic .='<tr><td width="5%">- </td><td width="95%">' . $rst->sub_bi . '</td></tr>';
						}
					$topic .='</table>';
					}
				$i++;
				}
				$topic .= '</td></tr></table>';
			}
			
			$clo = json_decode($row->clo);
			$clo_str="";
			
			if($clo){
				$kk=1;
				foreach($clo as $clonum){
					$comma = $kk == 1 ? "" : "<br />";
					$clo_str .= $comma. 'CLO'.$clonum;
					$kk++;
				}
			}
			
			$this->slt_physical += array_sum([$row->pnp_lecture, $row->pnp_tutorial, $row->pnp_practical, $row->pnp_others]);
			$this->slt_online_ind += array_sum([$row->tech_lecture, $row->tech_tutorial, $row->tech_practical, $row->tech_others, 
			$row->independent]);
			$this->slt_practical_physical += $row->pnp_practical;
			$this->slt_practical_online += $row->tech_practical;
			
			$numbers = [$row->pnp_lecture, $row->pnp_tutorial, $row->pnp_practical, $row->pnp_others, 
			$row->tech_lecture, $row->tech_tutorial, $row->tech_practical, $row->tech_others, 
			$row->independent];
			$this->sub_total_syll += array_sum($numbers);
			
			$this->sltSyllabusItem($k, $show_week, $topic, $clo_str, $numbers);
			
		$k++;
		}
		}
		
		
		$html = '<tr>
		
		
		<td width="'.$this->col_subtotal.'" '.$this->border .' align="right" colspan="20"><b>SUB-TOTAL SLT:</b></td>
		
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center">'.$this->sub_total_syll.'</td>
		
		</tr>';
		$this->html .= $html;
		
	}
	
	
	
	public function sltSyllabusItem($k, $show_week, $topic, $clo_str, $numbers){
		
		
		$html = '<tr>
		
		
		<td width="'.$this->col_week.'" '.$this->border .' align="center">'.$show_week.'</td>
		<td width="'.$this->col_topic_text.'" '.$this->border .' colspan="6">'.$topic.'</td>
		<td width="'.$this->col_clo.'" '.$this->border.' colspan="2" align="center">'.$clo_str.'</td>

		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[0].'</td>
		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[1].'</td>
		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[2].'</td>
		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[3].'</td>
		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[4].'</td>
		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[5].'</td>
		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[6].'</td>
		<td width="'.$this->col_unit.'" '.$this->border.' align="center">'.$numbers[7].'</td>
		
		<td width="'.$this->col_nf2f.'" '.$this->border.' colspan="3" align="center">'.$numbers[8].'</td>';
		
		
		if($k == 1){
			$html .='<td width="'.$this->col_total_slt.'" '.$this->shade_light.' colspan="3" rowspan="'.$this->count_week .'"></td>';
		}
		
	
		$html .=' </tr>';
		$this->html .= $html;
	}
	
	public $total_cont_assess = 0;
	
	public function sltContAssessHead(){
		$rowspan_topic = 3;
		$style_head = 'style="background-color:#e7e6e6; border: 1px solid #000000;line-height:5"';
		

		
		$html = '<tr align="center">
	
	
		<td width="'.$this->col_topic.'" '.$style_head .' colspan="7" rowspan="2">Continous Assessement</td>
		<td width="'.$this->col_clo.'" '.$style_head.' colspan="2" rowspan="2">%</td>

		<td width="'.$this->col_f2f.'" '.$this->shade_light.' colspan="8">Face-to-Face (F2F)</td>
		<td width="'.$this->col_nf2f.'" '.$this->shade_light.' colspan="3" rowspan="2">NF2F
	Independent Learning
	(Asynchronous)</td>';
	
	$rowspan_assess = $this->countContAssess + 2;
	
	$html .= '<td width="'.$this->col_total_slt.'" '.$style_head.' colspan="3" rowspan="'.$rowspan_assess.'"></td>
		</tr>';
		$html .= '<tr align="center">
		<td width="'.$this->col_phy_online.'" '.$this->shade_light.' colspan="4">Physical</td>
		<td width="'.$this->col_phy_online.'" '.$this->shade_light.' colspan="4">Online/ Technology-mediated (Synchronous)</td>
		
	
		</tr>';
		$this->html .= $html;
		
		
		if($this->model->courseAssessmentFormative){
			$i = 1;
			foreach($this->model->courseAssessmentFormative as $rf){
					$per = $rf->as_percentage + 0;
					$f2f = $rf->assess_f2f;
					$tech = $rf->assess_f2f_tech;
					$nf2f = $rf->assess_nf2f;
					$numbers = [$f2f, $tech, $nf2f];
					$this->total_cont_assess += array_sum($numbers);
					$name = $rf->assess_name_bi;
					$this->sltAssessItem($i, $name, $per, $numbers);
					$this->slt_physical +=  $rf->assess_f2f;
					$this->slt_online_ind += $rf->assess_f2f_tech + $rf->assess_nf2f;
			$i++;
			}
		}else{
			$data = ['','',''];
			$this->sltAssessItem(1, '', '', $data);
		}
		
		$html = '<tr>
	
	
		<td width="'.$this->col_subtotal.'" '.$this->border .' align="right" colspan="20"><b>SUB-TOTAL SLT:</b></td>
		
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center">'.$this->total_cont_assess.'</td>

		</tr>';

		
		$this->html .= $html;
	}
	
	public $total_sum_assess = 0;
	
	public function sltSumAssessHead(){
		$rowspan_topic = 3;
		$style_head = 'style="background-color:#e7e6e6; border: 1px solid #000000;line-height:5"';
		

		
		$html = '<tr align="center">
	
		
		<td width="'.$this->col_topic.'" '.$style_head .' colspan="7" rowspan="2">Final Assessement</td>
		<td width="'.$this->col_clo.'" '.$style_head.' colspan="2" rowspan="2">%</td>

		<td width="'.$this->col_f2f.'" '.$this->shade_light.' colspan="8">Face-to-Face (F2F)</td>
		<td width="'.$this->col_nf2f.'" '.$this->shade_light.' colspan="3" rowspan="2">NF2F
	Independent Learning
	(Asynchronous)</td>';
	
	$rowspan_assess = $this->countSumAssess + 2;
	
	$html .= '<td width="'.$this->col_total_slt.'" '.$style_head.' colspan="3" rowspan="'.$rowspan_assess.'"></td></tr>';
		
		
		
		$html .= '<tr align="center">
	
	


		<td width="'.$this->col_phy_online.'" '.$this->shade_light.' colspan="4">Physical</td>
		<td width="'.$this->col_phy_online.'" '.$this->shade_light.' colspan="4">Online/ Technology-mediated (Synchronous)</td>
		
		
		</tr>';
		$this->html .= $html;
		
		
		if($this->model->courseAssessmentSummative){
			$i = 1;
			foreach($this->model->courseAssessmentSummative as $rf){
					$per = $rf->as_percentage + 0;
					$f2f = $rf->assess_f2f;
					$tech = $rf->assess_f2f_tech;
					$nf2f = $rf->assess_nf2f;
					$numbers = [$f2f, $tech, $nf2f];
					$this->total_sum_assess += array_sum($numbers);
					$name = $rf->assess_name_bi;
					$this->sltAssessItem($i, $name, $per, $numbers);
					$this->slt_physical +=  $rf->assess_f2f;
					$this->slt_online_ind += $rf->assess_f2f_tech + $rf->assess_nf2f;
			$i++;
			}
		}else{
			$data = ['','',''];
			$this->sltAssessItem(1, '', '', $data);
		}
		
		$html = '<tr>
	
		
		<td width="'.$this->col_subtotal.'" style="border-bottom: 2px solid #002060;;border-right: 1px solid #000000;border-left: 1px solid #000000;border-top: 1px solid #000000" align="right" colspan="20"><b>SUB-TOTAL SLT:</b></td>
		
		<td width="'.$this->col_total_slt.'" style="color:#FFFFFF;font-weight:bold;background-color:#548235;border-bottom: 2px solid #002060;;border-right: 1px solid #000000;border-left: 1px solid #000000;border-top: 1px solid #000000" colspan="3" align="center">'.$this->total_sum_assess.'</td>
		
		</tr>';

		
		$this->html .= $html;
	}
	
	public function sltSummary(){
		
		$col_summary = $this->col_subtotal - $this->col_week;
		$total_slt_assess = $this->total_cont_assess + $this->total_sum_assess;
		$grand_total_slt = $total_slt_assess + $this->sub_total_syll;
		if($grand_total_slt == 0){
			$physical = 0;
			$online = 0;
			$prac_phy = 0;
			$prac_on = 0;
		}else{
			$physical = $this->slt_physical / $grand_total_slt * 100;
			$online = $this->slt_online_ind / $grand_total_slt * 100;
			$prac_phy = $this->slt_practical_physical / $grand_total_slt * 100;
			$prac_on = $this->slt_practical_online / $grand_total_slt * 100;
		}
		$online = round($online, 2) . '%';
		$physical = round($physical, 2) . '%';
		$practical_physical = round($prac_phy, 2) . '%';
		$practical_online = round($prac_on, 2) . '%';
		$practical_all = $prac_phy + $prac_on;
		$practical_all = round($practical_all, 2) . '%';
		
		$html = '<tr>
	
		
		<td width="'.$this->col_subtotal.'" style="border-top: 2px solid #002060;;border-right: 1px solid #000000;border-left: 1px solid #000000;border-bottom: 1px solid #000000" align="right" colspan="20"><b>SLT for Assessment:</b></td>
		<td width="'.$this->col_total_slt.'" style="color:#FFFFFF;font-weight:bold;background-color:#548235;border-top: 2px solid #002060;;border-right: 1px solid #000000;border-left: 1px solid #000000;border-bottom: 1px solid #000000" colspan="3" align="center">'.$total_slt_assess.'</td>
	
		</tr>';
		
		$html .= '<tr>
		
		<td width="'.$this->col_subtotal.'" '.$this->border .' align="right" colspan="20"><b>GRAND TOTAL SLT:</b></td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center">'.$grand_total_slt.'</td>
		
		</tr>';
		
		$html .= '<tr>

		
		<td width="'.$this->col_week.'" '.$this->border.' align="center">A</td>
		<td width="'.$col_summary.'" '.$this->border .' align="right" colspan="20">% SLT for F2F Physical Component:<br />
		<span style="'.$this->font_blue.'">[Total F2F Physical /(Total F2F Physical + Total F2F Online + Total Independent Learning) x 100)]</span>
		</td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center">'. $physical .'</td>
		
		</tr>';
		
		$html .= '<tr>
	
		<td width="'.$this->col_week.'" '.$this->border.' align="center">B</td>
		<td width="'.$col_summary.'" '.$this->border .' align="right" colspan="20">% SLT for Online & Independent Learning Component:<br />
		<span style="'.$this->font_blue.'">[(Total F2F Online + Total Independent Learning) /( Total F2F Physical + Total F2F Online + Total Independent Learning) x 100]</span>
		</td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center">'.$online.'</td>
	
		</tr>';
		
		$html .= '<tr>
	
		<td width="'.$this->col_week.'" '.$this->border.' align="center">C</td>
		<td width="'.$col_summary.'" '.$this->border .' align="right" colspan="20">% SLT for All Practical Component:<br />
		<span style="'.$this->font_blue.'">[% F2F Physical Practical + % F2F Online Practical]</span>
		</td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center">'. $practical_all  .'</td>
		
		</tr>';
		
		$html .= '<tr>
		
		<td width="'.$this->col_week.'" '.$this->border_not_bottom.' align="center">C1</td>
		<td width="'.$col_summary.'" '.$this->border .' align="right" colspan="20">% SLT for F2F Physical Practical Component:<br />
		<span style="'.$this->font_blue.'">[Total F2F Physical Practical /( Total F2F Physical + Total F2F Online + Total Independent Learning)  x 100)]</span>
		</td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center">'.$practical_physical.'</td>
		
		</tr>';
		
		$html .= '<tr>
	
		<td width="'.$this->col_week.'" '.$this->border_not_top.' align="center">C2</td>
		<td width="'.$col_summary.'" '.$this->border .' align="right" colspan="20">% SLT for F2F Online Practical Component:<br />
		<span style="'.$this->font_blue.'">[Total F2F Online Practical / (Total F2F Physical + Total F2F Online + Total Independent Learning) x 100]</span>
		</td>
		<td width="'.$this->col_total_slt.'" '.$this->shade_green.' colspan="3" align="center">'.$practical_online.'</td>
		
		</tr>';
		
		$html .= '<tr>
		<td width="'.$this->wall.'" '.$this->border_right_left .' colspan="25"></td>
		</tr>';
		
		if($this->model->slt->is_practical == 1){
			$tick_prac = '√';
		}else{
			$tick_prac = '';
		}
		$html .= '<tr>
		<td width="'.$this->col_first.'" '.$this->border_left.'></td>
		<td width="'.$this->col_subtotal.'" style="'.$this->font_brown.'" colspan="20">Please  tick (√) if this course is Industrial Industrial Training/ Clinical Placement/ Practicum using 50% of Effective Learning Time (ELT)</td>
		<td width="'.$this->col_total_slt.'" style="border:1.5px solid #000000" colspan="3" align="center"><span style="font-size:12px;"><span>'.$tick_prac.'</span></span></td>
		<td width="'.$this->col_last.'" '.$this->border_right_left.' colspan="2"></td>
		</tr>';
		
		$col_note = $this->col_subtotal + $this->col_total_slt;
		$html .= '<tr>
		<td width="'.$this->col_first.'" '.$this->border_left_bottom.'></td>
		<td width="'.$col_note.'" '.$this->border_bottom .' colspan="21">Note:<br />
		* Indicate the CLO based on the CLO\'s numbering in Item 8<br />
		** For ODL programme: Courses with mandatory practical requiremnets imposed by the programme standards or any related standards can be exempted from complying to the minimum 80% ODL delivery rule in the SLT.
		
		</td>
	
		<td width="'.$this->col_last.'" '.$this->border_right_bottom.' colspan="2"></td>
		</tr>';

		
		$this->html .= $html;
	}
	
	public function sltAssessItem($i, $name, $per, $numbers){
		$html = '<tr>
	
		<td width="'.$this->col_week.'" '.$this->border .' align="center">'.$i.'</td>
		<td width="'.$this->col_topic_text.'" '.$this->border .' colspan="6">'.$name.'</td>
		<td width="'.$this->col_clo.'" '.$this->border.' colspan="2" align="center">'.$per.'</td>
		<td width="'.$this->col_phy_online.'" '.$this->border.' align="center" colspan="4">'.$numbers[0].'</td>
		<td width="'.$this->col_phy_online.'" '.$this->border.' align="center" colspan="4">'.$numbers[1].'</td>
		<td width="'.$this->col_nf2f.'" '.$this->border.' colspan="3" align="center">'.$numbers[2].'</td>
		
		</tr>';
		
		$this->html .= $html;
	}
	
	public $col_label_end;
	public $col_content_end;
	
	public function specialRequirement(){
		$this->col_label_end = 190;
		$this->col_content_end = $this->wall - $this->col_label_end;
		$html = '<tr>
		<td width="'.$this->colnum.'" align="center" '.$this->border.'>11</td>
		<td width="'.$this->col_label_end.'" colspan="8" '.$this->border.'>Identify special requirement or resources to deliver the course (e.g., software, nursery, computer lab, simulation room etc)</td>
		<td width="'. $this->col_content_end .'" colspan="18" '.$this->border.'>'. $this->model->profile->requirement_bi .'</td>
		</tr>';
		
	$this->html .= $html;
	
	}
	
	public function references(){
		
		$i = 1;
		$ref='';
		if($this->model->mainReferences){
			
			$ref .= '<table>';
			foreach($this->model->mainReferences as $row){
				$ref .='<tr>';
				$ref .='<td width="3%">'.$i.'. </td>';
				$ref .='<td width="97%">'.$row->formatedReference.'</td>';
				$ref .='</tr>';
			$i++;
			}
			$ref .= '</table>';
		}

		if($this->model->additionalReferences){
			$ref .= '<table>';
			foreach($this->model->additionalReferences as $row){
				$ref .='<tr>';
				$ref .='<td width="3%">'.$i.'. </td>';
				$ref .='<td width="97%">'.$row->formatedReference.'</td>';
				$ref .='</tr>';
			$i++;
			}
			$ref .= '</table>';
		}
		
		$this->col_label_end = 190;
		$this->col_content_end = $this->wall - $this->col_label_end;
		$html = '<tr>
		<td width="'.$this->colnum.'" align="center" '.$this->border.'>12</td>
		<td width="'.$this->col_label_end.'" colspan="8" '.$this->border.'>References (include required and further readings, and should be the most current)</td>
		<td width="'. $this->col_content_end .'" colspan="18" '.$this->border.'>'. $ref .'</td>
		</tr>';
		
	$this->html .= $html;
	
	}
	
	public function additionalInfomation(){
		$this->col_label_end = 190;
		$this->col_content_end = $this->wall - $this->col_label_end;
		$html = '<tr>
		<td width="'.$this->colnum.'" align="center" '.$this->border.'>13</td>
		<td width="'.$this->col_label_end.'" colspan="8" '.$this->border.'>Other additional information (if applicable)</td>
		<td width="'. $this->col_content_end .'" colspan="18" '.$this->border.'>'. $this->model->profile->additional_bi .'</td>
		</tr>';
		
	$this->html .= $html;
	}
	
	public function preparedBy(){
		//echo Yii::$app->params['faculty_id'];die();
		if(Yii::$app->params['faculty_id'] == 1){
		$coor = '';
		$verifier = '';
		$date = '';
		$datev = '';
		$faculty = '';
		if($this->model->status >=20){
			$faculty = Faculty::findOne(Yii::$app->params['faculty_id']);
			$faculty = $faculty->faculty_name_bi;
		}
		
		if($this->model->preparedBy){
			$coor = $this->model->preparedBy->staff->niceName;
		}
		if($this->model->verifiedBy){
			$verifier = $this->model->verifiedBy->staff->niceName;
		}
		if($this->model->prepared_at != '0000-00-00'){
			$date = date('d/m/Y', strtotime($this->model->prepared_at));
		}
		if($this->model->verified_at != '0000-00-00'){
			$datev = date('d/m/Y', strtotime($this->model->verified_at));
		}
		$col_sign = ($this->wall /2 ) - $this->colnum;
		
		if($this->model->status >= 10){
			$html = '<table >
		<tr>
		<td width="'.$this->colnum.'"></td>
		
		<td width="'.$col_sign .'" colspan="18" style="font-size:12px">Prepared by:
		<br /><br /><br /> 
___________________________<br />
		'.$coor.'
		<br /> Course Owner
		<br /> '.$this->model->course->course_code.'
		<br /> '.$this->model->course->course_name_bi.'
		<br /> '.$date.'
		
		</td>
		<td width="'.$this->colnum.'"></td>
		<td width="'.$col_sign .'" colspan="18" style="font-size:12px">';
		if($this->model->status >= 20){
			$html .= 'Approved by:
		<br /><br /><br /> 
		___________________________<br />
				'.$verifier.'
				<br /> '.$this->model->verifier_position.'
				<br /> '.$faculty.'
				<br /> '.$datev;
		}
		
		
		
		
		
		$html .= '</td>
		
		</tr></table>';
		}else{
			$html = '';
		}
			
		
		
		$tbl = <<<EOD
		$html
EOD;

		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		}
	}
	
	public function signiture(){
		if(Yii::$app->params['faculty_id'] == 1){
					if($this->model->status > 9){
			$sign = $this->model->preparedsign_file;

			$file = Yii::getAlias('@upload/'. $sign);
			$f = basename($file);
			$paste = 'images/temp/'. $f;
			
			copy($file, $paste);

			$y = $this->pdf->getY();
			$this->verify_y = $this->pdf->getY();
			
			
			$adjy = $this->model->prepared_adj_y;
			
			$posY = $y - 40 - $adjy;
			$this->pdf->setY($posY);
			
			
			$size = 100 + ($this->model->prepared_size * 3);
			if($size < 0){
				$size = 10;
			}
			
			$col1 = $this->colnum + 10;
			$col_sign = $this->wall /2 ;
			$html = '<table>

			
			<tr>
			<td width="'. $col1 .'"></td>
			
			<td width="'.$col_sign .'" colspan="18" >';
			if($this->model->preparedsign_file){
				if(is_file($file)){
					$html .= '<img width="'.$size.'" src="images/temp/'.$f.'" />';
				}
			}
			
			$html .= '</td>
			<td width="'.$col_sign .'" colspan="18" >';
			

			
			$html .= '</td>
			
			</tr></table>';
		
		
			
			
$tbl = <<<EOD
$html
EOD;

			$this->pdf->writeHTML($tbl, true, false, false, false, '');
		}
		}

		
	}
	
	public $verify_y;
	
	public function signitureVerify(){
		if(Yii::$app->params['faculty_id'] == 1){
		if($this->model->status > 19){
			$sign = $this->model->verifiedsign_file;

		$file = Yii::getAlias('@upload/'. $sign);
		$f = basename($file);
		$paste = 'images/temp/'. $f;
		
		copy($file, $paste);
		
		
		
		$y = $this->verify_y;
		
	
		$adjy = $this->model->verified_adj_y;
		
		$posY = $y - 40 - $adjy;
		$this->pdf->setY($posY);
		

		
		$size = 100 + ($this->model->verified_size * 3);
		if($size < 0){
			$size = 10;
		}
		//echo $size;die();
		$col1 = $this->colnum + 10;
		$col_sign = $this->wall /2 ;
		$html = '<table>

		
		<tr>
		<td width="'. $col1 .'"></td>
		
		<td width="'.$col_sign .'" colspan="18" >';

		
		$html .= '</td>
		<td width="'.$col_sign .'" colspan="18" >';
		
		if($this->model->verifiedsign_file){
			if(is_file($file)){
				$html .= '<img width="'.$size.'" src="images/temp/'.$f.'" />';
			}
		}
		
		$html .= '</td>
		
		</tr></table>';
		
		
		$tbl = <<<EOD
		$html
EOD;

		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		}
	}
		
	}
	
	
	
	
	
	
	public function htmlWriting(){
	$html = $this->html;
	$html .= '</table>';
	//echo $html;die();
		$this->pdf->SetFont('calibri', '', $this->font_size); // 8
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
		$this->pdf->SetMargins(12, 15, 12);
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
		$this->pdf->lineHeaderTable = false;
	}
	
	
}
