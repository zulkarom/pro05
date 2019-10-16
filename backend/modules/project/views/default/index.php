<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\project\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'SENARAI KERTAS KERJA';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="table-responsive"><?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            [
				'attribute' => 'pro_name',
				'format' => 'raw',
				'value' => function($model){
					return '<a href="'.Url::to(['../../project/' . $model->pro_token]).'" target="_blank">' . strtoupper($model->pro_name) . '</a><br/>(' . $model->projectDate . ')';
				}
				
			],
			[
				'attribute' => 'fasi',
				'format' => 'html',
				'label' => 'Fasililator',
				'value' => function($model){
					$app = $model->application;
					return strtoupper($app->fasi->user->fullname) . '<br />' . 
					$app->acceptedCourse->course->course_name . ' ('. $app->applicationGroup->group_name.')';
					;
				}
			],
			
			'pro_fund',
			'pro_expense',
            [
				'attribute' => 'status_num',
				'label' => 'Status',
				'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'status_num', $searchModel->statusList()[0],['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->statusLabel;
				}
				
			],

			
			['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 17%'],
                'template' => '{pdf} {return}',
                'buttons'=>[
                    'pdf'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-download-alt"></span> PDF',['/project-admin/default/pdf', 'id' => $model->id], ['class'=>'btn btn-danger btn-sm', 'target' => '_blank']);
                    },
					
					'return'=>function ($url, $model) {
						if($model->status == 20){
							return Html::a('<span class="fa fa-reply"></span> KEMBALI',['/project-admin/default/return', 'id' => $model->id],['class'=>'btn btn-warning btn-sm', 'data' => [
                'confirm' => 'Adakah anda pasti untuk kembalikan kertas kerja kepada fasilitator untuk disemak?',
                'method' => 'post',
            ],
]);
						}
                        
                    },
                ],
            
            ],
            
        ],
    ]); ?></div></div>
</div>