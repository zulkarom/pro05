<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\esiap\models\CourseType;
use backend\modules\esiap\models\CourseVersion;
use backend\modules\esiap\models\Course;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\ProgramStructure */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="program-structure-form">

    <?php $form = ActiveForm::begin(); ?>
		<div class="row">

<div class="col-md-3">  <?= $form->field($model, 'year')->dropDownList([1=>1, 2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8], ['prompt' => 'Please Select' ])  ?>
</div>
<div class="col-md-3"><?= $form->field($model, 'sem_num')->dropDownList([1=>1, 2=>2,3=>3], ['prompt' => 'Please Select' ]) ?>
</div>



</div>


<div class="row">
<div class="col-md-8">  
 
 <?php 
 if(!$model->isNewRecord){
	 $model->course_id = $model->courseVersion->course_id;
 }
 
 echo $form->field($model, 'course_id') ->dropDownList(
        ArrayHelper::map(Course::activeCoursesNameCode(),'id', 'course_code_name'), [
		'prompt' => 'Please Select',
		'onchange'=>'
             $.post("'.Yii::$app->urlManager->createUrl('/esiap/program/course-version-list?id=').
           '"+$(this).val(),function( data ) 
            {$( "select#programstructure-crs_version_id" ).html( data );
                 });'
		]) ?>

<?php 
$list = [];
 if(!$model->isNewRecord){
	 $course_id = $model->courseVersion->course_id;
	 $list = ArrayHelper::map(CourseVersion::find()->where(['course_id' => $course_id])->orderBy('created_at DESC')->all(),'id', 'version_name');
	 
 }


echo $form->field($model, 'crs_version_id')->dropDownList($list, ['prompt' => 'Please Select']) ?>


</div>

</div>
  
	
	<div class="row">
<div class="col-md-4"> 

<?= $form->field($model, 'course_type_id') ->dropDownList(
        ArrayHelper::map(CourseType::find()->orderBy('type_order ASC')->all(),'id', 'type_name'), ['prompt' => 'Please Select' ]
    ) ?>
</div>




</div>

   

    

  


    <div class="form-group">
        <?= Html::submitButton('Include Course', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

