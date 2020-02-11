<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\ProgramVersion */

$this->title = 'Update Program Version: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Program Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="program-version-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
