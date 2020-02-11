<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\ProgramStructure */

$this->title = 'Add New Course';
$this->params['breadcrumbs'][] = ['label' => 'Program Structures', 'url' => ['structure', 'program' => $program->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="program-structure-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
