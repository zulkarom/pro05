<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Slider;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SliderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Web Sliders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="slider-index">

    <p>
        <?= Html::a('Create Slider', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           
            [
                'attribute' => 'image_path',
                'format' => 'raw',
                'value' => function ($model) {
                    if (!$model->image_path) {
                        return '';
                    }
                    $base = isset(Yii::$app->params['image_url']) ? rtrim(Yii::$app->params['image_url'], '/') : '';
                    $src = $base ? ($base . $model->image_path) : $model->image_path;
                    return Html::img($src, ['style' => 'max-width:120px;']);
                },
            ],
            [
                'label' => 'Heading',
                'format' => 'raw',
                'value' => function ($model) {
                    $lines = [];
                    if ($model->heading_line1) { $lines[] = Html::encode($model->heading_line1); }
                    if ($model->heading_line2) { $lines[] = Html::encode($model->heading_line2); }
                    if ($model->heading_line3) { $lines[] = Html::encode($model->heading_line3); }
                    return implode('<br>', $lines);
                },
            ],
            [
                'attribute' => 'button_type',
                'filter' => Slider::buttonTypeList(),
                'value' => function ($model) {
                    return $model->getButtonLabel();
                },
            ],
            // 'sort_order',
            [
                'attribute' => 'is_active',
                'filter' => [0 => 'No', 1 => 'Yes'],
                'value' => function ($model) {
                    return $model->is_active ? 'Yes' : 'No';
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{preview} {up} {down} {toggle} {update} {delete}',
                'buttons' => [
                    'preview' => function ($url, $model) {
                        if (!$model->image_path) {
                            return '';
                        }
                        $base = isset(Yii::$app->params['image_url']) ? rtrim(Yii::$app->params['image_url'], '/') : '';
                        $src = $base ? ($base . $model->image_path) : $model->image_path;
                        return Html::a('Preview', $src, ['class' => 'btn btn-default btn-xs', 'target' => '_blank']);
                    },
                    'up' => function ($url, $model) {
                        return Html::a('Up', ['move-up', 'id' => $model->id], [
                            'class' => 'btn btn-default btn-xs',
                            'data' => ['method' => 'post'],
                        ]);
                    },
                    'down' => function ($url, $model) {
                        return Html::a('Down', ['move-down', 'id' => $model->id], [
                            'class' => 'btn btn-default btn-xs',
                            'data' => ['method' => 'post'],
                        ]);
                    },
                    'toggle' => function ($url, $model) {
                        $label = $model->is_active ? 'Deactivate' : 'Activate';
                        $class = $model->is_active ? 'btn btn-warning btn-xs' : 'btn btn-success btn-xs';
                        return Html::a($label, ['toggle-active', 'id' => $model->id], [
                            'class' => $class,
                            'data' => ['method' => 'post'],
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-xs']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-xs',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
</div>
</div>
