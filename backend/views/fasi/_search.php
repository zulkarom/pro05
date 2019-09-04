<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FasiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fasi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'year_register') ?>

    <?= $form->field($model, 'gender') ?>

    <?= $form->field($model, 'address_postal') ?>

    <?php // echo $form->field($model, 'address_home') ?>

    <?php // echo $form->field($model, 'birth_date') ?>

    <?php // echo $form->field($model, 'birth_place') ?>

    <?php // echo $form->field($model, 'nric') ?>

    <?php // echo $form->field($model, 'citizen') ?>

    <?php // echo $form->field($model, 'marital_status') ?>

    <?php // echo $form->field($model, 'handphone') ?>

    <?php // echo $form->field($model, 'distance_umk') ?>

    <?php // echo $form->field($model, 'position_work') ?>

    <?php // echo $form->field($model, 'position_grade') ?>

    <?php // echo $form->field($model, 'department') ?>

    <?php // echo $form->field($model, 'salary_grade') ?>

    <?php // echo $form->field($model, 'salary_basic') ?>

    <?php // echo $form->field($model, 'address_office') ?>

    <?php // echo $form->field($model, 'office_phone') ?>

    <?php // echo $form->field($model, 'office_fax') ?>

    <?php // echo $form->field($model, 'in_study') ?>

    <?php // echo $form->field($model, 'umk_staff') ?>

    <?php // echo $form->field($model, 'staff_no') ?>

    <?php // echo $form->field($model, 'profile_file') ?>

    <?php // echo $form->field($model, 'nric_file') ?>

    <?php // echo $form->field($model, 'salary_file') ?>

    <?php // echo $form->field($model, 'path_file') ?>

    <?php // echo $form->field($model, 'personal_updated_at') ?>

    <?php // echo $form->field($model, 'job_updated_at') ?>

    <?php // echo $form->field($model, 'expe_updated_at') ?>

    <?php // echo $form->field($model, 'edu_updated_at') ?>

    <?php // echo $form->field($model, 'document_updated_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
