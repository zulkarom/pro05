<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\ProgramStructure */

$this->title = 'Update Program Structure: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Program Structures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="program-structure-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
