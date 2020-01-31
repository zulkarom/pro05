<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Semester */

$this->title = 'Create Semester';
$this->params['breadcrumbs'][] = ['label' => 'Semesters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$curr = date('Y') + 0;
$last = $curr - 1;
$next = $curr + 1;

$years = [$last => $last, $curr => $curr, $next => $next];
?>
<div class="semester-create">



<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="semester-form">

    <?php $form = ActiveForm::begin(); ?>
	<?= $form->errorSummary($model); ?>

	  
	  <div class="row">
<div class="col-md-3"><?= $form->field($model, 'session')->dropDownList(
        [1 => 'September', 2 => 'Februari'], ['prompt' => 'Please Select' ]
    ) ?></div>
<div class="col-md-3"><?= $form->field($model, 'year_start')->dropDownList(
        $years, ['prompt' => 'Please Select' ]
    ) ?></div>
	<div class="col-md-3"><?= $form->field($model, 'year_end')->textInput(['disabled' => true]) ?></div>
</div>
	  

	<?= $this->render('_form', [
        'model' => $model,
		'form' => $form,
    ]) ?>
	
	
	

    <div class="form-group">
        <?= Html::submitButton('Save Semester', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>


<?php
$js = "

$('#semester-year_start').change(function(e, data){
	var val = parseInt($(this).val());
	var end = val + 1;
	$('#semester-year_end').val(end);
});

";

$this->registerJs($js);

?>

    

</div>
