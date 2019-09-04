<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


$form = ActiveForm::begin(); ?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">BORANG KELULUSAN</h3>

</div>
<div class="box-body"> <?=$form->field($model, 'approve_note')->textarea(['rows' => '3']) ?></div>
</div>
<input type="hidden" name="form-choice" value="btn-approve" />

  <?=$form->field($model, 'approved_at')->hiddenInput(['value' => time()])->label(false)?>



<div class="form-group">

   <?=Html::button('Kembali Ke Sokongan',
	['class' => 'btn btn-warning', 'id' => 'kembali'
	])?>
		
	<?=Html::submitButton('Lulus Permohonan', ['class' => 'btn btn-success', 'name' => 'wfaction', 'value' => 'btn-approve', 'data' => [
                'confirm' => 'Adakah anda pasti untuk meluluskan permohonan ini?'
            ],
])?>

    </div>
<?php 

ActiveForm::end(); 

$js = '
$("#kembali").click(function(){
	var what = confirm("Adalah anda pasti untuk menghantar balik permohonan ini kepada proses sokongan?");
	if(what){
		window.location.href = "'.Url::to(['application/return-verify', 'id' => $model->id ]).'";
	}
});




';

$this->registerJs($js);

