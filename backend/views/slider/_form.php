<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Slider;

/* @var $this yii\web\View */
/* @var $model common\models\Slider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="slider-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*']) ?>

    <?php if ($model->image_path) : ?>
        <div class="form-group">
            <?= Html::img($model->image_path, ['style' => 'max-width:300px;']) ?>
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'heading_line1')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'heading_line2')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'heading_line3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'button_type')->dropDownList(Slider::buttonTypeList()) ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'is_active')->dropDownList([1 => 'Yes', 0 => 'No']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
</div>
