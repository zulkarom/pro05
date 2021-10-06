<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use richardfan\widget\JSRegister;


/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */


$this->title = 'Student Learning Time';
$this->params['breadcrumbs'][] = ['label' => 'Preview', 'url' => ['course/view-course', 'course' => $model->course_id, 'version' => $model->id]];
$this->params['breadcrumbs'][] = 'SLT';

$form = ActiveForm::begin(['id' => 'form-clo-assessment']); 
?>

<?=$this->render('_header',[
'course' => $model->course, 
    'version' => $model
])?>
<style>
.online{
	background-color:#f5f5f5
	text-align:center;
}
</style>
<div class="box box-primary">
<div class="box-header"></div>
<div class="box-body">


<div class='row'>
	<div class='col-md-12'>
	
	<table class='table table-hover table-striped'>
	<thead>
	<tr>
	<th width='1%' rowspan='3'>WEEK</th>
	<th rowspan='3' width="25%">TOPICS</th>
	
	<th colspan="8" style="text-align:center">FACE-TO-FACE (F2F)</th>
	
	<th rowspan="3"  style="vertical-align:bottom;text-align:center">
	NF2F<br />
	INDEPENDENT LEARNING<br />
	(ASYNCHRONOUS)
	
	</th>
	<th rowspan="3" style="vertical-align:bottom;text-align:center">TOTAL<br />SLT</th>
	
	</tr>
	
	<tr>
	
	<th style='text-align:center' colspan='4' >PHYSICAL
	
	</th>
	
	<th style="vertical-align:top;text-align:center; background-color:#f5f5f5" colspan="4">
	ONLINE/ TECHNOLOGY-MEDIATED <br />
	(SYNCHRONOUS)


	</th>
	
	
	</tr>
	
	<tr>
	
	<th style='text-align:center'>L</th><th style='text-align:center'>T</th><th style='text-align:center'>P</th><th style='text-align:center'>O</th>
	
	<th style='text-align:center;background-color:#f5f5f5'>L</th><th style='text-align:center;background-color:#f5f5f5'>T</th><th style='text-align:center;background-color:#f5f5f5'>P</th><th style='text-align:center;background-color:#f5f5f5'>O</th>
	
	
	</tr>
	</thead>
<?php 

