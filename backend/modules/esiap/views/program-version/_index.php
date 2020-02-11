<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\ProgramVersionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Program Versions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="program-version-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Program Version', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'program_id',
            'version_name',
            'status',
            'plo_num',
            //'is_developed',
            //'is_published',
            //'trash',
            //'created_by',
            //'created_at',
            //'updated_at',
            //'prepared_by',
            //'prepared_at',
            //'verified_by',
            //'verified_at',
            //'faculty_approve_at',
            //'senate_approve_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
