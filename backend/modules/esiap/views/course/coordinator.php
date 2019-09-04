<?php

use yii\helpers\Html;
use common\models\User;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Update Coordinator for ' . $model->course_code .' '. $model->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="course-update">


<?php



/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-form">

    <?php $form = ActiveForm::begin(); ?>
	
<div class="box">
<div class="box-header"></div>
<div class="box-body">	

<div class="row">
<div class="col-md-6">

<?php 


echo $form->field($model, 'coordinator')->widget(Select2::classname(), [
    'data' => User::listFullnameArray(),
    'language' => 'de',
    'options' => ['multiple' => false,'placeholder' => 'Select...'],
])->label('Coordinator');

?>






</div>



</div>


    
</div>
</div>


    <div class="form-group">
	<?= Html::a('Back', ['/course/list'],['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Save Coordinator', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


</div>
