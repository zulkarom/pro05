<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ApplicationGroup */

$this->title = 'Create Application Group';
$this->params['breadcrumbs'][] = ['label' => 'Application Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="application-group-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
