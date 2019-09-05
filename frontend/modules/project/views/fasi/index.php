<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\project\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = strtoupper('Projek Pelajar: Semester '. $semester->niceFormat());
$this->params['breadcrumbs'][] = 'Projek';
?>
<div class="project-index">
<h4></h4>
    <p>
        <?= Html::a('Tambah Projek', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

   <div class="box">
<div class="box-header"></div>
<div class="box-body"> <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
			[
				'attribute' => 'pro_name',
				'label' => 'Kertas Kerja',
				
			],

            
			'pro_token',
            

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update} {page}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/project/fasi/update/', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
					
					'page'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-truck"></span> Go To Page',['/project/student/update/', 'id' => $model->id],['class'=>'btn btn-info btn-sm']);
                    },
					
                ],
            
            ],
        ],
    ]); ?></div>
</div>

</div>
