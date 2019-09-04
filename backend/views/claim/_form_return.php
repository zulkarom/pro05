<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Application */
/* @var $form yii\widgets\ActiveForm */

$form = ActiveForm::begin(); ?>

<div class="box">
<div class="box-body">
<div class="row">
<div class="col-md-7">
<?= $form->field($model, 'return_note')->textarea(['rows' => '4'])  ?>
</div>
</div>
</div>
</div>


<div class="form-group">
		
<?=Html::submitButton('Kembalikan Tuntutan', 
[
'class' => 'btn btn-warning', 
'name' => 'wfaction', 
'value' => 'btn-return', 
'data' => [
			'confirm' => 'Adakah anda pasti untuk kembalikan borang tuntutan ini kepada fasilitor?'
		],
])?>

    </div>
<?php 
ActiveForm::end(); 