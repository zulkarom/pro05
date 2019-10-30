<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\project\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'SENARAI KERTAS KERJA';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">
    <div class="box">
<div class="box-body"><div class="table-responsive">

<?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        'filterModel' => $searchModel,
        'columns' => [
			['class' => 'yii\grid\CheckboxColumn'],
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
					if($model->fasi){
						$coor = '';
						if($model->coordinator){
							$coor = '<br /><i>(Penyelaras)</i>';
						}
						return strtoupper($model->fasi->user->fullname) . '<br />' . 
					$model->course->course_name . ' ('. $model->group->group_name.')' . $coor;
					}
					
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
                'contentOptions' => ['style' => 'width: 24%'],
                'template' => '{edit} {pdf} {return}',
                'buttons'=>[
					'edit'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> EDIT',['/project-admin/default/update', 'id' => $model->id], ['class'=>'btn btn-default btn-sm']);
                    },
					
                    'pdf'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-download-alt"></span> PDF',['/project-admin/default/pdf', 'id' => $model->id], ['class'=>'btn btn-danger btn-sm', 'target' => '_blank']);
                    },
					
					'return'=>function ($url, $model) {
						if($model->status >= 20){
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




