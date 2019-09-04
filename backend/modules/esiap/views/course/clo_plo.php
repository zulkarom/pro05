<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use backend\modules\esiap\models\AssessmentCat;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'CLO PLO: ' . $model->course->course_name . ' '. $model->course->course_code;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
$form = ActiveForm::begin(['id' => 'form-clo-plo']);
?>


<div class="box">
<div class="box-header"></div>
<div class="box-body">

* Put only one PLO for each CLO

<?php

$plo_num = $model->plo_num;



echo $form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false);

if($clos){
	echo '<table class="table">
	<thead>
	<tr>
		<th width="6%">#</th>
		<th width="50%">CLO</th>';
	
	for($i=1;$i<=$plo_num;$i++){
		echo '<th>PLO'.$i.'</th>';
	}
		
	echo '</tr>
	</thead>
	';
	$x = 1;
	
	foreach($clos as $index => $clo){
		echo '<tr>';
		echo '<td style="vertical-align:middle;" >CLO'.$x.'</td>';
		echo '<td style="vertical-align:middle;">' . $clo->clo_text . '<br /><i>'.$clo->clo_text_bi.'</i></td>';
		
		for($i=1;$i<=$plo_num;$i++){
			$prop = 'PLO'.$i;
			$check = $clo->{$prop} == 1 ? 'checked' : '';
			echo '<td>';
			echo '<input type="hidden" name="plo['.$clo->id .'][PLO'.$i.']" value="0" />';
			echo '<input type="checkbox" name="plo['.$clo->id .'][PLO'.$i.']" value="1" '.$check.' />';
			echo '</td>';
		}
		
		echo '</tr>';
		
		$x++;
	}
	echo '</table>';
}
?>



</div>
</div>

<div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE CLO PLO', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end()?>

