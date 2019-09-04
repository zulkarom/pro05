<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SessionTime */

$this->title = 'Update Session Time: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Session Times', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="session-time-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
