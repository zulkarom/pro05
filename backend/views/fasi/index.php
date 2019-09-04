<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fasilitator';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fasi-index">

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
			 'attribute' => 'fullname',
			 'label' => 'Nama Fasilitator',
			 'value' => function($model){
				if($model->user){
					return strtoupper($model->user->fullname);
				}
			 }
			],
			'nric',
			'user.email',
			
			[
			 'label' => 'Daftar Pada',
			 'value' => function($model){
				if($model->user){
					return date('d M Y', $model->user->created_at);
				}
			 }
			],
            

            ['class' => 'yii\grid\ActionColumn',
				 'contentOptions' => ['style' => 'width: 8.7%'],
				'template' => '{view} {login}',
				
				'buttons'=>[
					'login'=>function ($url, $model) {
						return '<a href="'.Url::to(['/fasi/login-fasi', 'id' => $model->user_id]).'" target="_blank" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-lock"></span> Login</a>';
					},
					'view'=>function ($url, $model) {
						return '<a href="'.Url::to(['/fasi/view', 'id' => $model->id]).'" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-search"></span> View</a>';
					}

				],
			
			],

        ],
    ]); ?></div>
</div>
</div>
