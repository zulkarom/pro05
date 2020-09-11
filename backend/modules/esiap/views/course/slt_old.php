<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */


$this->title = 'Student Learning Time';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'SLT';

$form = ActiveForm::begin(['id' => 'form-clo-assessment']); 
?>

<?=$this->render('_header',[
'course' => $model->course
])?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?php

$ch = $model->course->credit_hour;
if($model->slt->is_practical == 1){
	$notional = 80;
}else{
	$notional = 40;
}

$slt_hour = $ch * $notional;
$aclo="";$asyll="";



?>
<div class="row">
<div class="col-md-6">
<table class="table table-striped table-hover">
<thead>
	<tr>
		<th>Guided Learning (F2F)</th>
		<th width="20%">Hour</th>
		<th width="20%">Week</th>
		<th width="20%" style="text-align:center">Total</th>
	</tr>
</thead>
	<tr>
		<td>Lecture</td>
		<td><input class="form-control tgcal" name="slt[lecture_jam]" id="lecture_jam" style="text-align:center" value="<?php echo $slt->lecture_jam;?>" /></td>
		<td ><input class="form-control tgcal" name="slt[lecture_mggu]" id="lecture_mggu" style="text-align:center" value="<?php echo $slt->lecture_mggu;?>" /></td>
		<td style="text-align:center;font-weight:bold" id="sublec">0</td>
	</tr>
	<tr>
		<td>Tutorial</td>
		<td><input class="form-control tgcal" name="slt[tutorial_jam]" id="tutorial_jam" style="text-align:center" value="<?php echo $slt->tutorial_jam;?>"  /></td>
		<td><input class="form-control tgcal" name="slt[tutorial_mggu]" id="tutorial_mggu" style="text-align:center" value="<?php echo $slt->tutorial_mggu;?>"  /></td>
		<td style="text-align:center;font-weight:bold" id="subtut">0</td>
	</tr>
	<tr>
		<td>Practical</td>
		<td><input class="form-control tgcal" name="slt[practical_jam]" id="practical_jam" style="text-align:center" value="<?php echo $slt->practical_jam;?>"  /></td>
		<td><input class="form-control tgcal" name="slt[practical_mggu]" id="practical_mggu" style="text-align:center" value="<?php echo $slt->practical_mggu;?>"  /></td>
		<td style="text-align:center;font-weight:bold" id="subprac">0</td>
	</tr>
	<tr>
		<td>Others</td>
		<td><input class="form-control tgcal" name="slt[others_jam]" id="others_jam" style="text-align:center" value="<?php echo $slt->others_jam;?>"  /></td>
		<td><input class="form-control tgcal" name="slt[others_mggu]" id="others_mggu" style="text-align:center" value="<?php echo $slt->others_mggu;?>"  /></td>
		<td style="text-align:center;font-weight:bold" id="subother">0</td>
	</tr>

	
	<tr>
		<td colspan="3"><strong>Total Guided Learning (F2F)</strong></td>
		<td style="text-align:center"><strong id="jumlearning">0</strong></td>
	</tr>
	
	<tr>
		<td colspan="3"><strong>Guided Learning (NF2F)</strong><br />
		<i>*E-learning, Project, HIEPs, Assignment, LI, SIEP etc.</i>
		
		</td>
		<td style="text-align:center"><input type="text" class="form-control tgcal"  id="jum-nf2f" name="slt[nf2f]" value="<?php echo $slt->nf2f;?>" style="text-align:center" /></td>
	</tr>
	
	<tr>
		<td colspan="3"><strong>Total Guided Learning (a)</strong></td>
		<td style="text-align:center"><strong id="jumguidedlearning">0</strong></td>
	</tr>

	
	<tr>
		<td colspan="3"><strong>Independent Learning </strong>(c) - (a) - (b)<div id="negwarn" style="color:red"></div></td>

		<td style="text-align:center"><strong id="indlearn">0</strong> </td>
	</tr>
	<tr>
		<td colspan="3"><strong>Student Learning Time (c)</strong></td>

		<td style="text-align:center"><strong id="total-slt-hour"><?php echo $slt_hour;?></strong></td>
	</tr>
	<tr>
		<td colspan="3"><strong>Credit Hour</strong> (c) / <span id="notional_hour"><?=$notional?></span> </td>

		<td style="text-align:center"><strong id="credit_hour_val"><?php echo $ch?></strong></td>
	</tr>
