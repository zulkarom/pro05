<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Semesters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="semester-index">

    <p>
        <?= Html::a('Create Semester', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
				'attribute' => 'id',
				'label' => 'Semester',
				'value' => function($model){
					return $model->niceFormat();
					
				}
			],
			[
				'attribute' => 'is_current',
				'label' => 'Current *',
				'format' => 'html',
				'value' => function($model){
					if($model->is_current == 1){
						return '<span class="label label-success">YES</span>';
					}else{
						return '<span class="label label-danger">NO</span>';
					}
					
				}
			]
            ,
			
            'date_start:date',
            'date_end:date',
			[
				'attribute' => 'is_open',
				'label' => 'Open ***',
				'format' => 'html',
				'value' => function($model){
					if($model->is_open == 1){
						return '<span class="label label-success">YES</span>';
					}else{
						return '<span class="label label-danger">NO</span>';
					}
					
				}
			]
            ,
            'open_at:date',
            'close_at:date',

			
			['class' => 'yii\grid\ActionColumn',
				 'contentOptions' => ['style' => 'width: 8.7%'],
				'template' => '{update}',
				'buttons'=>[
					'update'=>function ($url, $model) {
						return '<a href="'.Url::to(['semester/update', 'id' => $model->id]).'" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> Update</a>';
					}
				],
			
			],

			
			
        ],
    ]); ?>
	
	<?= $this->render('_note') ?>
	
	
	</div>
</div>
</div>


