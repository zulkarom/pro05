<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Course Proforma: ' . $model->course->course_name . ' '. $model->course->course_code;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>

 <?php $form = ActiveForm::begin(); ?>
	
<div class="box">
<div class="box-header"></div>
<div class="box-body">	

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'prerequisite')->dropDownList($model->course->allCoursesArray()) ?></div>

</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'synopsis')->textarea(['rows' => '6']) ?></div>

<div class="col-md-6"><?= $form->field($model, 'synopsis_bi')->textarea(['rows' => '6']) ?></div>

</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'objective')->textarea(['rows' => '6']) ?></div>

<div class="col-md-6"><?= $form->field($model, 'objective_bi')->textarea(['rows' => '6']) ?></div>
</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'rational')->textarea(['rows' => '6']) ?></div>

<div class="col-md-6"><?= $form->field($model, 'rational_bi')->textarea(['rows' => '6']) ?></div>


</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'transfer_skill')->textarea(['rows' => '6']) ?></div>

<div class="col-md-6"><?= $form->field($model, 'transfer_skill_bi')->textarea(['rows' => '6']) ?></div>


</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'feedback')->textarea(['rows' => '6']) ?></div>

<div class="col-md-6"><?= $form->field($model, 'feedback_bi')->textarea(['rows' => '6']) ?></div>


</div>


    
</div>
</div>


    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE COURSE PROFORMA', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


