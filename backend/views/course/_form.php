<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Component;

/* @var $this yii\web\View */
/* @var $model backend\models\Course */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="course-form">

    <?php $form = ActiveForm::begin(); ?>


<?php
//$model->campus_1 = 0;
//echo $form->field($model, 'campus_1')->checkbox(['label' => 'Kampus Bachok'])
echo $form->field($model, 'campus_1')->checkBox() ?>


<?= $form->field($model, 'campus_2')->checkbox(['value' => 1]) ?>
<?= $form->field($model, 'campus_3')->checkbox(['value' => 1]) ?>

   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>