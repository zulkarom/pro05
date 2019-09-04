<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\CourseVersion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-version-form">

    <?php $form = ActiveForm::begin(); ?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">    

    <?= $form->field($model, 'version_name')->textInput(['maxlength' => true]) ?>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'is_active')->dropDownList( [1 => 'YES' , 0 => 'NO'] ) ?></div>

<div class="col-md-6"><?= $form->field($model, 'status')->dropDownList( $model->statusArray ) ?>
</div>

</div>
   
   
   </div>
</div>


    <div class="form-group">
        <?= Html::submitButton('SAVE COURSE VERSION', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
