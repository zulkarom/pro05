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
	
	public $team = array();
	
	public function generatePdf(){

		$this->directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
		
		$this->pdf = new Fk2Start(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$this->pdf->SetFont("arialnarrow", '', 11);
		$this->writeHeaderFooter();
		
		$this->startPage();
		
		
		$this->doBody();

		$this->pdf->Output('TABLE 4 - '.$this->model->course->course_code .'.pdf', 'I');
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
		<td width="120"><div align="right"></div></td>
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
		<td width="125"><div align="right" style="font-size:11pt;">MQF 2.0 TABLE 4</div></td>
		</tr>
		 </table>';
		 
		$tabin = '<table border="1" cellpadding="1">
		 <tr><td>'.$tabin2.'</td></tr>
		 </table>';
		 
		 $html ='<table border="1" width="'.$wtab.'" cellpadding="5">
		 <tr><td>'.$tabin.'</td></tr>
		 </table>
		 <br />
		 ';
		
		
		$this->pdf->SetFont('arialnarrow', '', 10);
		$tbl = <<<EOD
$html
EOD;
		$this->pdf->writeHTML($tbl, true, false, false, false, '');
		

// ---------------------------------------------------------


		$html = "";



//$this->pdf->SetFont('helvetica', '', 10);

$colnum = 35;
$colcontent = $wtab - $colnum;

$html .='<br /><table border="1" width="'.$wtab.'" cellpadding="7">

<thead>

</thead>

<tr>
<td width="'.$colnum.'"><b>1. </b></td>
<td width="'.$colcontent.'"><b>Name and Code of Course: </b>'.$this->model->course->course_name_bi .' ('.$this->model->course->course_code .')</td>
</tr>

<tr>
<td><b>2.</b> </td>
<td><b>Synopsis: </b> '.$this->model->profile->synopsis_bi .'</td>
</tr>

<tr>
<td><b>3. </b></td>
<td><b>Name(s) of academic staff:</b><br />';
/* $staff = $this->staff;
if($staff){
	$x=1;
	foreach($staff as $rs){
		$comma = $x == 1 ? "" : ", " ;
		$html .= $comma . $rs->staff_name;
	$x++;
	}
} */
$pre = $this->model->profile->coursePrerequisite;
$html .= '</td>
</tr>

<tr>
<td><b>4. </b></td>
<td><b>Semester and Year Offered:</b> </td>
</tr>

<tr>
<td><b>5. </b></td>
<td><b>Credit Value:</b> '.$this->model->course->credit_hour .' </td>
</tr>

<tr>
<td><b>6. </b></td>
<td><b>Prerequisite/co-requisite (if any):</b> '.$pre[1].'</td>
</tr>

<tr>
<td><b>7. </b></td>
<td><b>Course Learning Outcome (CLO):</b>';

if($this->model->clos){
	$html .= '<br /><table>';
	$i=1;
	foreach($this->model->clos as $c){
	$html .='<tr>';	
	$html .='<td width="50">CLO'.$i.' - </td>';	
	$html .='<td>'.$c->clo_text_bi .'</td>';	
	$html .='</tr>';
	$i++;	
	}
	$html .='</table>'; 
}



$html .= '</td>
</tr>

<tr>
<td><b>8. </b></td>
<td><b>Mapping of the Course Learning Outcome to the Programme Learning Outcome, Teaching Methods and Assessment:</b><br /><br />';

$total = $colcontent - 15;
$col1 = 80;
$col2 = 220;
$col5 = 130;
$col6 = $total - $col1 - $col2 - $col5;

$html .='
<table border="1" cellpadding="8" style="font-size:10px;">
<tr style="font-weight:bold">
<td align="center" width="'.$col1.'" rowspan="2">
Course Learning Outdome (CLOs)
</td>

<td width="'.$col2.'" align="center" colspan="8">
Programme Learning Outcome (PLO)</td>

<td width="'.$col5.'" align="center" rowspan="2">
Teaching Methods
</td>
<td width="'.$col6.'" align="center" rowspan="2">
Assessment
</td>
</tr>';
$plo_num = $this->model->ploNumber;
$html .='<tr>';
for($e=1;$e<=$plo_num;$e++){
	$html .= '<td align="center">
PLO'.$e.'</td>';
}


$html .= '</tr>';


$col1d1 = 50;
$col1d2 = $col1 - $col1d1;
$x=1;
foreach($this->model->clos as $clo){
	$html .='
<tr>
<td align="center">CLO'.$x.'</td>';

for($e=1;$e<=$plo_num;$e++){
	$plo_str = 'PLO'.$e;
	$html .='<td align="center">';
	if($clo->{$plo_str} == 1){
		$html .= '<span style="font-size:14px;font-family:zapfdingbats"><span>3</span></span>';
	}
	$html .= '</td>';
}


//$html .='</td>';
$html .='<td align="left">';
$s=1;
if($clo->cloDeliveries){
$html .='<table border="0">';
foreach($clo->cloDeliveries as $row){
	$sp = $s == 1 ? "" : "<br />" ;
	$html .= '<tr>';
	$html .= '<td width="5%">- </td>';
	$html .= '<td width="95%">';
	$html .= $row->delivery->delivery_name_bi ;
	$html .= '</td>';
	$html .= '</tr>';
$s++;
}
$html .='</table>';
}

$html .='</td>
<td align="left">';
$s=1;
if($clo->cloAssessments){
$html .='<table border="0">';
foreach($clo->cloAssessments as $row){
	$sp = $s == 1 ? "" : "<br />" ;
	$html .= '<tr>';
	$html .= '<td width="5%">- </td>';
	$html .= '<td width="95%">';
	$html .= $row->assessment->assess_name_bi ;
	$html .= '</td>';
	$html .= '</tr>';
$s++;
}
$html .='</table>';
}
$html .='</td>
</tr>';
$x++;
}


$html .='
</table>
';
$html .='<br /><br />Indicate the primary causal link between the CLO and PLO by ticking "<span style="font-size:12px;font-family:zapfdingbats"><span>3</span></span>" the appropriate box.<br />
(This description must be read together with Standards 2.1.2, 2.2.1 and 2.2.2 in Area 2 - pages 16 & 18.)
';

$html .= '</td>
</tr>

<tr>
<td><b>9. </b></td>
<td>
<b>Transferable Skills (if applicable):</b>
<br />
'. $this->model->profile->transfer_skill_bi .'
</td>
</tr>

<tr>
<td><b>10.</b> </td>
<td>';


$html .='
<b>Distribution of Student Learning Time (SLT):</b>
<br /><br />';
$tab_syl = $wtab - 48;
$htopic = 250;
$hclo = 40;
$hslt = $tab_syl - $htopic - $hclo;
$depend = 30;
$dep_all = $depend * 4;
$gui = 63;
$ind = 73;
$flex = $hslt - $dep_all - ($ind + $gui);

$html .='<table border="1" cellpadding="5" style="font-size:10px;">
<tr nobr="true">
<th width="'.$htopic.'" rowspan="3" align="center"><b>Course Content Outline</b></th>
<th width="'.$hclo.'" rowspan="3" align="center"><b>CLO*</b></th>
<th width="'.$hslt.'" colspan="7" align="center"><b>Teaching and Learning Activities</b></th>
</tr>
<tr nobr="true">
<th colspan="4" width="'.$dep_all.'" align="center"><b>Guided Learning<br />(F2F)</b></th>
<th rowspan="2" width="'.$gui.'" align="center"><b>Guided Learning<br />(NF2F)</b></th>
<th rowspan="2" width="'.$ind.'" align="center"><b>Independent Learning (NF2F)</b></th>
<th rowspan="2" width="'.$flex.'" align="center"><b>Total SLT</b></th>
</tr>
<tr>';
$html .= '<th align="center"><b>L</b></th>
<th align="center"><b>T</b></th>
<th align="center"><b>P</b></th>
<th align="center"><b>O</b></th>
</tr>

';

$tlec = 0;
$ttut = 0;
$tprac =0;
$toth = 0;
$tind = 0;
$tass = 0;
$tgrand = 0;
foreach($this->model->syllabus as $row){
	$html .='<tr nobr="true">';
	$html .='<td>';
	$arr_all = json_decode($row->topics);
	if($arr_all){
	foreach($arr_all as $rt){
		$html .= "<strong>".$row->week_num . ".  ". $rt->top_bi . "</strong>";
		
		if($rt->sub_topic){
		$html .= '<br/><table>';
			foreach($rt->sub_topic as $rst){
			$html .='<tr><td width="5%">- </td><td width="95%">' . $rst->sub_bi . '</td></tr>';
			}
		$html .='</table>';
		}
	}
	}
	$html .='</td>';
	$clo = json_decode($row->clo);
	$str="";
	if($clo){
		$kk=1;
		foreach($clo as $clonum){
			$comma = $kk == 1 ? "" : ", ";
			$str .= $comma. $clonum;
			$kk++;
		}
	}
	$html .= '<td align="center">'.$str.'</td>';
	$html .='<td style="vertical-align: middle;text-align:center">'.$row->pnp_lecture .'</td>';
	$html .='<td style="vertical-align: middle;text-align:center">'.$row->pnp_tutorial .'</td>';
	$html .='<td style="vertical-align: middle;text-align:center">'.$row->pnp_practical .'</td>';
	$html .='<td style="vertical-align: middle;text-align:center">'.$row->pnp_others .'</td>';
	$html .='<td style="vertical-align: middle;text-align:center">'.$row->nf2f .'</td>';
	$html .='<td style="vertical-align: middle;text-align:center">'.$row->independent .'</td>';
	$sub = $row->pnp_lecture + $row->pnp_tutorial + $row->pnp_practical + $row->pnp_others + $row->independent + $row->nf2f;
	$html .='<td style="vertical-align: middle;text-align:center"><b>'.$sub.'</b></td>';
	$html .='</tr>';
	$tlec += $row->pnp_lecture;
	$ttut += $row->pnp_tutorial;
	$tprac += $row->pnp_practical;
	$toth += $row->pnp_others;
	$tind += $row->nf2f;
	$tass += $row->independent;
	$tgrand +=$sub;
		
}


	
	
	
	$html .='<tr>';
	$html .='<td colspan="2" align="center">';
		$html .= '<b>Total</b>';
	$html .='</td>';
	$html .='<td align="center"><b>'.$tlec.'</b></td>';
	$html .='<td align="center"><b>'.$ttut .'</b></td>';
	$html .='<td align="center"><b>'.$tprac.'</b></td>';
	$html .='<td align="center"><b>'.$toth.'</b></td>';
	$html .='<td align="center"><b>'.$tind.'</b></td>';
	$html .='<td align="center"><b>'.$tass.'</b></td>';
	$html .='<td align="center"><b>'.$tgrand.'</b></td>';
	$html .='</tr>';
	
	$html .='<tr>
	<td colspan="9"></td>
	</tr>';
	
	$html .='<tr style="font-weight:bold">
	<td align="center">Continuous Assessment</td>

	<td colspan="5" align="center">Percentage (%)</td>
	<td align="center">F2F</td>
	<td align="center">NF2F</td>
	<td align="center">Total SLT</td>
	</tr>';
	
	//array
	
	
	$i=1;
	$total = 0;
	if($this->model->courseAssessmentFormative){
	$slt_assess = 0;
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
			<td>'.$i.'. '.$rf->assess_name_bi .'</td>
			<td colspan="5" align="center">'. $per .'</td>
			<td align="center">'.$f2f.'</td>
			<td align="center">'.$nf2f.'</td>
			<td align="center">'.$sub_total .'</td>
			</tr>';
			$total +=$per;
	$i++;
	}
	}
	
	$html .='<tr style="font-weight:bold">
	<td align="center">Final Assessment</td>
	<td colspan="5" align="center">Percentage (%)</td>
	<td align="center">F2F</td>
	<td align="center">NF2F</td>
	<td align="center">Total SLT</td>
	</tr>';
	
	if($this->model->courseAssessmentSummative){
		$i=1;
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
			<td>'.$i.'. '.$rf->assess_name_bi .'</td>
			<td colspan="5" align="center">'. $per .'</td>
			<td align="center">'.$f2f.'</td>
			<td align="center">'.$nf2f.'</td>
			<td align="center">'.$sub_total.'</td>
			</tr>';
			$total +=$per;
	$i++;
	}
	}
	
	$html .='<tr>
	<td colspan="9"></td>
	
	</tr>';
	$slt_semua = $tgrand + $slt_assess;
	$html .='<tr>
	<td colspan="8" align="center"><b>GRAND TOTAL SLT</b></td>
	<td><b>'.$slt_semua.'</b></td>
	</tr>';
	
