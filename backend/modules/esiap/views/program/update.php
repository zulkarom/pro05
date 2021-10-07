<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\esiap\models\ProgramCategory;
use backend\modules\esiap\models\StudyMode;
use backend\modules\esiap\models\ProgramLevel;
use backend\models\Department;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\modules\staff\models\Staff;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Program */

$this->title = 'Update Program';
$this->params['breadcrumbs'][] = ['label' => 'Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="program-update">

  <?php $form = ActiveForm::begin(); ?>

<div class="box box-primary">
<div class="box-header"></div>
<div class="box-body"><div class="program-form">

  

    <?= $form->field($model, 'pro_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pro_name_bi')->textInput(['maxlength' => true]) ?>
	
	<div class="row">
<div class="col-md-6"> <?= $form->field($model, 'program_code')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-6"> 


<?= $form->field($model, 'pro_level')->dropDownList(
        ArrayHelper::map(ProgramLevel::find()->all(),'id', 'level_name'), ['prompt' => 'Please Select' ]
    ) ?>


</div>

<div class="col-md-6">
<?= $form->field($model, 'status')->dropDownList( [1 => 'YES' , 0 => 'NO'] ) ?>

</div>

</div>

   <div class="row">
<div class="col-md-6">

<?= $form->field($model, 'department_id')->dropDownList(
        ArrayHelper::map(Department::find()->all(),'id', 'dep_name'), ['prompt' => 'Please Select' ]
    ) ?>




</div>

<div class="col-md-6"><?= $form->field($model, 'pro_cat')->dropDownList(
        ArrayHelper::map(ProgramCategory::find()->all(),'id', 'cat_name'), ['prompt' => 'Please Select' ]
    ) ?>
</div>

</div>
	
    <div class="row">
<div class="col-md-6"> <?= $form->field($model, 'grad_credit')->textInput() ?></div>

<div class="col-md-6">



<?= $form->field($model, 'study_mode')->dropDownList(
        ArrayHelper::map(StudyMode::find()->all(),'id', 'mode_name'), ['prompt' => 'Please Select' ]
    ) ?>

</div>

</div>


   

</div>


   

 

</div></div>




 <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"> </i> SAVE PROGRAM', ['class' => 'btn btn-primary']) ?>
    </div>


   <?php ActiveForm::end(); ?>

</div>
