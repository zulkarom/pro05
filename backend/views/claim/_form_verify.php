<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Application */
/* @var $form yii\widgets\ActiveForm */


$form = ActiveForm::begin(); ?>

<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">BORANG SOKONGAN</h3>

</div>
<div class="box-body">


   

	
	
<div class="row">
<div class="col-md-7"><?= $form->field($model, 'verify_note')->textarea(['rows' => '4'])  ?></div>

</div>
    

    

</div>
</div>


<div class="form-group">
		
	<?=Html::submitButton('Sokong Tuntutan', 
	['class' => 'btn btn-warning', 'name' => 'wfaction', 'value' => 'btn-verify', 'data' => [
                'confirm' => 'Pasti Sokong?'
            ],
	])?>

    </div>
<?php 
ActiveForm::end(); 