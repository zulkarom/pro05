<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Fasi */

$this->title = 'Create Fasi';
$this->params['breadcrumbs'][] = ['label' => 'Fasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fasi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
