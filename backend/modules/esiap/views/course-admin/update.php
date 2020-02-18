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
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="row">
<div class="col-md-6">



<?php $form = ActiveForm::begin(['id' => 'update-course']); ?>


<div class="box box-primary">
<div class="box-header">
<div class="box-title">Main Setting</div>
</div>
<div class="box-body"><div class="course-update">



<div class="row">

<div class="col-md-6"><?= $form->field($model, 'course_code')->textInput(['maxlength' => true]) ?>
</div>

</div>




<?= $form->field($model, 'course_name')->textInput(['maxlength' => true]) ?>


	<?= $form->field($model, 'course_name_bi')->textInput(['maxlength' => true]) ?>
	<div class="row">

<div class="col-md-4"><?= $form->field($model, 'credit_hour')->textInput(['maxlength' => true]) ?></div>

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
	
	


<div class="row">
<div class="col-md-4">

<?= $form->field($model, 'is_dummy')->dropDownList( [ 0 => 'NO', 1 => 'YES' ] ) ?>

</div>

<div class="col-md-4">

<?= $form->field($model, 'is_active')->dropDownList( [ 0 => 'NO', 1 => 'YES' ] ) ?>

</div>

<div class="col-md-4">

<?= $form->field($model, 'method_type')->dropDownList( [ 1 => 'Classroom', 0 => 'Non-Classroom' ] ) ?>

</div>

</div>

</div>



<div class="form-group">

<label class="control-label">Staff in charge for development</label>

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

<label class="control-label">Staff can view</label>

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



    <div class="form-group">
	<?= Html::a("<span class='glyphicon glyphicon-arrow-left'></span> BACK", ['course-admin/index'] ,['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE COURSE', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>




</div>

<div class="col-md-6">


<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
	
	<a id="modalButton" class="btn btn-success btn-sm" href="<?= Url::to(['course-version-create', 'course' => $model->id])?>"><span class="glyphicon glyphicon-plus"></span> New Version</a>
    </p>

    <div class="box box-warning">
<div class="box-header"></div>
<div class="box-body">

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => 'Version Name',
				'format' => 'html',
				'value' => function($model){
					return $model->version_name . '<br />(' . 
					$model->versionType->type_name . ')' .
					'<br /> <i>'.date('d M Y', strtotime($model->created_at)).'</i>';
				}
			],
			
			[
                'label' => 'Publish',
				'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'is_published', [1=>'YES', 2 => 'NO'],['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->labelPublished;
					
				}
                
            ],
            
			[
                'label' => 'Development',
				'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'is_developed', [1=>'YES', 2 => 'NO'],['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->labelActive . ' ' . $model->labelStatus;
					
				}
                
            ],
			
			

            

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						return '
						<div class="dropdown">
  <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Actions & Report
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a class="modalButton-update" href="'.Url::to(['/esiap/course-admin/course-version-update', 'id' => $model->id]).'">UPDATE</a></li>
    <li><a target="_blank" href="'.Url::to(['/esiap/course/fk1', 'course' => $model->course_id, 'version' => $model->id]).'">FK1</a></li>
    <li><a target="_blank" href="'.Url::to(['/esiap/course/fk2', 'course' => $model->course_id, 'version' => $model->id]).'">FK2</a></li>
	<li><a target="_blank" href="'.Url::to(['/esiap/course/fk3', 'course' => $model->course_id, 'version' => $model->id]).'">FK3</a></li>
	<li><a target="_blank" href="'.Url::to(['/esiap/course/tbl4', 'course' => $model->course_id, 'version' => $model->id]).'">TABLE 4 PDF</a></li>
	<li><a target="_blank" href="'.Url::to(['/esiap/course/tbl4-excel', 'course' => $model->course_id, 'version' => $model->id]).'">TABLE 4 EXCEL</a></li>
  </ul>
</div>
						
						';
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>


</div>

</div>

<?php 

Modal::begin([
    'header' => '<h4>Create Course Version</h4>',
    'id' =>'modal',
    'size' => 'modal-lg'
]);

echo '<div id="modalContent"></div>';

Modal::end();

Modal::begin([
    'header' => '<h4>Update Course Version</h4>',
    'id' =>'modal-update',
    'size' => 'modal-lg'
]);

echo '<div id="modalContent-update"></div>';

Modal::end();



$this->registerJs('

$(function(){
  $("#modalButton").click(function(e){
	   e.preventDefault();
      $("#modal").modal("show")
        .find("#modalContent")
        .load($(this).attr("href"));
  });
});

$(function(){
  $(".modalButton-update").click(function(e){
	   e.preventDefault();
      $("#modal-update").modal("show")
        .find("#modalContent-update")
        .load($(this).attr("href"));
  });
});

');


?>