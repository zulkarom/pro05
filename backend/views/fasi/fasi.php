<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Active Fasilitators';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fasi-index">
<?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="box">
<div class="box-header"></div>
<div class="box-body">





   <div class="table-responsive"> <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
			 'attribute' => 'fullname',
			 'label' => 'Nama Fasilitator',
			 'contentOptions' => [ 'style' => 'width: 30%;' ],
			 'value' => function($model){
					return strtoupper($model->fasi->user->fullname);
			 }
			],
			
			[
			 'label' => 'Course',
			 'contentOptions' => [ 'style' => 'width: 20%;' ],
			 'value' => function($model){
					return strtoupper($model->acceptedCourse->course->course_name);
			 }
			],
			
			//AcceptedCourse
			
			[
			 'label' => 'Campus',
			 'value' => function($model){
					return strtoupper($model->campus->campus_name);
			 }
			],


            ['class' => 'yii\grid\ActionColumn',
				 'contentOptions' => ['style' => 'width: 19%'],
				'template' => '{application} {view} {login}',
				
				'buttons'=>[
					'login'=>function ($url, $model) {
						return '<a href="'.Url::to(['/fasi/login-fasi', 'id' => $model->fasi->user_id]).'" target="_blank" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-lock"></span> Login as</a>';
					},
					'view'=>function ($url, $model) {
						return '<a href="'.Url::to(['/fasi/view', 'id' => $model->fasi->id]).'" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-user"></span></a>';
					},
					'application'=>function ($url, $model) {
						return '<a href="'.Url::to(['/application/view', 'id' => $model->id]).'" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-search"></span></a>';
					}

				],
			
			],

        ],
    ]); ?></div></div>
</div>
</div>
