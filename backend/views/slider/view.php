<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Slider */

$this->title = 'Slider #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Web Sliders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="slider-view">

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'image_path',
            [
                'label' => 'Preview',
                'format' => 'raw',
                'value' => $model->image_path ? Html::img($model->image_path, ['style' => 'max-width:400px;']) : '',
            ],
            'heading_line1',
            'heading_line2',
            'heading_line3',
            [
                'attribute' => 'button_type',
                'value' => $model->getButtonLabel(),
            ],
            'sort_order',
            [
                'attribute' => 'is_active',
                'value' => $model->is_active ? 'Yes' : 'No',
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
</div>
</div>
