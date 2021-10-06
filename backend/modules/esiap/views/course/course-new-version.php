<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Create New Course Information Version';
$this->params['breadcrumbs'][] = ['label' => 'Course Version', 'url' => ['manage-version', 'course' => $course->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<h4><?=$course->course_code?> <?=$course->course_name?></h4>

    <?php $form = ActiveForm::begin(['id' => 'new-version-form']); ?> 
    
 <div class="box box-solid">
<div class="box-body">
NOTE: Names of academic staff in TABLE 4 document will be automatically adjusted to reflect the team teaching staff for the respective semester on the course file module.
<br /><br />
<div class="row">
<div class="col-md-6">
<?= $form->field($model, 'version_name', ['template' => "{label}{input}<i>* e.g. 'Version Sem Feb 2020/2021', 'Full Online Version', 'Version 2.0', 'Version New Syllabus' etc.</i>{error}"]
    )->textInput(['maxlength' => true])->label('New Version Name') ?>


</div></div>



<div class="row">
<div class="col-md-6">


<div id="con_version">
<?= $form->field($model, 'duplicated_from')->dropDownList( ArrayHelper::map($course->courseVersion, 'id' , 'version_name') )->label('Duplicate From Version') ?>

<?= $form->field($model, 'justification')->textarea(['rows' => 3])->label('Justification of creating new version') ?>

<?= $form->field($model, 'what_change')->textarea(['rows' => 3])->label('Explain what changes to be made') ?>

</div>

</div>

</div>



</div>
</div>







    <div class="form-group">
        <?= Html::submitButton('CREATE VERSION', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>





