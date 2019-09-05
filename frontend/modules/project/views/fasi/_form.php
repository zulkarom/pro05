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

   <?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>

   <div class="row">
<div class="col-md-8"> <div class="form-group"><label>KATA LALUAN SEMASA:</label>
<h3 style="font-family:courier; font-size:40px;font-weight:bold"><?=$model->pro_token?></h3>

</div><br /></div>

</div>
    <div class="form-group">
        <?= Html::submitButton('Dapatkan Kata Laluan Baru', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
