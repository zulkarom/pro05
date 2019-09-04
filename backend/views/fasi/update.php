<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Fasi */

$this->title = 'Update Fasi: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Fasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="fasi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
