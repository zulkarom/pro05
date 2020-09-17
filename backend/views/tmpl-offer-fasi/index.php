<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TmplOfferFasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Offer Letter Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tmpl-offer-fasi-index">


  <div class="box">
<div class="box-header"></div>
<div class="box-body">  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'template_name',
            'pengarah',
            'created_at:date',
            
			[
				'attribute' => 'is_active',
				'value' => function($model){
					return  $model->is_active == 1 ? 'Yes' : 'No';
				}
				
			],

			['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update} {copy}',
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
					'copy'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-copy"></span> Copy',['create', 'id' => $model->id],['class'=>'btn btn-success btn-sm']);
                    },
					
                ],
            
            ],
			
			
        ],
    ]); ?></div>
</div>

</div>
