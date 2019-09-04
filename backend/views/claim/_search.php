<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ClaimSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
	'action' => ['index'],
	'method' => 'get',
]); ?>
	
<div class="row">
<div class="col-md-8"></div>
<div class="col-md-4"><?= $form->field($model, 'fasi_name', ['addon' => ['prepend' => ['content'=>'<span class="glyphicon glyphicon-search"></span>']]])->label(false)->textInput(['placeholder' => "Cari Fasilitator..."]) ?></div>
</div>

<?php ActiveForm::end(); ?>

