<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use backend\models\Component;
use backend\modules\esiap\models\Program;

/* @var $this yii\web\View */
/* @var $model backend\models\ClaimSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
	'id' => 'form-index-course',
    'method' => 'get',
]); ?>
    
<div class="row">
<div class="col-md-6"><?= $form->field($model, 'search_course', ['addon' => ['prepend' => ['content'=>'<span class="glyphicon glyphicon-search"></span>']]])->label(false)->textInput(['placeholder' => "search course..."]) ?>
</div>

<div class="col-md-3">

<?php 

echo $form->field($model, 'study_level')->label(false)->dropDownList($model->getStudyLevelList(), ['prompt' => 'Select Level' ]);

 ?>

</div>

<div class="col-md-3">

<?php 
if(Yii::$app->params['faculty_id'] == 21 ){
	echo $form->field($model, 'search_cat')->label(false)->dropDownList(
        ArrayHelper::map(Component::find()->all(),'id', 'name'), ['prompt' => 'Select Component' ]);
}else{
	echo $form->field($model, 'search_cat')->label(false)->dropDownList(
        ArrayHelper::map(Program::find()->where(['faculty_id' => Yii::$app->params['faculty_id'], 'status' => 1, 'trash' => 0])->all(),'id', 'pro_name_short'), ['prompt' => 'Select Program' ]);
}

 ?>

</div>



</div>

<?php ActiveForm::end(); ?>


<?php 
$this->registerJs('
$("#'.$element.'").change(function(){
	$("#form-index-course").submit();
});


$("#courseadminsearch-study_level").change(function(){
	$("#form-index-course").submit();
});

');

?>