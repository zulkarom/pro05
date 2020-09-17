<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Upload;

/* @var $this yii\web\View */
/* @var $model backend\models\TmplOfferFasi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="tmpl-offer-fasi-form">

    <?php $form = ActiveForm::begin(); ?>
 <?= $form->field($model, 'template_name')->textInput(['maxlength' => true]) ?>
 
 <div class="row">
<div class="col-md-6"> <?= $form->field($model, 'yg_benar')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-6"><?= $form->field($model, 'pengarah')->textInput(['maxlength' => true]) ?>
</div>

</div>
 
 
    

   

    <?= $form->field($model, 'tema')->textarea(['rows' => 2]) ?>


    <?= $form->field($model, 'per3')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'per4')->textarea(['rows' => 6]) ?>
	
	 <?= $form->field($model, 'per5')->textarea(['rows' => 6]) ?>
	
	<?= $form->field($model, 'is_active')->dropDownList([1 => 'Yes', 0 => 'No'])?>
	
	
	<div class="row">
	<div class="col-md-9">
	<?=Upload::fileInput($model, 'signiture', true)?>
	* png file with transparent background. Suggested dimension (131 x 122)
	<br /><br />
	</div>
<div class="col-md-3">
<?= $form->field($model, 'adj_y')->textInput(['maxlength' => true]) ?>
</div>


</div>
	
	
	{FASILITATOR} = fasilitator/pembantu fasilitator<br /><br />
    <div class="form-group">
        <?= Html::submitButton('SAVE TEMPLATE', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
</div>

