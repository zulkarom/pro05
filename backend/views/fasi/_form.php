<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Fasi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fasi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'address_postal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_home')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birth_date')->textInput() ?>

    <?= $form->field($model, 'birth_place')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'citizen')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'marital_status')->textInput() ?>

    <?= $form->field($model, 'handphone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'distance_umk')->textInput() ?>

    <?= $form->field($model, 'position_work')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position_grade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'department')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'salary_grade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'salary_basic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_office')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'office_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'office_fax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'in_study')->textInput() ?>

    <?= $form->field($model, 'umk_staff')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
