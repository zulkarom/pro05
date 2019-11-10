<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\project\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'MILESTONE';
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
            ['class' => 'yii\grid\SerialColumn'],
            
            
			[
				'attribute' => 'fasi',
				'format' => 'raw',
				'label' => 'Fasililator',
				'value' => function($model){
					if($model->fasi){
						$coor = '';
						if($model->coordinator){
							$coor = '<br /><i>(Penyelaras)</i>';
						}
						if($model->course){
							$course = $model->course->course_name;
						}else{
							$course = '';
						}
						return '<a href="'.Url::to(['../../project/' . $model->pro_token]).'" target="_blank">' . strtoupper($model->fasi->user->fullname) . '<br />' . $course
					 . ' ('. $model->group->group_name.')' . $coor . '</a>';
					}
					
					;
				}
			],
			
			
			
            [
				'attribute' => 'status_num',
				'label' => 'Status',
				'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'status_num', $searchModel->statusList()[0],['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->statusLabel;
				}
				
			],
			
			[
				'label' => 'Progress',
				'contentOptions' => [ 'style' => 'width: 30%;' ],
				'format' => 'html',
				'value' => function($model){
					$per = $model->projectMilestone + 0;
					if($per < 50){
						$color = 'danger';
					}else if($per < 100){
						$color = 'warning';
					}else{
						$color = 'success';
					}
					return '<div class="progress progress-lg active">
                <div class="progress-bar progress-bar-'.$color.' progress-bar-striped" role="progressbar" aria-valuenow="'.$per.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$per.'%">
                  <span class="sr-only">'.$per.'% Complete</span>
                </div>
              </div>
			  '.$per .'% Complete
			  ';
				}
				
			],

			
			
            
        ],
    ]); ?></div></div>
</div>




