<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'General Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="general-setting-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create General Setting', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'faculty',
            'faculty_bi',
            'department',
            'department_bi',
            //'program',
            //'program_bi',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
