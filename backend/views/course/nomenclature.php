<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Component;
use kartik\select2\Select2;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\Course */

$this->title = $model->course_code . ' ' . $model->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="course-update">

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="course-form">

<?php $form = ActiveForm::begin(); ?>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'component_id')->dropDownList(
        ArrayHelper::map(Component::find()->all(),'id', 'name'), ['prompt' => 'Please Select' ]
    ) ?></div>

<div class="col-md-6"><?= $form->field($model, 'course_code')->textInput(['maxlength' => true]) ?>
</div>

</div>

	
	<div class="row">
<div class="col-md-5"><?= $form->field($model, 'course_name')->textInput(['maxlength' => true]) ?></div>	
	<div class="col-md-5"><?= $form->field($model, 'course_name_bi')->textInput(['maxlength' => true]) ?></div>
	<div class="col-md-2"><?= $form->field($model, 'credit_hour')->textInput(['maxlength' => true]) ?></div>
	
</div>

<div class="row">
<div class="col-md-5">
<?php 
echo $form->field($model, 'coordinator')->widget(Select2::classname(), [
    'data' => User::listFullnameArray(),
    'language' => 'de',
    'options' => ['multiple' => false,'placeholder' => 'Select...'],
])->label('Coordinator');
?>

</div>		
</div>




   

    <div class="form-group">
	<?= Html::a('BACK', ['course/list'] ,['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('SAVE', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>

</div>
