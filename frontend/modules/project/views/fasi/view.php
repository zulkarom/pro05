<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\Project */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'pro_name',
            'date_start',
            'date_end',
            'location',
            'course_id',
            'semester_id',
            'collaboration',
            'purpose:ntext',
            'background:ntext',
            'pro_time',
            'pro_target',
            'agency_involved',
            'prepared_by',
            'fasi_id',
            'supported_by',
            'approved_by',
            'approval_note:ntext',
            'approved_at',
            'created_at',
            'supported_at',
            'updated_at',
        ],
    ]) ?>

</div>
