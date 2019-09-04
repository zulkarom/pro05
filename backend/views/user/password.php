<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Change Password';
?>
<div class="users-update">

 <h1><?= Html::encode($this->title) ?></h1>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    	<div class="row">
	<div class="col-md-6">
	<?= $form->field($model, 'rawPassword')->passwordInput(['maxlength' => true]) ?></div>
	</div>
	
	<div class="row">

	<div class="col-md-6">  
	<?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?></div>
	</div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
