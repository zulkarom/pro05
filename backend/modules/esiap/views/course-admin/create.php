<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\esiap\models\Program;
use backend\models\Faculty;
use backend\modules\esiap\models\CourseType;


/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Create Course';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-create">
<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="box box-primary">
<div class="box-body"><div class="course-update">



<div class="row">

<div class="col-md-6"><?= $form->field($model, 'course_code')->textInput(['maxlength' => true]) ?>
</div>


</div>


<?= $form->field($model, 'course_name')->textInput(['maxlength' => true]) ?>


	<?= $form->field($model, 'course_name_bi')->textInput(['maxlength' => true]) ?>
	
	
	<div class="row">


<div class="col-md-3"><?= $form->field($model, 'credit_hour')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-8">
<?= $form->field($model, 'course_type')->dropDownList(ArrayHelper::map(CourseType::find()->where(['showing' => 1])->orderBy('type_order ASC')->all(),'id', 'type_name'), ['prompt' => 'Please Select' ]) ?>
</div>

</div>



<?= $form->field($model, 'program_id')->dropDownList(
        ArrayHelper::map(Program::find()->where(['faculty_id' => Yii::$app->params['faculty_id'], 'trash' => 0])->all(),'id', 'pro_name'), ['prompt' => 'Please Select' ]
    ) ?>

<?php 
if($model->faculty_id == 0){
	$model->faculty_id = Yii::$app->params['faculty_id'];
}
echo $form->field($model, 'faculty_id')->dropDownList(
        ArrayHelper::map(Faculty::find()->where(['showing' => 1])->all(),'id', 'faculty_name'), ['prompt' => 'Please Select' ]
    ) ?>



<?= $form->field($model, 'is_dummy')->dropDownList( [ 0 => 'NO', 1 => 'YES' ] ) ?>
</div></div>
</div>


    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> CREATE COURSE', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
