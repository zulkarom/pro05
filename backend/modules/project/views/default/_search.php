<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\date\DatePicker;
use backend\models\Campus;

/* @var $this yii\web\View */
/* @var $model backend\models\ClaimSearch */
/* @var $form yii\widgets\ActiveForm */
?>



<div class="row">
<div class="col-md-8">

<?php $form = ActiveForm::begin([
    'action' => ['allocation'],
    'method' => 'get',
]); ?>
<div class="box box-primary">
<div class="box-header">
<h3 class="box-title"><span class="glyphicon glyphicon-search"></span> Search</h3>
</div>
<div class="box-body">

<div class="row">
<div class="col-md-3"><?= $form->field($model, 'campus_cari')->dropDownList(ArrayHelper::map(Campus::find()->all(), 'id', 'campus_short'), ['prompt' => 'All' ])->label('Kampus') ?></div>
<div class="col-md-3">

 <?=$form->field($model, 'approve_from')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
])->label('Tarikh Dari');
?>


</div>
<div class="col-md-3">
 <?=$form->field($model, 'approve_until')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
])->label('Tarikh Hingga');
?>
</div>

<div class="col-md-3">
<?= $form->field($model, 'batchno')->textInput()->label('Batch No.') ?>
</div>
</div>

 <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Cari', ['class' => 'btn btn-default']) ?>


</div>
</div>
<?php ActiveForm::end(); ?>


</div>

<div class="col-md-4">

<div class="box box-warning">
<div class="box-header">
<h3 class="box-title"><span class="fa fa-cubes"></span> Assign Batch</h3>
</div>
<div class="box-body">

<div class="form-group">
<label class="control-label">Batch No.</label>

<input type="text" id="batch-no-set" class="form-control" value="">

</div>

 <?= Html::button('<span class="fa fa-cubes"></span> Assign Selected', ['name' => 'btn-action', 'value' => 'disapprove', 'class' => 'btn btn-default']) ?>


</div>
</div>
</div>

</div>






