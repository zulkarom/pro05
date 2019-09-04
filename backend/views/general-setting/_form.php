<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GeneralSetting */
/* @var $form yii\widgets\ActiveForm */
?>
 <?php $form = ActiveForm::begin(); ?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="general-setting-form">

   <div class="row">
<div class="col-md-6"><?= $form->field($model, 'faculty')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-6"> <?= $form->field($model, 'faculty_bi')->textInput(['maxlength' => true]) ?>
</div>

</div>

    <div class="row">
<div class="col-md-6"><?= $form->field($model, 'department')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-6"><?= $form->field($model, 'department_bi')->textInput(['maxlength' => true]) ?>
</div>

</div>

   <div class="row">
<div class="col-md-6">   <?= $form->field($model, 'program')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-6">  <?= $form->field($model, 'program_bi')->textInput(['maxlength' => true]) ?>
</div>

</div>



</div>
</div>
</div>

   <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

 <?php ActiveForm::end(); ?>