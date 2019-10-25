<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Fasi;
use common\models\ApplicationGroup;
use backend\models\Course;
use backend\models\Campus;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\Coordinator */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header">
<h3 class="box-title"></h3>
</div>
<div class="box-body"><div class="coordinator-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
<div class="col-md-10">


<div class="row">

<div class="col-md-8">  <?php
echo $form->field($model, 'fasi_id')->widget(Select2::classname(), [
    'data' => Fasi::listFasiArray(),
    'language' => 'de',
    'options' => ['multiple' => false,'placeholder' => 'Pilih Penyelaras ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Penyelaras');

?>

</div>



</div>

   <div class="row">
<div class="col-md-8"><?= $form->field($model, 'course_id')->dropDownList(Course::listCourseArray()) ?></div>

</div> 

   <div class="row">
<div class="col-md-8"><?= $form->field($model, 'campus_id')->dropDownList(ArrayHelper::map(Campus::find()->all(), 'id', 'campus_name')) ?></div>

</div> 


   <div class="row">

<div class="col-md-4"><?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map(ApplicationGroup::find()->all(), 'id', 'group_name')) ?>
</div>

</div> 

   

   

    





</div>
</div>
	
	    <div class="form-group">
        <?= Html::submitButton('Tambah', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
</div>