$html .='</table>

<br/>
';
$wnote= 20;
$wnote2 = $tab_syl - $wnote;

$html .='
L = Lecture, T = Tutorial, P = Practical, O = Others, F2F = Face to Face, NF2F = Non Face to Face<br />
* Indicate the CLO based on the CLO\'s numbering in Item 8

<br />
';


$html .='</td>
</tr>

<tr>
<td><b>11. </b></td>
<td><b>Identify special requirement or resources to deliver the course:</b><br /> '.$this->model->profile->requirement .'</td>
</tr>

<tr>
<td><b>12. </b></td>
<td>

<b>Main References:</b><br />';
$total = $colcontent - 15;
$col1 = 15;
$col2 = $total - $col1;
if($this->model->mainReferences){
	$i = 1;
	$html .= '<table>';
	foreach($this->model->mainReferences as $row){
		$html .='<tr>';
		$html .='<td width="'.$col1.'">'.$i.'. </td>';
		$html .='<td width="'.$col2.'">'.$row->formatedReference.'</td>';
		$html .='</tr>';
	$i++;
	}
	$html .= '</table>';
}

$html .='<b>Additional References:</b><br />';

if($this->model->additionalReferences){
	$i = 1;
	$html .= '<table>';
	foreach($this->model->additionalReferences as $row){
		$html .='<tr>';
		$html .='<td width="'.$col1.'">'.$i.'. </td>';
		$html .='<td width="'.$col2.'">'.$row->formatedReference.'</td>';
		$html .='</tr>';
	$i++;
	}
	$html .= '</table>';
}






$html .= '<br />(References should be the most current)
</td>
</tr>


<tr>
<td><b>13. </b></td>
<td><b>Other additional information:</b> '.$this->model->profile->additional .'</td>
</tr>


</table>

';
$echohtml = $html;
$tbl = <<<EOD
$html
EOD;
$this->pdf->lineFooterTable = true;
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
