<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ApplicationGroup */

$this->title = 'Update Application Group';
$this->params['breadcrumbs'][] = ['label' => 'Application Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->group_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="application-group-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
