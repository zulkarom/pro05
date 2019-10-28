<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\project\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'KELULUSAN KERTAS KERJA';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">
<?php $form = ActiveForm::begin(); ?>
    <div class="box">
<div class="box-body"><div class="table-responsive">

<?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        //'filterModel' => $searchModel,
        'columns' => [
			['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],
            
            [
				'attribute' => 'pro_name',
				'format' => 'raw',
				'value' => function($model){
					return  '<a href="'.Url::to(['/project-admin/default/pdf', 'id' => $model->id]).'" target="_blank">' . strtoupper($model->pro_name) . '</a><br/>(' . $model->projectDate . ')';
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
			
			[
				'attribute' => 'submitted_at',
				'label' => 'Tarikh Hantar',
				'format' => 'html',
				'value' => function($model){
					return 'Hantar: ' . date('d M Y', strtotime($model->submitted_at)) . '<br />Semak: '. date('d M Y', strtotime($model->checked_at)) ;
				}
				
			],
			
			[
				'attribute' => 'approved_at',
				'format' => 'html',
				'value' => function($model){
					return $model->approvedDate;
				}
				
			],
	
            [
				'attribute' => 'status_num',
				'label' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->statusLabel;
				}
				
			],

            
        ],
    ]); ?></div></div>
</div>

<div class="form-group">
        
<?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> APPROVE SELECTED', ['name' => 'btn-action', 'value' => 'approve', 'class' => 'btn btn-primary']) ?>



 &nbsp;
 
 
 <?= Html::submitButton('<span class="glyphicon glyphicon-remove"></span> DISAPPROVE SELECTED', ['name' => 'btn-action', 'value' => 'disapprove', 'class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>


