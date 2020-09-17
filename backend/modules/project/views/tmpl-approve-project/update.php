<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TmplOfferFasi */

$this->title = 'Update Template';
$this->params['breadcrumbs'][] = ['label' => 'Tmpl Approve Letter', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tmpl-offer-fasi-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