$arr_syll = "";
$i=1;
$week_num = 1;
foreach($syll as $row){ ?>
	<tr>
	<td>
	<b><?php 
	$show_week = '';
	if($row->duration > 1){
		$end = $week_num + $row->duration - 1;
		$show_week = $week_num . ' - ' . $end;
	}else{
		$show_week = $week_num;
	}
	$arr_week[$week_num] = 'WEEK ' . $show_week;
	
	echo $show_week;
	
	$week_num = $week_num + $row->duration;
	
	
	
	
	?>
	
	</b>
	</td>
	<td>
	
		<?php 
		$arr_syll .= $i == 1 ? $row->id : ", " . $row->id ;
		$arr_all = json_decode($row->topics);
		if($arr_all){
		$n = 1;
		echo '<ul style="padding-left:5px">';
		foreach($arr_all as $rt){
			//$break = $n == 1 ? '': '<br/>';
			echo '<li>';
			echo "<strong>".$rt->top_bm ." / <i>". $rt->top_bi . "</i></strong>";
			if($rt->sub_topic){
			echo "<ul>";
				foreach($rt->sub_topic as $rst){
				echo "<li>".$rst->sub_bm . " / <i>" . $rst->sub_bi . "</i></li>";
				}
			echo "</ul>";
			echo '<li>';
			}
			$n++;
		} 
		echo '</ul>';
		} 
		?>
		
	</td>

	<td style="vertical-align:middle"><!-- LECTURE -->
	<input type="text" style="text-align:center" class="form-control tgsyl" name="syll[<?php echo $row->id;?>][pnp_lecture]" id="pnp_lecture_<?php echo $row->id;?>" value="<?php echo is_null($row->pnp_lecture) ? 0 : $row->pnp_lecture  ; ?>" />
	</td>
	<td style="vertical-align:middle"><!-- TUT -->
	<input type="text" style="text-align:center" class="form-control tgsyl" name="syll[<?php echo $row->id;?>][pnp_tutorial]" id="pnp_tutorial_<?php echo $row->id;?>" value="<?php echo is_null($row->pnp_tutorial) ? 0 : $row->pnp_tutorial ; ?>"  />
	</td>
	<td style="vertical-align:middle"><!-- PRACTICAL -->
	<input type="text" style="text-align:center" class="form-control tgsyl" name="syll[<?php echo $row->id;?>][pnp_practical]" id="pnp_practical_<?php echo $row->id;?>" value="<?php echo is_null($row->pnp_practical) ? 0 : $row->pnp_practical ; ?>"  />
	</td>
	
	<td style="vertical-align:middle">
	<input type="text" style="text-align:center" class="form-control tgsyl" name="syll[<?php echo $row->id;?>][pnp_others]" id="pnp_others_<?php echo $row->id;?>" value="<?php echo is_null($row->pnp_others) ? 0 : $row->pnp_others ; ?>"  />
	</td>
	

	
	<td style="vertical-align:middle;background-color:#f5f5f5">
	<input type="text" style="text-align:center" class="form-control tgsyl" name="syll[<?php echo $row->id;?>][tech_lecture]" id="tech_lecture_<?php echo $row->id;?>" value="<?php echo is_null($row->tech_lecture) ? 0 : $row->tech_lecture ; ?>"  />
	</td>
	
	<td style="vertical-align:middle;background-color:#f5f5f5">
	<input type="text" style="text-align:center" class="form-control tgsyl" name="syll[<?php echo $row->id;?>][tech_tutorial]" id="tech_tutorial_<?php echo $row->id;?>" value="<?php echo is_null($row->tech_tutorial) ? 0 : $row->tech_tutorial ; ?>"  />
	</td>
	<td style="vertical-align:middle;background-color:#f5f5f5">
	<input type="text" style="text-align:center" class="form-control tgsyl" name="syll[<?php echo $row->id;?>][tech_practical]" id="tech_practical_<?php echo $row->id;?>" value="<?php echo is_null($row->tech_practical) ? 0 : $row->tech_practical ; ?>"  />
	</td>
	<td style="vertical-align:middle;background-color:#f5f5f5">
	<input type="text" style="text-align:center" class="form-control tgsyl" name="syll[<?php echo $row->id;?>][tech_others]" id="tech_others_<?php echo $row->id;?>" value="<?php echo is_null($row->tech_others) ? 0 : $row->tech_others ; ?>"  />
	</td>
	
	
	
	<td style="vertical-align:middle">
	<input type="text" style="text-align:center" value="<?php echo is_null($row->independent) ? 0 : $row->independent ; ?>" name="syll[<?php echo $row->id;?>][independent]" id="independent_<?php echo $row->id;?>" class="form-control tgsyl" />
	</td>
	<td style="vertical-align:middle;text-align:center">
	<strong id="subsyll_<?php echo $row->id;?>">0</strong>
	<?php 
	/* $total = $row->assessment + $row->independent + $row->pnp_others + $row->pnp_practical + $row->pnp_tutorial + $row->pnp_lecture ;
	echo $total; */
	?>
</td>
	</tr>
<?php 
$i++;
}
?>
<tr style="text-align:center;font-weight:bold">
<td colspan="2"><b></b></td>
<td id="subsyll_pnp_lecture">0</td>
<td id="subsyll_pnp_tutorial">0</td>
<td id="subsyll_pnp_practical">0</td>
<td id="subsyll_pnp_others">0</td>
<td id="subsyll_tech_lecture">0</td>
<td id="subsyll_tech_tutorial">0</td>
<td id="subsyll_tech_practical">0</td>
<td id="subsyll_tech_others">0</td>
<td id="subsyll_independent">0</td>
<td id="subsyll_total">0</td>
</tr>

</table>
</div>
	</div>



</div>
	</div>

<div class="box box-success">
<div class="box-header"></div>
<div class="box-body">	

<div class="row">

<div class="col-md-12">

<table class="table table-striped table-hover">
<thead>
	<tr>
		<th rowspan="2" width="30%" style="vertical-align:bottom"><b>
		FORMATIVE ASSESSMENT
		</b></th>
		<th rowspan="2" style="vertical-align:bottom"><b>
		PERCENTAGE
		</b></th>
		<th width="40%" colspan="2" style="text-align:center"><b>FACE-TO-FACE(F2F)</b></th>
		<th width="20%" style="text-align:center" rowspan="2"><b>NF2F <br />