</table>
</div>
<div class="col-md-6">

<table class="table table-striped table-hover">
<thead>
	<tr>
	<th colspan="3"><strong>Assessment</strong></th>
		
	</tr>
</thead>
	<tr>
		<td><b>Formative Assessment</b></td>
		<td width="20%"><b>F2F</b></td>
		<td width="20%"><b>NF2F</b></td>
	</tr>
	<?php 
	
	$assdirect = $model->assessmentFormative;
	$assindirect= $model->assessmentSummative;
	
	$arrass = "";
	$i=1;
	if($assdirect){
		
		foreach($assdirect as $rhead){
			$id = $rhead->id;

			$arrass .= $i == 1 ? $id : "," . $id ;
			echo "<tr><td>".$rhead->assess_name_bi ."</td>
			<td>
			<input class='form-control tgcal' name='assess[".$id . "]' id='ass-".$id . "' value='" . $rhead->assess_f2f . "' style='text-align:center' /></td>
			<td>
			<input class='form-control tgcal' name='assess2[".$id . "]' id='ass2-".$id . "' value='" . $rhead->assess_nf2f . "' style='text-align:center' /></td>
			</tr>
			";
		$i++;
		}
	}
	//".$rhead->slt->assess_f2f ."
	?>
	

	
	<tr>
		<td><b>Summative Assessment</b></td>
		<td><b>F2F</b></td>
		<td><b>NF2F</b></td>
	</tr>
	<?php 
	if($assindirect){
		foreach($assindirect as $rhead){
			$id = $rhead->id;
			$arrass .= $i == 1 ? $id : "," . $id ;
			echo "<tr><td>".$rhead->assess_name_bi ."</td>
			<td><input class='form-control tgcal' name='assess[".$id . "]' id='ass-".$id . "' value='".$rhead->assess_f2f ."' style='text-align:center' /></td>
			<td><input class='form-control tgcal' name='assess2[".$id . "]' id='ass2-".$id . "' value='".$rhead->assess_nf2f ."' style='text-align:center' /></td>
			</tr>
			";
			$i++;
		}
	
	}
	?>
	<tr>
	<td><strong>Total Assessment Hour (b)</strong>
	</td>
		<td style="text-align:center"><strong id="jumass">0</strong></td>
		<td style="text-align:center"><strong id="jumass2">0</strong></td>
	</tr>
</table>

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
Please tick if this course is Latihan Industri/ Clinical Placement/ Practicum/ WBL using Effective Learning Time(ELT) of 50%
</label>
<div class="help-block"></div>
</div>
</div>

</div>
</div>



<div class='row'>
	<div class='col-md-12'>
	
	<table class='table table-hover table-striped'>
	<thead>
	<tr>
	<th width='1%' rowspan='3'>WEEK</th>
	<th rowspan='3' width="25%">TOPICS</th>
	<th colspan="7" style="text-align:center">STUDENT LEARNING TIMES</th></tr>
	
	<tr>
	
	<th style='text-align:center' colspan='4' >GUIDED LEARNING (F2F)
	
	</th><th rowspan="2" style="vertical-align:top;text-align:center">GUIDED LEARNING<br />(NF2F)
	<br /><i style="font-weight:normal">*E-learning, Project, HIEPs, Assignment, LI, SIEP etc.</i>
	</th><th rowspan="2" style="vertical-align:top">INDEPENDENT<br />LEARNING</th><th rowspan="2" style="vertical-align:top">TOTAL</th></tr>
	
	<tr><th >LECTURE</th><th>TUTORIAL</th><th>PRACTICAL</th><th>OTHERS</th></tr>
	</thead>
<?php 

