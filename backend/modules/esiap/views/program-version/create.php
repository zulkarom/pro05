<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\modules\esiap\models\Course;
use yii\helpers\ArrayHelper;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\CourseVersion */

$this->title = 'New Version: ' . $program->pro_name;
$this->params['breadcrumbs'][] = ['label' => 'Program Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-version-create">

<div class="course-version-form">

    <?php $form = ActiveForm::begin(); ?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">    

<?= $form->field($model, 'version_name')->textInput(['maxlength' => true]) ?>


<div class="row">
<div class="col-md-4">

<?= $form->field($model, 'is_developed')->dropDownList( [1 => 'YES' , 0 => 'NO'] ) ?>





</div>

<div class="col-md-2"><?php 

if((!$model->plo_num) or $model->plo_num == 0){
	$model->plo_num = $model->defaultPloNumber;
}

echo $form->field($model, 'plo_num')->dropDownList( $model->ploNumberArray ) ?>
</div>




</div>



</div>

</div>

    <div class="form-group">
        <?= Html::submitButton('CREATE PROGRAM VERSION', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
</div>




<?php JSRegister::begin(); ?>
<script>

$("#courseversion-duplicate").change(function(){
	var val = $(this).val();
	if(val == 1){
		$("#con_course").show();
		$("#con_version").show();
	}else{
		$("#con_course").hide();
		$("#con_version").hide();
	}
});

$("#courseversion-dup_course").change(function(){
	var course_id = $(this).val();
	$('#courseversion-dup_version').html('<option>Loading...</option>');
	var url = '<?=Url::to(['course-admin/list-version-by-course', 'course' => ''])?>' + course_id;
	$.ajax({url: url, success: function(result){
			var str = '';
			if(result){
				var version = JSON.parse(result);
				for(i=0;i<version.length;i++){
					//console.log(version[i].version_name);
					str += '<option value=\"' + version[i].id + '\">' + version[i].version_name  + '</option>';
				}
			}
			$('#courseversion-dup_version').html(str);
		}});
	
});
</script>
<?php JSRegister::end(); ?>
