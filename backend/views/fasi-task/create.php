<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FasiTask */

$this->title = 'Create Fasi Task';
$this->params['breadcrumbs'][] = ['label' => 'Fasi Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fasi-task-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
