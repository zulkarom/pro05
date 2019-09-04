<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Course Nomenclature';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="course-update">

<div class="course-form">

<?php $form = ActiveForm::begin(); ?>
	
<div class="box">
<div class="box-header"></div>
<div class="box-body">	

<div class="row">
<div class="col-md-4"><?= $form->field($model, 'course_code')->textInput(['maxlength' => true]) ?></div>
<div class="col-md-2"><?= $form->field($model, 'credit_hour')->textInput() ?></div>
<div class="col-md-3">



 <?php
 
 if($version->senate_approve_at == '0000-00-00'){
	 $version->senate_approve_at = date('Y-m-d');
 }
 
 
 echo $form->field($version, 'senate_approve_at')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);

?>

</div>
</div>

<div class="row">
<div class="col-md-6"> <?= $form->field($model, 'course_name')->textInput(['maxlength' => true]) ?>
</div>
<div class="col-md-3">



 <?php
 
 if($version->faculty_approve_at == '0000-00-00'){
	 $version->faculty_approve_at = date('Y-m-d');
 }
 
 
 echo $form->field($version, 'faculty_approve_at')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
])->label('Faculty/Center Approve at');

?>

</div>
</div>

    <div class="row">

<div class="col-md-6"><?= $form->field($model, 'course_name_bi')->textInput(['maxlength' => true]) ?>
</div>

</div>


    
</div>
</div>


    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE COURSE NOMENCLATURE', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


</div>
