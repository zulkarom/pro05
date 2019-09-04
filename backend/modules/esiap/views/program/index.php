<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\ProgramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Programs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="program-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Program', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'pro_level',
				'value' => function($model){
					return $model->programLevel->level_name;
				}
				
			],
            'pro_name',
			[
				'attribute' => 'status',
				'value' => function($model){
					if($model->status == 1){
						return 'YES';
					}else{
						return 'NO';
					}
					
				}
				
			],
            

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['/esiap/program/update/', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
					'delete'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['/esiap/program/delete/', 'id' => $model->id],['class'=>'btn btn-danger btn-sm', 'data' => [
                'confirm' => 'Are you sure to delete this event?'
            ],
]);
                    }
                ],
            
            ],
        ],
    ]); ?>
</div>
</div>
</div>
