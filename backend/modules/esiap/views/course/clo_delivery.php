<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\modules\esiap\models\CourseDelivery;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */


$this->title = 'Delivery: ' . $model->course->course_name . ' '. $model->course->course_code;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Delivery';
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
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE CLO DELIVERY', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end()?>


