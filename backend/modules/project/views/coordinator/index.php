<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\project\models\CoordinatorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Senarai Penyelaras (Tujuan Kertas Kerja)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coordinator-index">

    <p>
        <?= Html::a('Tambah Penyelaras', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

   <div class="box">
<div class="box-header">
<h3 class="box-title"></h3>
</div>
<div class="box-body">
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
			
            ['class' => 'yii\grid\SerialColumn'],
            [
				'label' => 'Penyelaras',
				'value' => function($model){
					return strtoupper($model->fasi->user->fullname);
				}
				
			],
			[
				'label' => 'Kursus',
				'value' => function($model){
					return $model->course->course_code . ' '.  strtoupper($model->course->course_name);
				}
				
			],
			[
				'label' => 'Kampus',
				'value' => function($model){
					return $model->campus->campus_name;
				}
				
			],
			[
				'label' => 'Kelas',
				'value' => function($model){
					return $model->group->group_name;
				}
				
			],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Kemaskini',['update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
					'delete'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['delete', 'id' => $model->id],['class'=>'btn btn-danger btn-sm', 'data' => [
                'confirm' => 'Are you sure to delete this coordinator?'
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
