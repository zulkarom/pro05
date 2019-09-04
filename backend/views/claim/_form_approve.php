<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$form = ActiveForm::begin(); ?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">BORANG KELULUSAN</h3>

</div>
<div class="box-body"> <?=$form->field($model, 'approve_note')->textarea(['rows' => '3']) ?></div>
</div>

 

  <?=$form->field($model, 'approved_at')->hiddenInput(['value' => time()])->label(false)?>



<div class="form-group">
		
	<?=Html::submitButton('Lulus Tuntutan', ['class' => 'btn btn-success', 'name' => 'wfaction', 'value' => 'btn-approve', 'data' => [
                'confirm' => 'Pasti Lulus?'
            ],
])?>

    </div>
<?php 

ActiveForm::end(); 
