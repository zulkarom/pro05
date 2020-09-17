<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users List';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="form-group"><?=Html::a('Create User', ['create'], ['class' => 'btn btn-success'])?></div>


<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="users-index">


	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' =>'username',
				'label' => 'Username'
			]
            ,
            //'authKey',
            // 'accessToken',
            [
				'attribute' =>'fullname',
				'label' => 'Nama Penuh',
				'value' => function($model){
					return strtoupper($model->fullname);
				}
			],
            'email',
 

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['user/update/', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    }
                ],
            
            ],

        ],
    ]); ?>
	
	
	
	
	
</div></div>
</div>
