<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FasiTask */

$this->title = 'Update Fasi Task';
$this->params['breadcrumbs'][] = ['label' => 'Fasi Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fasi-task-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
