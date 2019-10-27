<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\project\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'SURAT KELULUSAN';
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
				'label' => 'Peruntukan',
				'value' => function($model){
					return $model->resourceCenterAmount->rs_amount;
				}
				
			],	
            'letter_ref',
			
			['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-download-alt"></span> PDF',['/project-admin/default/letter-print', 'id' => $model->id],['class'=>'btn btn-danger btn-sm', 'target' => '_blank']);
                    },
					
                ],
            
            ],

            
        ],
    ]); ?></div></div>
</div>


<div class="row">
<div class="col-md-6">
<div class="box">
<div class="box-header"></div>
<div class="box-body">


<div class="row">
<div class="col-md-8"><?=$form->field($model, 'ref_letter')?></div>
<div class="col-md-4"><?=$form->field($model, 'start_number')->textInput(['style' => 'width:70%']) ?></div>
</div>








</div>
</div>

<div class="form-group">
        
<?= Html::submitButton('Generate Reference', ['class' => 'btn btn-warning', 'name'=> 'actiontype', 'value' => 'generate']) ?>
    </div>


</div>

</div>


</div>



    <?php ActiveForm::end(); ?>


