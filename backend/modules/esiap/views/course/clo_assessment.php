<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use backend\modules\esiap\models\AssessmentCat;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */


$this->title = 'CLO Assessment: ' . $model->course->course_name . ' '. $model->course->course_code;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Assessment';

$form = ActiveForm::begin(['id' => 'form-clo-assessment']);
?>


<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?php



echo $form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false);

if($clos){
	echo '<table class="table">
	<thead>
	<tr>
		<th width="6%">#</th>
		<th width="50%">CLO</th>
		<th>Assessment</th>
		<th width="15%">Percentage</th>
		<th width="5%"></th>
	</tr>
	</thead>
	';
	$i = 1;
	
	foreach($clos as $index => $clo){
		echo '<tr>';
		$rowspan_1 = rowspan_1($clo->cloAssessments);
		echo '<td style="vertical-align:middle;" '.$rowspan_1.'>CLO'.$i.'</td>';
		echo '<td style="vertical-align:middle;" '.$rowspan_1.'>' . $clo->clo_text . '<br /><i>'.$clo->clo_text_bi.'</i></td>';
		colum_2_first($form,$clo->cloAssessments, $assess, $model);
		echo '</tr>';
		colum_2($form,$clo->cloAssessments, $assess, $model);
		echo '<tr><td colspan="3"><a href="'.Url::to(['add-assessment-clo', 'course' => $model->course->id, 'clo' => $clo->id]).'" class="add-item btn btn-default btn-sm"><span class="fa fa-plus"></span> Add Assessment to CLO'.$i.'</a></td></tr>';
		$i++;
	}
	echo '</table>';
}
?>



</div>
</div>

<div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE CLO ASSESSMENT', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end()?>


<?php

function rowspan_1($clo_as){
	if($clo_as){
		$kira = count($clo_as) + 1;
		return "rowspan='".$kira."'";
		
	}else{
		return "";
	}
}
function colum_2_first($form,$clo_as, $assess, $model){
	if($clo_as){
		
		$cloAs = $clo_as[0];
		colum_2_td($form,$cloAs, $assess,$model);
	}else{
		empty_cell(2);
	}
	
}
function colum_2($form,$clo_as, $assess, $model){
	if($clo_as){
		$i=1;
			foreach($clo_as as $cloAs){
				if($i > 1){
					echo '<tr>';
					colum_2_td($form,$cloAs, $assess,$model);
					echo '</tr>';
				}
			$i++;
			}
		}
}

function colum_2_td($form,$cloAs, $assess,$model){
	$index = $cloAs->id;
	$clo_id = $cloAs->clo_id;
	echo '<td>' . Html::activeHiddenInput($cloAs, "[{$index}]id") . $form->field($cloAs, "[{$index}]assess_id", [
					'options' => [
						'tag' => false, // Don't wrap with "form-group" div
					]])->dropDownList(
        ArrayHelper::map($assess,'id', "assess_name"), ['prompt' => 'Please Select' ]
    )
->label(false) . '</td>';
				
					echo '<td>' . $form->field($cloAs, "[{$index}]percentage", [
					'addon' => ['append' => ['content'=>'%']],
					'options' => [
						'tag' => false, // Don't wrap with "form-group" div
					]])->textInput()->label(false) . '</td>
					<td class="text-center vcenter" style="width: 90px;">
                    <a href="'.Url::to(['delete-assessment-clo', 'course' => $model->course->id, 'id' => $cloAs->id]).'" class="remove-item btn btn-default btn-sm"><span class="fa fa-remove"></span></a></td>';
				
}

function empty_cell($colum){
	switch($colum){
		case 2:
		$x = 2;
		break;
		break;
	}
	$str = "";
	for($i=1;$i<=$x;$i++){
		echo "<td></td>";
	}
}


?>
