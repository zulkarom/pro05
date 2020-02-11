<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\ProgramSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="program-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pro_name') ?>

    <?= $form->field($model, 'pro_name_bi') ?>

    <?= $form->field($model, 'pro_name_short') ?>

    <?= $form->field($model, 'pro_level') ?>

    <?php // echo $form->field($model, 'faculty') ?>

    <?php // echo $form->field($model, 'department') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'pro_cat') ?>

    <?php // echo $form->field($model, 'pro_field') ?>

    <?php // echo $form->field($model, 'grad_credit') ?>

    <?php // echo $form->field($model, 'prof_body') ?>

    <?php // echo $form->field($model, 'coll_inst') ?>

    <?php // echo $form->field($model, 'study_mode') ?>

    <?php // echo $form->field($model, 'sesi_start') ?>

    <?php // echo $form->field($model, 'pro_sustain') ?>

    <?php // echo $form->field($model, 'full_week_long') ?>

    <?php // echo $form->field($model, 'full_week_short') ?>

    <?php // echo $form->field($model, 'full_sem_long') ?>

    <?php // echo $form->field($model, 'full_sem_short') ?>

    <?php // echo $form->field($model, 'part_week_long') ?>

    <?php // echo $form->field($model, 'part_week_short') ?>

    <?php // echo $form->field($model, 'part_sem_long') ?>

    <?php // echo $form->field($model, 'part_sem_short') ?>

    <?php // echo $form->field($model, 'full_time_year') ?>

    <?php // echo $form->field($model, 'full_max_year') ?>

    <?php // echo $form->field($model, 'part_max_year') ?>

    <?php // echo $form->field($model, 'part_time_year') ?>

    <?php // echo $form->field($model, 'synopsis') ?>

    <?php // echo $form->field($model, 'synopsis_bi') ?>

    <?php // echo $form->field($model, 'objective') ?>

    <?php // echo $form->field($model, 'just_stat') ?>

    <?php // echo $form->field($model, 'just_industry') ?>

    <?php // echo $form->field($model, 'just_employ') ?>

    <?php // echo $form->field($model, 'just_tech') ?>

    <?php // echo $form->field($model, 'just_others') ?>

    <?php // echo $form->field($model, 'nec_perjawatan') ?>

    <?php // echo $form->field($model, 'nec_fizikal') ?>

    <?php // echo $form->field($model, 'nec_kewangan') ?>

    <?php // echo $form->field($model, 'kos_yuran') ?>

    <?php // echo $form->field($model, 'kos_beven') ?>

    <?php // echo $form->field($model, 'pro_tindih_pub') ?>

    <?php // echo $form->field($model, 'pro_tindih_pri') ?>

    <?php // echo $form->field($model, 'jumud') ?>

    <?php // echo $form->field($model, 'admission_req') ?>

    <?php // echo $form->field($model, 'admission_req_bi') ?>

    <?php // echo $form->field($model, 'career') ?>

    <?php // echo $form->field($model, 'career_bi') ?>

    <?php // echo $form->field($model, 'trash') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
