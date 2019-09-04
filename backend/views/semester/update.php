<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Semester */

$this->title = 'Semester ' . $model->niceFormat() ;
$this->params['breadcrumbs'][] = ['label' => 'Semesters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="semester-update">


<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="semester-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<?= $form->errorSummary($model); ?>


	<?= $this->render('_form', [
        'model' => $model,
		'form' => $form,
    ]) ?>
	
	
	
	

    <div class="form-group">
        <?= Html::submitButton('Update Semester', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>


</div>
