<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'SENARAI TUNTUTAN';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="claim-index">

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> PERMOHONAN TUNTUTAN', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
				
			[
				'label' => 'Subjek',
				'value' => function($model){
					$course = $model->application->acceptedCourse->course;
					return $course->course_code . ' ' . $course->course_name;
				}
			],
            [
				'label' => 'Bulan',
				'attribute' => 'month',
				'value' => function($model){
					return $model->monthName();
				}
			],
			'year',
			[
				'label' => 'Jumlah Tuntutan',
				'value' => function($model){
					$rate = $model->application->rate_amount;
					return 'RM' . number_format($model->total_hour * $rate , 0);
				}
			]
			,
            [
			 'attribute' => 'status',
			 'label' => 'Status',
			 'format' => 'html',
			 'value' => function($model){
				 return $model->wfLabel; 
				 
				 }


			],

            ['class' => 'yii\grid\ActionColumn',
				 'contentOptions' => ['style' => 'width: 8.7%'],
				'template' => '{view}',
				//'visible' => false,
				'buttons'=>[
					'view'=>function ($url, $model) {
						if($model->wfStatus == 'draft' or $model->wfStatus == 'returned'){
							return '<a href="'.Url::to(['/claim/update/', 'id' => $model->id]).'" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span> UPDATE</a>';
						}else{
							return '<a href="'.Url::to(['/claim/update/', 'id' => $model->id]).'" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-search"></span> VIEW</a>';
						}
						
					}
				],
			
			],
        ],
    ]); ?>
</div></div>
</div>
