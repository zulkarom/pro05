<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\modules\esiap\models\CourseDelivery;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */


$this->title = 'Teaching Methods';
$this->params['breadcrumbs'][] = ['label' => 'Preview', 'url' => ['course/view-course', 'course' => $model->course_id, 'version' => $model->id]];
$this->params['breadcrumbs'][] = 'Teaching Methods';
$plo_num = $model->ploNumber;
$form = ActiveForm::begin(['id' => 'form-clo-plo']);
echo $form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false);
?>

<?=$this->render('_header',[
'course' => $model->course, 
    'version' => $model
])?>
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
		<th>Main Method of Delivery</th>
<th>Other Method of Delivery</th>
		';
	
	
		
	echo '</tr>
	</thead>
	';
	$x = 1;
	
	foreach($clos as $index => $clo){
		echo '<tr>';
		echo '<td style="vertical-align:middle;" >CLO'.$x.'</td>';
		echo '<td style="vertical-align:middle;">' . $clo->clo_text . '<br /><i>'.$clo->clo_text_bi.'</i><br />'.$clo->taxoPloBracket.'</td>';
		echo '<td>';
		
		echo '<br />';
			;
		$delivery = ArrayHelper::map($clo->cloDeliveries, 'delivery_id', 'delivery_id');;
		//print_r($delivery);
			foreach(CourseDelivery::getMainDeliveries() as $rm){
				$chk = in_array($rm->id, $delivery) ? "checked" : "";
				echo "<div class='form-group'><label>
				<input type='hidden' name='method[".$clo->id ."][".$rm->id ."]' value='0'  />
				<input type='checkbox' name='method[".$clo->id ."][".$rm->id ."]' value='1' ".$chk."  /> ".$rm->delivery_name_bi ." </label>
				</div>";
				
			}
		
		echo '</td>';
		echo '<td>';
		
			foreach(CourseDelivery::getOtherDeliveries() as $rm){
				$chk = in_array($rm->id, $delivery) ? "checked" : "";
				echo "<div class='form-group'><label> <input type='hidden' name='method[".$clo->id ."][".$rm->id ."]' value='0'  />
				<input type='checkbox' name='method[".$clo->id ."][".$rm->id ."]' value='1' ".$chk."  /> ".$rm->delivery_name_bi ." </label></div>";
				
			}
		
		
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
<?php 
$check = $model->pgrs_delivery == 2 ? 'checked' : ''; ?>
<label>
<input type="checkbox" id="complete" name="complete" value="1" <?=$check?> /> Mark as complete
</label></div>



<div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE CLO DELIVERY', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end()?>