INDEPENDENT LEARNING FOR ASSESSMENT<br />
 (ASYNCHRONOUS)</b></th>
 
 <th style="text-align:center;vertical-align:bottom" rowspan="2"><b>TOTAL</b></th>
 
 
	</tr>
	
	<tr>
		
		<th style="text-align:center"><b>PHYSICAL</b></th>
		<th style="text-align:center"><b>ONLINE/<br /> TECHNOLOGY-MEDIATED (SYNCHRONOUS)

		</b></th>
		
		
		
	</tr>
	
	
</thead>
	
	<?php 
	

	$assdirect = $model->courseAssessmentFormative;
	$assindirect= $model->courseAssessmentSummative;
	
	$arrFormAss = "";
	$i=1;
	$total_per_fom = 0;
	if($assdirect){
		
		foreach($assdirect as $rhead){
			$id = $rhead->id;
			$total_per_fom += $rhead->as_percentage;
			$arrFormAss .= $i == 1 ? $id : "," . $id ;
			echo "<tr><td>".$rhead->assess_name ." / <i>".$rhead->assess_name_bi ."</i></td>
			<td align='center'>" . $rhead->as_percentage . "%</td>
			<td>
			<input class='form-control tgcal' name='assess[".$id . "]' id='form-ass-".$id . "' value='" . $rhead->assess_f2f . "' style='text-align:center' /></td>
			
			<td>
			<input class='form-control tgcal' name='assess_tech[".$id . "]' id='form-ass-tech-".$id . "' value='" . $rhead->assess_f2f_tech . "' style='text-align:center' /></td>
			
			<td>
			<input class='form-control tgcal' name='assess2[".$id . "]' id='form-ass2-".$id . "' value='" . $rhead->assess_nf2f . "' style='text-align:center' /></td>
			
			<td align='center'><b><span id='form-subtotal-".$id."'></span></b></td>
			</tr>
			";
		$i++;
		}
	}
	//".$rhead->slt->assess_f2f ."
	
	?>
	

	
	<tr>
	<td> <strong>TOTAL FORMATIVE</strong></td>
	<td style="text-align:center"><strong><?=$total_per_fom?>%</strong></td>
		<td style="text-align:center"><strong id="form-total-ass">0</strong></td>
		<td style="text-align:center"><strong id="form-total-ass-tech">0</strong></td>
		<td style="text-align:center"><strong id="form-total-ass2">0</strong></td>
		<td style="text-align:center"><strong id="form-total">0</strong></td>
	</tr>
	

	
</table>

<table class="table table-striped table-hover">
	

	
	<thead>
	<tr>
		<th rowspan="2" width="30%" style="vertical-align:bottom"><b>
		SUMMATIVE ASSESSMENT
		</b></th>
		<th rowspan="2" style="vertical-align:bottom"><b>
		PERCENTAGE
		</b></th>
		<th width="40%" colspan="2" style="text-align:center"><b>FACE-TO-FACE (F2F)</b></th>
		<th width="20%" style="text-align:center" rowspan="2"><b>NF2F <br />
		INDEPENDENT LEARNING FOR ASSESSMENT<br />
 (ASYNCHRONOUS)</b></th>
 
 <th style="text-align:center;vertical-align:bottom" rowspan="2"><b>TOTAL</b></th>
 
	</tr>
	
	<tr>
		
		<th style="text-align:center"><b>PHYSICAL</b></th>
		<th style="text-align:center"><b>ONLINE/<br /> TECHNOLOGY-MEDIATED (SYNCHRONOUS)

		</b></th>
