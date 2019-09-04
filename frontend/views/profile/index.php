<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use common\models\Common;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Fasi */
/* @var $form ActiveForm */

$this->title = "MAKLUMAT PERIBADI";

?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="profile-index">

    <?php $form = ActiveForm::begin()?>
	
	<div class="row">
<div class="col-md-5"><?= $form->field($model, 'fullname')->textInput(['disabled' => 'disabled', 'value' => $model->user->fullname]) ?></div>
<div class="col-md-2"><?= $form->field($model, 'nric')->textInput(['disabled' => 'disabled']) ?></div>

<div class="col-md-3">

<?= $form->field($model, 'email')->textInput(['disabled' => 'disabled', 'value' => $model->user->email]) ?>

 
 </div>
</div>

<div class="row">
<div class="col-md-3"><?= $form->field($model, 'handphone') ?></div>
<div class="col-md-3"><?= $form->field($model, 'gender')->dropDownList(
        Common::gender(), ['prompt' => 'Please Select' ]
    ) ?></div>

<div class="col-md-3"><?= $form->field($model, 'marital_status')->dropDownList(
        Common::marital(), ['prompt' => 'Please Select' ]
    ) ?>
</div>

<div class="col-md-3">

<?php 

if(!$model->citizen){
	$model->citizen = 'Malaysia';
}


echo $form->field($model, 'citizen')->dropDownList(
        Common::citizen(), ['prompt' => 'Please Select' ]
    ) ?>

</div>

</div>


<div class="row">
<div class="col-md-6"><?= $form->field($model, 'address_postal')->textarea(['rows' => '3'])->label('Alamat Surat Menyurat<br />
				<i><small style="font-weight:normal">(alamat yang akan digunakan dalam surat tawaran lantikan)</small></i>')?></div>
<div class="col-md-6">

<?= $form->field($model, 'address_home')->textarea(['rows' => '3']) ?>
</div>
</div>


<div class="row">
<div class="col-md-2">
<?=$form->field($model, 'birth_date')->widget(DatePicker::classname(), [
	'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
		'format' => 'yyyy-mm-dd',
		'todayHighlight' => true,
		
    ],
	
	
]);

?>

</div>
<div class="col-md-4"><?= $form->field($model, 'birth_place') ?></div>

<div class="col-md-2">

<?= $form->field($model, 'distance_umk', [
    'addon' => ['append' => ['content'=>'KM']]
]); ?>


</div>

<div class="col-md-2">
<div class="form-group">
<label>Status</label>
<div><?=$model->profileStatus('personal_updated_at');?></div>
<div></div>
</div>
</div>


</div>



 
        
    
        <div class="form-group">
            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span>  Simpan Maklumat Peribadi', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- profile-index --></div>
</div>

