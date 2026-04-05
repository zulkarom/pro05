<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use backend\models\Campus;

/* @var $this yii\web\View */
/* @var $model common\models\ApplicationGroup */

$this->title = $model->group_name;
$this->params['breadcrumbs'][] = ['label' => 'Application Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$campusList = ArrayHelper::map(Campus::find()->all(), 'id', 'campus_name');
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="application-group-view">

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
            [
                'attribute' => 'campus_id',
                'value' => isset($campusList[$model->campus_id]) ? $campusList[$model->campus_id] : $model->campus_id,
            ],
            'group_name',
        ],
    ]) ?>

</div>
</div>
</div>
