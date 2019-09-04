<?php
use yii\helpers\Html;

use kartik\widgets\ActiveForm;

use common\models\Common;

$this->title = "MAKLUMAT PEKERJAAN";

/* @var $this yii\web\View */
/* @var $model common\models\Fasi */
/* @var $form ActiveForm */
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="profile-job">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">

<div class="col-md-4"><?= $form->field($model, 'position_work') ?></div>
<div class="col-md-4"><?= $form->field($model, 'position_grade') ?></div>

</div>

<div class="row">
<div class="col-md-4"><?= $form->field($model, 'department') ?></div>


<div class="col-md-4">
<?= $form->field($model, 'salary_basic', [
    'addon' => ['prepend' => ['content'=>'RM']]
]); ?>
</div>

</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'address_office')->textarea() ?></div>
<div class="col-md-3"><?= $form->field($model, 'office_phone') ?></div>
<div class="col-md-3"><?= $form->field($model, 'office_fax') ?></div>
</div>
        	
		<div class="row">
<div class="col-md-6"><?= $form->field($model, 'in_study')->dropDownList(
        Common::yesNo(), ['prompt' => 'Please Select' ]
    ) ?></div>
<div class="col-md-3"><?= $form->field($model, 'umk_staff')->dropDownList(
        Common::yesNo(), ['prompt' => 'Please Select' ]
    ) ?></div>
	
	<div class="col-md-2">
	
	<?= $form->field($model, 'staff_no') ?>
	
	</div>
	
</div>
		
<div class="row">
<div class="col-md-2">
<div class="form-group">
<label>Status</label>
<div><?=$model->profileStatus('job_updated_at');?></div>
<div></div>
</div>
</div>
</div>      
		
       
    
        <div class="form-group">
            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan Maklumat Pekerjaan', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- profile-job --></div>
</div>
