<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Senarai Kursus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="course-index">

<?=$this->render('_search', ['model' => $searchModel])?>	
	

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
			
			 'label' => 'Course Code / Course Name',
			 'contentOptions' => [ 'style' => 'width: 27%;' ],
			 'value' => function($model){
				 return strtoupper($model->course_code .' / '. $model->course_name);
			 }
			],
			
			[
				'attribute' => 'coor.fullname',
				'label' => 'Koordinator',
				'value' => function($model){
					if($model->coor){
						return strtoupper($model->coor->fullname);
					}
				}
			]
			,
			[
                'label' => 'Status',
                'format' => 'html',
                
                'value' => function($model){
					if($model->developmentVersion){
						 return $model->developmentVersion->labelStatus;
					}
                   
                }
            ],

            

			
			['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 25%'],
                'template' => '{update} {version} {report}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['course/nomenclature/', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
					'version'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-search"></span> Version',['/esiap/course/course-version', 'course' => $model->id],['class'=>'btn btn-info btn-sm']);
                    },
					'coor'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-user"></span> Penyelaras',['/esiap/course/coordinator/', 'course' => $model->id],['class'=>'btn btn-primary btn-sm']);
                    },
					'report'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-pie-chart"></span> Report',['/esiap/course/report/', 'course' => $model->id],['class'=>'btn btn-danger btn-sm']);
                    }
                ],
            
            ],


        ],
    ]); ?>
</div>
</div>
</div>