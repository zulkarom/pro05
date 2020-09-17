<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TmplOfferFasiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tmpl-offer-fasi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'template_name') ?>

    <?= $form->field($model, 'pengarah') ?>

    <?= $form->field($model, 'yg_benar') ?>

    <?= $form->field($model, 'tema') ?>

    <?php // echo $form->field($model, 'nota_elaun') ?>

    <?php // echo $form->field($model, 'per3') ?>

    <?php // echo $form->field($model, 'per4') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
