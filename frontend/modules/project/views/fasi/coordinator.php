<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Senarai Kursus Sebagai Penyelaras (Kertas Kerja)';
$this->params['breadcrumbs'][] = 'Penyelaras';
?>
<div class="coordinator-index">

<i>* Bagi kursus yang tidak mempunyai fasilitator melalui e-Fasi</i>
<div class="box">
<div class="box-header">
</div>
<div class="box-body">    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
				'label' => 'Kursus',
				'value' => function($model){
					return $model->course->course_code . ' '.  strtoupper($model->course->course_name) . ' ('.$model->group->group_name.')';
				}
				
			],
			
			[
				'label' => 'Status',
				'format' => 'html',
				'value' => function($model){
					if($model->project){
						return $model->project->statusLabel;
					}
					
				}
				
			],
			
			[
				'label' => 'Kata Kunci',
				'format' => 'html',
				'value' => function($model){
					if($model->project){
						return '<b style="font-family:courier">' .$model->project->pro_token . '</b>';
					}
					
				}
				
			],
			

           ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{view} {update} {key}',
                //'visible' => false,
                'buttons'=>[
                    'view'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-search"></span> Lihat',['coor-view', 'id' => $model->project->id],['class'=>'btn btn-default btn-sm']);
                    },
					'update'=>function ($url, $model) {
                        return '<a href=" ' . Url::to(['/project/update/index', 'token' => $model->project->pro_token]) . '" class="btn btn-default btn-sm" target="_blank">Kemaskini</a>';
                    },
					'key'=>function ($url, $model) {
                        return Html::a('Tukar Kata Kunci',['coor-key', 'id' => $model->project->id],['class'=>'btn btn-default btn-sm']);
                    },
					
                ],
            
            ],
        ],
    ]); ?></div>
</div>
</div>
