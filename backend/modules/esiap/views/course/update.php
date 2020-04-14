<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\esiap\models\CourseType;
use backend\modules\esiap\models\CourseLevel;
use backend\modules\esiap\models\Program;
use backend\models\Department;


/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Course Information';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="course-update">


<div class="course-form">

<?=$this->render('_header',[
'course' => $model
])?>

    <?php $form = ActiveForm::begin(); ?>

	
<div class="box">
<div class="box-header"></div>
<div class="box-body">	

<div class="row">
<div class="col-md-4"><?= $form->field($model, 'course_code')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-2"><?= $form->field($model, 'credit_hour')->textInput() ?></div>

<div class="col-md-4">

<?= $form->field($model, 'course_level')->dropDownList(
        ArrayHelper::map(CourseLevel::find()->all(),'id', 'lvl_name'), ['prompt' => 'Please Select' ]
    ) ?>
</div>

</div>

    <div class="row">
<div class="col-md-6"> <?= $form->field($model, 'course_name')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-6"><?= $form->field($model, 'course_name_bi')->textInput(['maxlength' => true]) ?>
</div>

</div>

  <div class="row">


<div class="col-md-6">

<?= $form->field($model, 'program_id')->dropDownList(
        ArrayHelper::map(Program::find()->where(['faculty_id' => Yii::$app->params['faculty_id'], 'trash' => 0])->all(),'id', 'pro_name'), ['prompt' => 'Please Select' ]
    ) ?>

</div>

<div class="col-md-6">

<?= $form->field($model, 'department_id')->dropDownList(
        ArrayHelper::map(Department::find()->all(),'id', 'dep_name'), ['prompt' => 'Please Select' ]
    ) ?>



</div>

</div>


    
</div>
</div>


    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save Course Information', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


</div>
