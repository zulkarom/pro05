<?php


use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Semester */
/* @var $form yii\widgets\ActiveForm */

?>
	  
<div class="row">
<div class="col-md-4"><?= $form->field($model, 'is_current')->dropDownList(
        [0 => 'No', 1 => 'Yes']
    ) ?></div>
	
<div class="col-md-3">
 <?=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
	'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
		'format' => 'yyyy-mm-dd',
		'todayHighlight' => true,
		
    ],
	
	
]);

?>
</div>
<div class="col-md-3">
 <?=$form->field($model, 'date_end')->widget(DatePicker::classname(), [
	'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
		'format' => 'yyyy-mm-dd',
		'todayHighlight' => true,
		
    ],
	
	
]);

?>
</div>

</div>

  

    
	

	<div class="row">
	
	<div class="col-md-4"><?= $form->field($model, 'is_open')->dropDownList(
        [0 => 'No - force close', 1 => 'Yes - subject to open and end date']
    ) ?></div>

<div class="col-md-3">
 <?=$form->field($model, 'open_at')->widget(DatePicker::classname(), [
	'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
		'format' => 'yyyy-mm-dd',
		'todayHighlight' => true,
		
    ],
	
	
]);

?>
</div>
<div class="col-md-3">
 <?=$form->field($model, 'close_at')->widget(DatePicker::classname(), [
	'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
		'format' => 'yyyy-mm-dd',
		'todayHighlight' => true,
		
    ],
	
	
]);

?>

</div>
</div>

<div class="row">
<div class="col-md-3">
<?php
if($model->result_date == '0000-00-00'){
	$model->result_date = date('Y-m-d');
}
echo $form->field($model, 'result_date')->widget(DatePicker::classname(), [
	'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
		'format' => 'yyyy-mm-dd',
		'todayHighlight' => true,
		
    ],
	
	
]);

?>
</div>

</div>

<div class="row">
<div class="col-md-6"><?=$form->field($model, 'description')->textarea(['rows' => 3]) ?></div>

</div>

<?= $this->render('_note') ?>
