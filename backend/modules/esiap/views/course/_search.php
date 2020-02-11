<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\CourseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'course_code') ?>

    <?= $form->field($model, 'course_name') ?>

    <?= $form->field($model, 'course_name_bi') ?>

    <?= $form->field($model, 'credit_hour') ?>

    <?php // echo $form->field($model, 'crs_type') ?>

    <?php // echo $form->field($model, 'crs_level') ?>

    <?php // echo $form->field($model, 'faculty') ?>

    <?php // echo $form->field($model, 'department') ?>

    <?php // echo $form->field($model, 'programme') ?>

    <?php // echo $form->field($model, 'is_dummy') ?>

    <?php // echo $form->field($model, 'trash') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
