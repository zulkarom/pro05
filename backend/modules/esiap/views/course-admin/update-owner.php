<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\modules\staff\models\Staff;
use backend\modules\esiap\models\Program;
use backend\modules\esiap\models\CourseType;
use backend\models\Faculty;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Update: ' . $model->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Courses Owners', 'url' => ['course-admin/course-owner']];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="row">
<div class="col-md-6">



<?php $form = ActiveForm::begin(['id' => 'update-course']); ?>

<div class="box">
<div class="box-header">
<div class="box-title">Course Owner</div>
</div>
<div class="box-body"><div class="course-update">



<div class="form-group">

<label class="control-label">Course Owner</label>

<?php 


echo Select2::widget([
    'name' => 'staff_pic',
    'value' => ArrayHelper::map($model->coursePics, 'staff_id', 'staff_id'),
    'data' => Staff::listAcademicStaffArray(),
    'options' => ['multiple' => true, 'placeholder' => 'Select staff ...']
]);

?>

</div>


<div class="form-group">

<label class="control-label">Course Viewer</label>

<?php 


echo Select2::widget([
    'name' => 'staff_access',
    'value' => ArrayHelper::map($model->courseAccesses, 'staff_id', 'staff_id'),
    'data' => Staff::listAcademicStaffArray(),
    'options' => ['multiple' => true, 'placeholder' => 'Select staff ...']
]);

?>

</div>





</div>
</div>



   




</div>

 <div class="form-group">
	<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>


</div></div>