</thead>

	<?php 
	$arrSumAss = "";
	$total_per_sum = 0;
	if($assindirect){
		foreach($assindirect as $rhead){
			$id = $rhead->id;
			$total_per_sum += $rhead->as_percentage;
			$arrSumAss .= $i == 1 ? $id : "," . $id ;
			echo "<tr><td>".$rhead->assess_name_bi ." / <i>".$rhead->assess_name_bi ."</i></td>
			<td align='center'>" . $rhead->as_percentage . "%</td>
			<td><input class='form-control tgcal' name='assess[".$id . "]' id='sum-ass-".$id . "' value='".$rhead->assess_f2f ."' style='text-align:center' /></td>
			
			<td><input class='form-control tgcal' name='assess_tech[".$id . "]' id='sum-ass-tech-".$id . "' value='".$rhead->assess_f2f_tech ."' style='text-align:center' /></td>
			
			
			<td><input class='form-control tgcal' name='assess2[".$id . "]' id='sum-ass2-".$id . "' value='".$rhead->assess_nf2f ."' style='text-align:center' /></td>
			
			<td align='center'><b><span id='sum-subtotal-".$id."'></span></b></td>
			</tr>
			";
			$i++;
		}
	}
	?>
	<tr>
	<td> <strong>TOTAL SUMMATIVE</strong>
	</td>
	<td style="text-align:center"><strong><?=$total_per_sum?>%</strong></td>
	
		<td style="text-align:center"><strong id="sum-total-ass">0</strong></td>
		<td style="text-align:center"><strong id="sum-total-ass-tech">0</strong></td>
		<td style="text-align:center"><strong id="sum-total-ass2">0</strong></td>
		

		<td style="text-align:center"><strong id="sum-total">0</strong></td>
	</tr>
	
	
	<tr><td colspan="5" align="right"><strong>SLT FOR ASSESSMENT</strong>
	</td>
		<td style="text-align:center"><strong id="jum-assess">0</strong></td>
	</tr>
	
	<tr><td colspan="5" align="right"><strong>GRAND TOTAL FOR SLT</strong>
	</td>
		<td style="text-align:center"><strong id="total-slt">0</strong></td>
	</tr>
	
	<tr>
	<td></td>
	<td colspan="4" align="right">
	<div class="form-group">
<div class="checkbox"><label for="is_practical">
<input type="hidden" name="is_practical" value="0">
<?php 
if($slt->is_practical == 1){
	$checked = 'checked';
}else{
	$checked = '';
}

?>
<input type="checkbox" id="is_practical" name="is_practical" value="1" <?=$checked?>>
Please tick if this course is Latihan Industri/ Clinical Placement/ <br />
Practicum/ WBL using Effective Learning Time(ELT) of 50%
</label>
<div class="help-block"></div>
</div>
</div>

	
	</td>
	</tr>
	
	<tr><td colspan="5" align="right"><strong>Generated Credit Hour by SLT</strong>
	<div id="slt-formula"></div>
	<div style="color:red;font-size:11px" id="slt-alert">
<span class="glyphicon glyphicon-alert"></span> Please make sure the generated Credit Hour equal to Credit Hour set for this course!
</div>
	</td>
		<td style="text-align:center"><strong><span id="hour-slt">?</span></strong></td>
	</tr>
	
	<tr><td colspan="5" align="right"><strong>Credit Hour set for this course</strong>
	</td>
		<td style="text-align:center"><strong><span id="hour-set"><?=$model->course->credit_hour?></span></strong></td>
	</tr>
	
	<tr><td colspan="5" align="right"><strong>% SLT for F2F Physical Component</strong>
	</td>
		<td style="text-align:center"><strong><span id="per-physical">0</span>%</strong></td>
	</tr>
	
	<tr><td colspan="5" align="right"><strong>% SLT for Online & Independent Learning Component</strong>
	</td>
		<td style="text-align:center"><strong><span id="per-online">0</span>%</strong></td>
	</tr>
	
	<tr><td colspan="5" align="right"><strong>% SLT for All Practical Component</strong>
	</td>
		<td style="text-align:center"><strong><span id="per-all-practical">0</span>%</strong></td>
	</tr>
	
	<tr><td colspan="5" align="right"><strong>% SLT for F2F Physical Practical Component</strong>
	</td>
		<td style="text-align:center"><strong><span id="per-physical-practical">0</span>%</strong></td>
	</tr>
	
	
	
	
	<tr><td colspan="5" align="right"><strong>% SLT for F2F Online Practical Component</strong>
	</td>
		<td style="text-align:center"><strong><span id="per-tech-practical">0</span>%</strong></td>
	</tr>
	
	
</table>



</div>
</div>


</div>
</div>


<div>
	
	<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>


<?php 

$check = $model->pgrs_slt == 2 ? 'checked' : '';
?>

<div class="form-group"><label>
<input type="checkbox" name="complete" id="markcomplete" value="1" <?=$check?> /> Mark as complete</label>
</div>

