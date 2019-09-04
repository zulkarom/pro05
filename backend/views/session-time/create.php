<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SessionTime */

$this->title = 'Create Session Time';
$this->params['breadcrumbs'][] = ['label' => 'Session Times', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="session-time-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
