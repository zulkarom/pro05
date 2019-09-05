<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

   

   <div class="row">
<div class="col-md-8"> <?= $form->field($model, 'pro_name')->textInput(['maxlength' => true]) ?></div>

</div>
    <div class="form-group">
        <?= Html::submitButton('Simpan Projek', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
