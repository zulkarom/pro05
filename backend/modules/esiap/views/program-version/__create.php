<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\ProgramVersion */

$this->title = 'Create Program Version';
$this->params['breadcrumbs'][] = ['label' => 'Program Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="program-version-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