<button class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> SAVE STUDENT LEARNING TIMES</button>
	</div>


<?php ActiveForm::end()?>


<?php JSRegister::begin(); ?>
<script>
	calcAll(true);
	
	$("#markcomplete").click(function(){
		var gen = myparse($("#hour-slt").text());
		var credit =  myparse($("#hour-set").text());
		if(gen == credit){
			return true;
		}else{
			alert('Make sure Generated Credit Hour by SLT equal to Credit Hour set for this course');
			return false;
		}
	})
	
	
	$("#is_practical").click(function(){
		
		
	calcAll();
	});
	
	$(".tgcal").keyup(function(){
		calcAll();
	});
	
	$(".tgsyl").keyup(function(){
		calcAll();
	});

function calcAll(load = false){
	//alert('hai');
	if(!load){
		$("#markcomplete").prop('checked', false);
	}
	
	calcTotalSlt();
	cal_syll_col();
	assFormVertical();
	assSumVertical();
	calcPhysical();
	calcTech();
	calcPractical();
	calcCreditHourSlt();
	compareCredit();
}



function getSlt(){
	return myparse($("#total-slt").text());
}


function myfor(num){
	return parseFloat(num.toFixed(2)) + 0;
}


function myparse(num){
	if(!parseFloat(num)){
		return 0;
	}else{
		return parseFloat(num);
	}
}

function assFormHorizontal(){
	var arr = [<?=$arrFormAss?>];
	var jum = 0;
	for(i=0;i<arr.length;i++){
		var subjum = 0;
		subjum += myparse($("#form-ass-"+arr[i]).val());
		subjum += myparse($("#form-ass-tech-"+arr[i]).val());
		subjum += myparse($("#form-ass2-"+arr[i]).val());
		jum += subjum;
		$("#form-subtotal-"+arr[i]).text(myfor(subjum));
	}
	$("#form-total").text(myfor(jum));
	return jum;
}

function assFormVertical(){
	var arr = [<?=$arrFormAss?>];
	var ass = ['ass', 'ass-tech', 'ass2'];
	
	for(x=0;x<ass.length;x++){
		var subjum = 0;
		for(i=0;i<arr.length;i++){
			subjum += myparse($("#form-" + ass[x] + "-"+arr[i]).val());
		}
		//alert(subjum);
		$("#form-total-" + ass[x]).text(myfor(subjum));
	}
}

function assSumHorizontal(){
	
	var arr = [<?=$arrSumAss?>];
	var jum = 0;
	for(i=0;i<arr.length;i++){
		var subjum = 0;
		subjum += myparse($("#sum-ass-"+arr[i]).val());
		subjum += myparse($("#sum-ass-tech-"+arr[i]).val());
		subjum += myparse($("#sum-ass2-"+arr[i]).val());
		jum += subjum;
		$("#sum-subtotal-"+arr[i]).text(myfor(subjum));
	}
	$("#sum-total").text(myfor(jum));
	return jum;
}

function assSumVertical(){
	var arr = [<?=$arrSumAss?>];
	var ass = ['ass', 'ass-tech', 'ass2'];
	
	for(x=0;x<ass.length;x++){
		var subjum = 0;
		for(i=0;i<arr.length;i++){
			subjum += myparse($("#sum-" + ass[x] + "-"+arr[i]).val());
		}
		//alert(subjum);
		$("#sum-total-" + ass[x]).text(myfor(subjum));
	}
}

function totalSltAssessment(){
	//jum-assess
	var sum = assSumHorizontal();
	var form = assFormHorizontal();
	var jum = sum + form;
	$("#jum-assess").text(myfor(jum));
	return jum;
}

function calcTotalSlt(){
	var syll = cal_syll_week();
	var ass = totalSltAssessment();
	var grand = syll + ass;
	$("#total-slt").text(myfor(grand));
	return grand;
}

function calcPhysical(){
	var lec = myparse($("#subsyll_pnp_lecture").text());
	var prac = myparse($("#subsyll_pnp_practical").text());
	var tut = myparse($("#subsyll_pnp_tutorial").text());
	var other = myparse($("#subsyll_pnp_others").text());
	var syll = lec + prac + tut + other;
	
	var form = myparse($("#form-total-ass").text());
	var sum = myparse($("#sum-total-ass").text());
	
	var total = syll + form + sum;
	var per = total / getSlt() * 100;
	
	$("#per-physical").text(myfor(per));
	
}

