<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'EFASI REGISTRATION';
$this->params['breadcrumbs'][] = $this->title;

$fieldOptionsFullname = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptionsUsername = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>
<div class="register-box">
  <div class="register-logo">
    <a href="#"><b>EFASI</b></a>
  </div>

  <div class="register-box-body">
    <p class="login-box-msg">Register a new fasilitator</p>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form
            ->field($model, 'fullname', $fieldOptionsFullname)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('fullname')]) ?>
			

                <?= $form
				->field($model, 'username', $fieldOptionsUsername)
				->label(false)
				->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>
				
				<?= $form
            ->field($model, 'user_email', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('user_email')]) ?>
				
				<?= $form
				->field($model, 'rawPassword', $fieldOptions2)
				->label(false)
				->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
				
				<?= $form
				->field($model, 'password_repeat', $fieldOptions2)
				->label(false)
				->passwordInput(['placeholder' => $model->getAttributeLabel('password_repeat')]) ?>


                <div class="form-group">
                    <?= Html::submitButton('DAFTAR', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>


  </div>
  <!-- /.form-box -->
</div>