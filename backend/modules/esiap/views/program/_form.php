<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\esiap\models\ProgramCategory;
use backend\modules\esiap\models\StudyMode;
use backend\modules\esiap\models\ProgramLevel;
use backend\models\Department;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Program */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="program-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pro_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pro_name_bi')->textInput(['maxlength' => true]) ?>
	
	<div class="row">
<div class="col-md-3"> <?= $form->field($model, 'pro_name_short')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-3"> 


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

<?= $form->field($model, 'department')->dropDownList(
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

   


   

<div class="row">
<div class="col-md-6"> <?= $form->field($model, 'synopsis')->textarea(['rows' => 6]) ?></div>

<div class="col-md-6"> <?= $form->field($model, 'synopsis_bi')->textarea(['rows' => 6]) ?>
</div>

</div>
   

   

</div>


    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"> </i> SAVE PROGRAM INFO', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
