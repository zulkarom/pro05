<?php

use richardfan\widget\JSRegister;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\modules\esiap\models\Course;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Create New Course Information Version';
$this->params['breadcrumbs'][] = ['label' => 'Course Version', 'url' => ['manage-version', 'course' => $course->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<h4><?=$course->course_code?> <?=$course->course_name?></h4>

    <?php $form = ActiveForm::begin(['id' => 'new-version-form']); ?> 
    
 <div class="box">
<div class="box-header"></div>
<div class="box-body">

<div class="row">
<div class="col-md-6">
<?= $form->field($model, 'version_name', ['template' => "{label}{input}<i>* e.g. 'Second Version', 'Version 2.0', 'Version Sem Feb 2020/2021', 'Version New Syllabus' etc.</i>{error}"]
    )->textInput(['maxlength' => true])->label('Version Name') ?>


</div></div>



<div class="row">
<div class="col-md-6">


<div id="con_version">

<?= $form->field($model, 'justification')->textarea(['rows' => 3])->label('Justification of having this Version') ?>

<?= $form->field($model, 'what_change')->textarea(['rows' => 3])->label('What changes of this version from previous version') ?>

</div>

</div>

</div>

<div class="row">
	<div class="col-md-3">
	<?= $form->field($model, 'is_developed')->dropDownList([1=>'YES', 0 => 'NO']) ?>
	
	</div>
	<div class="col-md-3">
	<?= $form->field($model, 'is_published')->dropDownList([1=>'YES', 0 => 'NO']) ?>
	
	</div>
</div>



</div>
</div>







    <div class="form-group">
        <?= Html::submitButton('UPDATE VERSION', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>





