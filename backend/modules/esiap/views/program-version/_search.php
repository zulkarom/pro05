<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\ProgramVersionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="program-version-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'program_id') ?>

    <?= $form->field($model, 'version_name') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'plo_num') ?>

    <?php // echo $form->field($model, 'is_developed') ?>

    <?php // echo $form->field($model, 'is_published') ?>

    <?php // echo $form->field($model, 'trash') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'prepared_by') ?>

    <?php // echo $form->field($model, 'prepared_at') ?>

    <?php // echo $form->field($model, 'verified_by') ?>

    <?php // echo $form->field($model, 'verified_at') ?>

    <?php // echo $form->field($model, 'faculty_approve_at') ?>

    <?php // echo $form->field($model, 'senate_approve_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