function calcTech(){
	var lec = myparse($("#subsyll_tech_lecture").text());
	var prac = myparse($("#subsyll_tech_practical").text());
	var tut = myparse($("#subsyll_tech_tutorial").text());
	var other = myparse($("#subsyll_tech_others").text());
	var ind = myparse($("#subsyll_independent").text());
	var syll = lec + prac + tut + other + ind;
	
	var form = myparse($("#form-total-ass-tech").text());
	var sum = myparse($("#sum-total-ass-tech").text());
	var form_ind = myparse($("#form-total-ass2").text());
	var sum_ind = myparse($("#sum-total-ass2").text());
	
	var total = syll + form + sum + form_ind + sum_ind;
	var per = total / getSlt() * 100;
	
	$("#per-online").text(myfor(per));
	
}

function calcPhysicalPractical(){
	var prac = myparse($("#subsyll_pnp_practical").text());
	var per = prac / getSlt() * 100;
	
	$("#per-physical-practical").text(myfor(per));
	return per;
}

function calcTechPractical(){
	var prac = myparse($("#subsyll_tech_practical").text());
	var per = prac / getSlt() * 100;
	
	$("#per-tech-practical").text(myfor(per));
	return per;
}


function calcCreditHourSlt(){
	var slt = getSlt();
	var delimiter = 40;
			if($("#is_practical").prop("checked") == true){
               delimiter = 80;
            }
            else{
                delimiter = 40;
            }
	var credit = Math.floor(slt / delimiter);
	$("#slt-formula").text('[ '+slt+' / '+delimiter+' ]');
	$("#hour-slt").text(myfor(credit));
	$("#input-hour-slt").text(myfor(credit));
}

function compareCredit(){
	var gen = myparse($("#hour-slt").text());
	var set = myparse($("#hour-set").text());
	if(gen == set){
		$("#slt-alert").hide();
	}else{
		$("#slt-alert").show();
	}
}

function calcPractical(){
	var phy = calcPhysicalPractical();
	var tech = calcTechPractical();
	var jum = phy + tech;
	$("#per-all-practical").text(myfor(jum));
}

/* function cal_ass(){
	var arr = [];
	var jum = 0;
	var jum2 = 0;
	
	for(i=0;i<arr.length;i++){
		jum += myparse($("#ass-"+arr[i]).val());
	}
	
	for(i=0;i<arr.length;i++){
		jum2 += myparse($("#ass2-"+arr[i]).val());
	}

	$("#jumass").text(myfor(jum));
	$("#jumass2").text(myfor(jum2));
	
	var gtotal = jum + jum2;
	$("#subsyll_assess").text(myfor(gtotal));
	
	return gtotal;
	
} */


function cal_syll_week(){
	var arrsyl = [<?=$arr_syll?>];
	var tot= 0;
	for(n=0;n<arrsyl.length;n++){
		var arrw = ["pnp_lecture", "pnp_tutorial", "pnp_practical", "pnp_others", "tech_lecture", "tech_tutorial", "tech_practical", "tech_others",  "independent"];
		sub = 0;
		for(s=0;s<arrw.length;s++){
			sub += getNumValue(arrw[s], arrsyl[n]);
		}
		$("#subsyll_"+arrsyl[n]).text(myfor(sub));
		tot += sub;
	}
	$("#subsyll_total").text(myfor(tot));
	return tot;
}

function cal_syll_col(){
	var arrw = ["pnp_lecture", "pnp_tutorial", "pnp_practical", "pnp_others", "tech_lecture", "tech_tutorial", "tech_practical", "tech_others", "independent"];
	var tot= 0;
	for(s=0;s<arrw.length;s++){
		var arrsyl = [<?=$arr_syll?>];
		sub = 0;
		for(n=0;n<arrsyl.length;n++){
			sub += getNumValue(arrw[s], arrsyl[n]);
		}
		$("#subsyll_" + arrw[s]).text(myfor(sub));	
	}
}



function getNumValue(mystr, week){
	return myparse($("#"+mystr+"_"+week).val());
}

//alert('hai');

</script>
<?php JSRegister::end(); ?>

