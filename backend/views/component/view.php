<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Component */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Components', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="component-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

 <div class="box">
<div class="box-header"></div>
<div class="box-body">   <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description:ntext',
        ],
    ]) ?></div>
</div>

</div>
