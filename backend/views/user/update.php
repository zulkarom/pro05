<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Update: ' . $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="form-group">
<?=Html::a('<h4><i class="fa fa-arrow-left"></i> </h4>', ['index']) ?>
</div>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="users-update">



<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true])->label('Username') ?>

	
	<?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
	
	 <?= $form->field($model, 'rawPassword')->passwordInput(['maxlength' => true])->label('Reset Password (leave blank if no change)') ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>  

        <?php 
        
        if($model->confirmed_at > 0){
            echo Html::a('Unconfirm Email', ['deactivate', 'id' => $model->id],  ['class' => 'btn btn-danger']); 
        }else{
            echo Html::a('Manually Confirm Email', ['activate', 'id' => $model->id], ['class' => 'btn btn-warning']);
        }
        
        ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div></div>
</div>
