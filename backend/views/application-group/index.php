<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\Campus;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ApplicationGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Application Groups';
$this->params['breadcrumbs'][] = $this->title;

$campusList = ArrayHelper::map(Campus::find()->all(), 'id', 'campus_name');
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="application-group-index">

    <p>
        <?= Html::a('Create Application Group', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'campus_id',
                'value' => function ($model) use ($campusList) {
                    return isset($campusList[$model->campus_id]) ? $campusList[$model->campus_id] : $model->campus_id;
                },
                'filter' => $campusList,
            ],
            'group_name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('View', $url, ['class' => 'btn btn-primary btn-sm']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
</div>
</div>
