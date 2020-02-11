<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\ProgramVersion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="program-version-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'program_id')->textInput() ?>

    <?= $form->field($model, 'version_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'plo_num')->textInput() ?>

    <?= $form->field($model, 'is_developed')->textInput() ?>

    <?= $form->field($model, 'is_published')->textInput() ?>

    <?= $form->field($model, 'trash')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'prepared_by')->textInput() ?>

    <?= $form->field($model, 'prepared_at')->textInput() ?>

    <?= $form->field($model, 'verified_by')->textInput() ?>

    <?= $form->field($model, 'verified_at')->textInput() ?>

    <?= $form->field($model, 'faculty_approve_at')->textInput() ?>

    <?= $form->field($model, 'senate_approve_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
