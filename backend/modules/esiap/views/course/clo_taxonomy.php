<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use backend\modules\esiap\models\AssessmentCat;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Taxonomy: ' . $model->course->course_name . ' '. $model->course->course_code;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Taxonomy';
$plo_num = $model->ploNumber;
$form = ActiveForm::begin(['id' => 'form-clo-plo']);
echo $form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false);
?>


<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?php
if($clos){
	echo '<table class="table table-hover table-striped">
	<thead>
	<tr>
		<th width="6%">#</th>
		<th width="50%">CLO</th>
		
		<th></th>
		';
	
	
		
	echo '</tr>
	</thead>
	';
	$x = 1;
	
	foreach($clos as $index => $clo){
		echo '<tr>';
		echo '<td style="vertical-align:middle;" >CLO'.$x.'</td>';
		echo '<td style="vertical-align:middle;">' . $clo->clo_text . '<br /><i>'.$clo->clo_text_bi.'</i>
		<br />
		'.$clo->taxoPloBracket .'
		</td>';
		echo '<td>';
		
		echo '<table class="table table-hover table-striped">
	<thead>
	<tr>
		<th width="50%"></th>
		';
		
		for($i=1;$i<=7;$i++){
			echo '<th>'.$i.'</th>';
		}
	
	
		
	echo '</tr>
	</thead>
	<tbody>
	';
	
	echo '<tr>';
	echo '<td>Cognitive (C)</td>';
	for($i=1;$i<=6;$i++){
			$prop = 'C'.$i;
			$check = $clo->{$prop} == 1 ? 'checked' : '';
			echo '<td>';
			echo '<input type="hidden" name="taxo['.$clo->id .'][C'.$i.']" value="0" />';
			echo '<input type="checkbox" name="taxo['.$clo->id .'][C'.$i.']" value="1" '.$check.' />';
			echo '</td>';
			
		}
	echo '<td></td>';
	echo '<tr>';
	
		echo '<tr>';
	echo '<td>Psychomotor (P)</td>';
	for($i=1;$i<=7;$i++){
			$prop = 'P'.$i;
			$check = $clo->{$prop} == 1 ? 'checked' : '';
			echo '<td>';
			echo '<input type="hidden" name="taxo['.$clo->id .'][P'.$i.']" value="0" />';
			echo '<input type="checkbox" name="taxo['.$clo->id .'][P'.$i.']" value="1" '.$check.' />';
			echo '</td>';
			
		}
	echo '<tr>';
	
		echo '<tr>';
	echo '<td>Affective (A)</td>';
	for($i=1;$i<=5;$i++){
			$prop = 'A'.$i;
			$check = $clo->{$prop} == 1 ? 'checked' : '';
			echo '<td>';
			echo '<input type="hidden" name="taxo['.$clo->id .'][A'.$i.']" value="0" />';
			echo '<input type="checkbox" name="taxo['.$clo->id .'][A'.$i.']" value="1" '.$check.' />';
			echo '</td>';
			
		}
	echo '<td></td><td></td>';
	echo '<tr>';
	
	echo '</body></table>';
		
		
		
		
		
		echo '</td>';
		echo '</tr>';
		
		$x++;
	}
	echo '</body></table>';
}
?>


</div>
</div>




<div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE CLO TAXONOMY', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end()?>


