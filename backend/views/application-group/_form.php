<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Campus;

/* @var $this yii\web\View */
/* @var $model common\models\ApplicationGroup */
/* @var $form yii\widgets\ActiveForm */

$campusList = ArrayHelper::map(Campus::find()->all(), 'id', 'campus_name');
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="application-group-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'campus_id')->dropDownList($campusList, ['prompt' => 'Select']) ?>

    <?= $form->field($model, 'group_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
</div>
