<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\GeneralSetting */

$this->title = 'Update General Setting';
$this->params['breadcrumbs'][] = ['label' => 'General Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="general-setting-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
