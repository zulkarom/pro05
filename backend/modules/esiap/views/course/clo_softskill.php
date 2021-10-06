<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use backend\modules\esiap\models\AssessmentCat;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */


$this->title = 'Softskills';
$this->params['breadcrumbs'][] = ['label' => 'Preview', 'url' => ['course/view-course', 'course' => $model->course_id, 'version' => $model->id]];
$this->params['breadcrumbs'][] = 'CLO Softskill';
$plo_num = $model->ploNumber;
$form = ActiveForm::begin(['id' => 'form-clo-softskill']);
echo $form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false);
?>

<?=$this->render('_header',[
'course' => $model->course, 
    'version' => $model
])?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">

<table class="table table-hover table-striped">
<thead>
<tr><th>No. </th><th>Course Learning Outcome</th><th width="50%"></th>

</tr>

</thead>
<tbody>
<?php
$x=1;
if($clos){
	foreach($clos as $clo){
		echo '<tr><td>';
		
		echo $x.'. </td><td>'.$clo->clo_text .'<br /><i>'.$clo->clo_text_bi .'</i>
		
		<br />
		'.$clo->taxoPloBracket .'
		</td>';
		echo "<td>";
		
		echo "<table class='table table-hover table-striped'>
		<thead>
		<tr><th></th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th></tr>
		</thead>";
		echo "<tr><td><strong>Communication (CS)</strong></td>";
		for($i=1;$i<=8;$i++){
			$prop = 'CS'.$i;
			$check = $clo->{$prop} == 1 ? 'checked' : '';
			echo '<td>';
			echo '<input type="hidden" name="ss['.$clo->id .'][CS'.$i.']" value="0" />';
			echo '<input type="checkbox" name="ss['.$clo->id .'][CS'.$i.']" value="1" '.$check.' />';
			echo '</td>';
		}
		echo "</tr>";
		echo "<tr><td><strong>Critical Thinking (CT)</strong></td>";
		for($i=1;$i<=7;$i++){
			$prop = 'CT'.$i;
			$check = $clo->{$prop} == 1 ? 'checked' : '';
			echo '<td>';
			echo '<input type="hidden" name="ss['.$clo->id .'][CT'.$i.']" value="0" />';
			echo '<input type="checkbox" name="ss['.$clo->id .'][CT'.$i.']" value="1" '.$check.' />';
			echo '</td>';
		}
		echo "<td></td>";
		echo "</tr>";
		
		echo "<tr><td><strong>Teamwork (TS)</strong></td>";
		for($i=1;$i<=5;$i++){
			$prop = 'TS'.$i;
			$check = $clo->{$prop} == 1 ? 'checked' : '';
			echo '<td>';
			echo '<input type="hidden" name="ss['.$clo->id .'][TS'.$i.']" value="0" />';
			echo '<input type="checkbox" name="ss['.$clo->id .'][TS'.$i.']" value="1" '.$check.' />';
			echo '</td>';
		}
		echo "<td></td><td></td><td></td>";
		echo "</tr>";
		
		echo "<tr><td><strong>Life Long Learning (LL)</strong></td>";
		for($i=1;$i<=3;$i++){
			$prop = 'LL'.$i;
			$check = $clo->{$prop} == 1 ? 'checked' : '';
			echo '<td>';
			echo '<input type="hidden" name="ss['.$clo->id .'][LL'.$i.']" value="0" />';
			echo '<input type="checkbox" name="ss['.$clo->id .'][LL'.$i.']" value="1" '.$check.' />';
			echo '</td>';
		}
		echo "<td></td><td></td><td></td><td></td><td></td>";
		echo "</tr>";
		
		echo "<tr><td><strong>Entrepreneurial (ES)</strong></td>";
		for($i=1;$i<=4;$i++){
			$prop = 'ES'.$i;
			$check = $clo->{$prop} == 1 ? 'checked' : '';
			echo '<td>';
			echo '<input type="hidden" name="ss['.$clo->id .'][ES'.$i.']" value="0" />';
			echo '<input type="checkbox" name="ss['.$clo->id .'][ES'.$i.']" value="1" '.$check.' />';
			echo '</td>';
		}
		echo "<td></td><td></td><td></td><td></td>";
		echo "</tr>";
		echo "<tr><td><strong>Ethic and Moral (EM)</strong></td>";
		for($i=1;$i<=3;$i++){
			$prop = 'EM'.$i;
			$check = $clo->{$prop} == 1 ? 'checked' : '';
			echo '<td>';
			echo '<input type="hidden" name="ss['.$clo->id .'][EM'.$i.']" value="0" />';
			echo '<input type="checkbox" name="ss['.$clo->id .'][EM'.$i.']" value="1" '.$check.' />';
			echo '</td>';
		}
		echo "<td></td><td></td><td></td><td></td><td></td>";
		echo "</tr>";
		echo "<tr><td><strong>Leadership (LS)</strong></td>";
		for($i=1;$i<=4;$i++){
			$prop = 'LS'.$i;
			$check = $clo->{$prop} == 1 ? 'checked' : '';
			echo '<td>';
			echo '<input type="hidden" name="ss['.$clo->id .'][LS'.$i.']" value="0" />';
			echo '<input type="checkbox" name="ss['.$clo->id .'][LS'.$i.']" value="1" '.$check.' />';
			echo '</td>';
		}
		echo "<td></td><td></td><td></td><td></td>";
		echo "</tr>";
		echo "</table>";
		
		echo "</td>";
	echo '</tr>';
	$x++;
	}
}
?>


</tbody></table>

</div></div>

<div class="form-group">
<?php 
$check = $model->pgrs_soft == 2 ? 'checked' : ''; ?>
<label>
<input type="checkbox" id="complete" name="complete" value="1" <?=$check?> /> Mark as complete
</label></div>

<div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE CLO SOFTSKILL', ['class' => 'btn btn-primary']) ?>
    </div>
	
	
<?php ActiveForm::end()?>


