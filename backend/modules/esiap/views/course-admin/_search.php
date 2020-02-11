<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ClaimSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>
    
<?= $form->field($model, 'search_course', ['addon' => ['prepend' => ['content'=>'<span class="glyphicon glyphicon-search"></span>']]])->label(false)->textInput(['placeholder' => "search course..."]) ?>

<?php ActiveForm::end(); ?>
