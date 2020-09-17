<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TmplOfferFasi */

$this->title = 'Create Template';
$this->params['breadcrumbs'][] = ['label' => 'Tmpl Approve Letter', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tmpl-offer-fasi-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
