<?php
use backend\models\Semester;
use yii\widgets\ActiveForm;
?>

<?php 

$form = ActiveForm::begin([
'id' => 'sel-sem-form',
'action' => $model->action,
'method' => 'get',

]); ?>  
<div class="row">
	
<div class="col-md-6">
<?= $form->field($model, 'semester_id')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>
</div>
</div>
    <?php ActiveForm::end(); ?>

<?php 

$this->registerJs('

$("#semesterform-semester_id").change(function(){
	$("#sel-sem-form").submit();
});

');

?>