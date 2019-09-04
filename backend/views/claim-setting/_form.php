<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ClaimSetting */
/* @var $form yii\widgets\ActiveForm */
$hb = array();
for($i=1;$i<=31;$i++){
	$hb[$i] = $i;
}
?>

<div class="claim-setting-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
<div class="col-md-3"><?= $form->field($model, 'hour_max_month')->textInput() ?></div>
<div class="col-md-3"><?= $form->field($model, 'hour_max_sem')->textInput() ?></div>

</div>

	<div class="row">
<div class="col-md-3"><?= $form->field($model, 'claim_due_at')->dropDownList( $hb) ?></div>
<div class="col-md-3">
<?= $form->field($model, 'block_due')->dropDownList( [1 => 'YES', 0 => 'NO']) ?>

</div>

</div>

    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
