<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'course_code',
            'course_name',
            
			'component.name',
			[
				'attribute' => 'campus_1',
				'label' => 'Bachok',
				'format' => 'html',
				'value' => function($model){
					if($model->campus_1 == 1){
						return '<span class="label label-success">YES</span>';
					}else{
						return '<span class="label label-danger">NO</span>';
					}
				}
			]
			,
			[
				'attribute' => 'campus_2',
				'label' => 'Kota',
				'format' => 'html',
				'value' => function($model){
					if($model->campus_2 == 1){
						return '<span class="label label-success">YES</span>';
					}else{
						return '<span class="label label-danger">NO</span>';
					}
				}
			],
			[
				'attribute' => 'campus_3',
				'label' => 'Jeli',
				'format' => 'html',
				'value' => function($model){
					if($model->campus_3 == 1){
						return '<span class="label label-success">YES</span>';
					}else{
						return '<span class="label label-danger">NO</span>';
					}
				}
			],
			
			['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['course/update/', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    }
                ],
            
            ],


        ],
    ]); ?>
</div>
</div>
</div>