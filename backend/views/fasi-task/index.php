<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fasi Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fasi-task-index">

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><p>
        <?= Html::a('Create Fasi Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
		
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
			[
				'attribute' => 'task_text',
				'format' => 'ntext',
				'contentOptions' => [ 'style' => 'width: 80%;' ],
			]
           ,

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
	</div>
	
	</div>
</div>
</div>
