<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\Project */

$this->title = 'Kemaskini Kata Laluan';
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
