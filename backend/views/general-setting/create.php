<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\GeneralSetting */

$this->title = 'Create General Setting';
$this->params['breadcrumbs'][] = ['label' => 'General Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="general-setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
