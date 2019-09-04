<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Create Users';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-create">


   <div class="users-form">
   
   <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
			<?php $form = ActiveForm::begin(); ?>
			<div class="box-body">
			
			<div class="row">
<div class="col-md-6"><?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?></div>
<div class="col-md-6"><?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?></div>
</div>
			
		<div class="row">
<div class="col-md-6"> <?= $form->field($model, 'rawPassword')->passwordInput(['maxlength' => true]) ?></div>
<div class="col-md-6"><?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?></div>
</div>	

   
	<div class="row">
<div class="col-md-6"><?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></div>
</div>
	 

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
			
			</div>
			<?php ActiveForm::end(); ?>
	</div>



</div>

</div>