$arr_syll = "";
$i=1;
foreach($syll as $row){ ?>
	<tr>
	<td>
	<b><?php echo $row->week_num ; ?></b>
	</td>
	<td>
	
		<?php 
		$arr_syll .= $i == 1 ? $row->id : ", " . $row->id ;
		$arr_all = json_decode($row->topics);
		if($arr_all){
		foreach($arr_all as $rt){
		echo "<strong>".$rt->top_bm ." / <i>". $rt->top_bi . "</i></strong>";
		if($rt->sub_topic){
		echo "<ul>";
			foreach($rt->sub_topic as $rst){
			echo "<li>".$rst->sub_bm . " / <i>" . $rst->sub_bi . "</i></li>";
			}
		echo "</ul>";
		}
		} 
		} 
		?>
		
	</td>
	<td style="vertical-align:middle"><!-- LECTURE -->
	<input type="text" style="text-align:center" class="form-control tgsyl" name="syll[<?php echo $row->id;?>][pnp_lecture]" id="pnp_lecture_<?php echo $row->id;?>" value="<?php echo $row->pnp_lecture ; ?>" />
	</td>
	<td style="vertical-align:middle"><!-- TUT -->
	<input type="text" style="text-align:center" class="form-control tgsyl" name="syll[<?php echo $row->id;?>][pnp_tutorial]" id="pnp_tutorial_<?php echo $row->id;?>" value="<?php echo $row->pnp_tutorial ; ?>"  />
	</td>
	<td style="vertical-align:middle"><!-- PRACTICAL -->
	<input type="text" style="text-align:center" class="form-control tgsyl" name="syll[<?php echo $row->id;?>][pnp_practical]" id="pnp_practical_<?php echo $row->id;?>" value="<?php echo $row->pnp_practical ; ?>"  />
	</td>
	
	<td style="vertical-align:middle">
	<input type="text" style="text-align:center" class="form-control tgsyl" name="syll[<?php echo $row->id;?>][pnp_others]" id="pnp_others_<?php echo $row->id;?>" value="<?php echo $row->pnp_others ; ?>"  />
	</td>
	

	
	<td style="vertical-align:middle">
	<input type="text" style="text-align:center" class="form-control tgsyl" name="syll[<?php echo $row->id;?>][nf2f]" id="nf2f_<?php echo $row->id;?>" value="<?php echo $row->nf2f ; ?>"  />
	</td>
	<td style="vertical-align:middle">
	<input type="text" style="text-align:center" value="<?php echo $row->independent ; ?>" name="syll[<?php echo $row->id;?>][independent]" id="independent_<?php echo $row->id;?>" class="form-control tgsyl" />
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
<td id="subsyll_nf2f">0</td>
<td id="subsyll_independent">0</td>
<td id="subsyll_total">0</td>
</tr>

<tr style="text-align:center;font-weight:bold">
<td colspan="2"><b>Assessment</b></td>
<td colspan="6"></td>
<td id="subsyll_assess">0</td>
</tr>

<tr style="text-align:center;font-weight:bold">
<td colspan="2"><b>Total SLT</b></td>
<td id="subsyll_pnp_lecturex">0</td>
<td id="subsyll_pnp_tutorialx">0</td>
<td id="subsyll_pnp_practicalx">0</td>
<td id="subsyll_pnp_othersx">0</td>
<td id="subsyll_nf2fx">0</td>
<td id="subsyll_independentx">0</td>
<td id="subsyll_totalx">0</td>
</tr>

<tr style="text-align:center;font-style:italic">
<td colspan="2">Setting (Above)</td>
<td id="setsyll_pnp_lecture">0</td>
<td id="setsyll_pnp_tutorial">0</td>
<td id="setsyll_pnp_practical">0</td>
<td id="setsyll_pnp_others">0</td>
<td id="setsyll_nf2f">0</td>
<td id="setsyll_independent">0</td>
<td id="setsyll_total"></td>
</tr>

<tr style="text-align:center">
<td colspan="2"><i>Is Total SLT Equal to Setting?</i></td>
<td id="gly_pnp_lecture"><span class="glyphicon glyphicon-warning-sign" style="color:red"></span></td>
<td id="gly_pnp_tutorial"><span class="glyphicon glyphicon-warning-sign" style="color:red"></span></td>
<td id="gly_pnp_practical"><span class="glyphicon glyphicon-warning-sign" style="color:red"></span></td>
<td id="gly_pnp_others"><span class="glyphicon glyphicon-warning-sign" style="color:red"></span></td>

<td id="gly_nf2f"><span class="glyphicon glyphicon-warning-sign" style="color:red"></span></td>
<td id="gly_independent"><span class="glyphicon glyphicon-warning-sign" style="color:red"></span></td>
<td id="gly_total"><span class="glyphicon glyphicon-warning-sign" style="color:red"></span></td>
</tr>
</table>
</div>
	</div>
	





</div>
</div>
<div align="center">
	
	<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>

	<button class="btn btn-primary"><span class="glyphicon glyphicon-floppy-disk"></span> SAVE STUDENT LEARNING TIMES</button>
	</div>


<?php ActiveForm::end()?>


<?php 

$js = '


	cal_indlearn();
	cal_syll_week();
	cal_syll_week2();
	cal_syll_col();
	cal_syll_col2();
	checkEqual();
	
	$("#is_practical").click(function(){
		var notional;
		if($(this).is(":checked")){
			notional = 80;
		}else{
			notional = 40;
			
		}
		$("#notional_hour").text(notional);
		var credit = myparse($("#credit_hour_val").text());
		//alert(credit);
		var total = notional * credit;
		$("#total-slt-hour").text(total);
		
		
		cal_indlearn();
	cal_syll_week();
	cal_syll_week2();
	cal_syll_col();
	cal_syll_col2();
		checkEqual();
	});
	
	$(".tgcal").keyup(function(){
		cal_indlearn();
		checkEqual();
	});
	
	$(".tgsyl").keyup(function(){
		cal_syll_week();
		cal_syll_week2();
		cal_syll_col();
		cal_syll_col2();
		checkEqual();
	});
	


function cal_indlearn(){
	var slt = getSlt();
	var ind = slt - calculate_guided_learning() - cal_ass();
	$("#indlearn").text(ind);
	$("#setsyll_independent").text(myfor(ind));
	if(ind < 0 ){
		$("#negwarn").html(\'<span class="glyphicon glyphicon-warning-sign"></span> The Value Cannot Be Negative!\');
	}else{
		$("#negwarn").html("");
	}
	
	
}

function getSlt(){
	return myparse($("#total-slt-hour").text());
}

function calculate_learning(){
var besar = cal_lec() + cal_tut() + cal_prac() + cal_other() ;	
$("#jumlearning").text(myfor(besar));
return besar;
}

function cal_nf2f(){
	var num = myparse($("#jum-nf2f").val());
	$("#setsyll_nf2f").text(myfor(num));
	return num;
}

function calculate_guided_learning(){
var besar = calculate_learning() + cal_nf2f();	
$("#jumguidedlearning").text(myfor(besar));
return besar;
}

function myfor(num){
	return parseFloat(num.toFixed(2)) + 0;
}

function cal_other(){
	var other_hour = $("#others_jam").val();
	var other_week = $("#others_mggu").val();
	var jum = myparse(other_hour) * myparse(other_week);
	$("#subother").text(myfor(jum));
	$("#setsyll_pnp_others").text(myfor(jum));
	return jum;
	
}

function cal_prac(){
	var prac_hour = $("#practical_jam").val();
	var prac_week = $("#practical_mggu").val();
	var jum = myparse(prac_hour) * myparse(prac_week);
	$("#subprac").text(myfor(jum));
	$("#setsyll_pnp_practical").text(myfor(jum));
	return jum;
	
}

function cal_tut(){
	var tut_hour = $("#tutorial_jam").val();
	var tut_week = $("#tutorial_mggu").val();
	var jum = myparse(tut_hour) * myparse(tut_week);
	$("#subtut").text(myfor(jum));
	$("#setsyll_pnp_tutorial").text(myfor(jum));
	return jum;
}
function cal_lec(){
	var lec_hour = $("#lecture_jam").val();
	var lec_week = $("#lecture_mggu").val();
	var jum = myparse(lec_hour) * myparse(lec_week);
	$("#sublec").text(myfor(jum));
	$("#setsyll_pnp_lecture").text(myfor(jum));
	return jum;
}

function myparse(num){
	if(!parseFloat(num)){
		return 0;
	}else{
		return parseFloat(num);
	}
}

function cal_ass(){
	var arr = [' . $arrass . '];
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
	
}
function glystr(what){
	var sign = "ok";
	var color = "green";
	if(what == 0){
		sign = "warning-sign";
		color = "red";
	}
	return \'<span class="glyphicon glyphicon-\' + sign + \'" style="color:\' + color + \'"></span>\';
}
function checkEqual(){
	
	$("#setsyll_total").text(getSlt());
	
	
	var arrw = ["pnp_lecture", "pnp_tutorial", "pnp_practical", "pnp_others", "independent", "nf2f", "total"];
	for(s=0;s<arrw.length;s++){
		var syl = myparse($("#subsyll_"+arrw[s]).text());
		var set = $("#setsyll_"+arrw[s]).text();
		if(arrw[s] == "total"){
			syl += myparse($("#subsyll_assess").text());
		}
		
		
		if(syl == set){
			$("#gly_"+arrw[s]).html(glystr(1));
		}else{
			$("#gly_"+arrw[s]).html(glystr(0));
		}
	}
}

function cal_syll_week(){
	var arrsyl = ['.$arr_syll.'];
	var tot= 0;
	for(n=0;n<arrsyl.length;n++){
		var arrw = ["pnp_lecture", "pnp_tutorial", "pnp_practical", "pnp_others",  "independent", "nf2f"];
		sub = 0;
		for(s=0;s<arrw.length;s++){
			sub += getNumValue(arrw[s], arrsyl[n]);
		}
		$("#subsyll_"+arrsyl[n]).text(myfor(sub));
		tot += sub;
	}
	$("#subsyll_total").text(myfor(tot));
}

function cal_syll_week2(){
	var arrsyl = ['.$arr_syll.'];
	var tot= 0;
	for(n=0;n<arrsyl.length;n++){
		var arrw = ["pnp_lecture", "pnp_tutorial", "pnp_practical", "pnp_others",  "independent", "nf2f"];
		sub = 0;
		for(s=0;s<arrw.length;s++){
			sub += getNumValue(arrw[s], arrsyl[n]);
		}
		$("#subsyll_"+arrsyl[n]).text(myfor(sub));
		tot += sub;
	}
	tot = tot + cal_ass();
	$("#subsyll_totalx").text(myfor(tot));
}

function cal_syll_col(){
	var arrw = ["pnp_lecture", "pnp_tutorial", "pnp_practical", "pnp_others", "independent", "nf2f"];
	var tot= 0;
	for(s=0;s<arrw.length;s++){
		var arrsyl = ['.$arr_syll.'];
		sub = 0;
		for(n=0;n<arrsyl.length;n++){
			sub += getNumValue(arrw[s], arrsyl[n]);
		}
		$("#subsyll_"+arrw[s]).text(myfor(sub));
			
	}
	
	
	
}

function cal_syll_col2(){
	var arrw = ["pnp_lecture", "pnp_tutorial", "pnp_practical", "pnp_others", "independent", "nf2f"];
	var tot= 0;
	for(s=0;s<arrw.length;s++){
		var arrsyl = ['.$arr_syll.'];
		sub = 0;
		for(n=0;n<arrsyl.length;n++){
			sub += getNumValue(arrw[s], arrsyl[n]);
		}
		$("#subsyll_"+arrw[s] + "x").text(myfor(sub));
			
	}
	
	
	
}

function getNumValue(mystr, week){
	return myparse($("#"+mystr+"_"+week).val());
}



';

$this->registerJs($js);

?>
