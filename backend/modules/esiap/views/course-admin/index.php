<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;



$exportColumns = [
	['class' => 'yii\grid\SerialColumn'],
			'course_code',
            'course_name',
			'course_name_bi',
			'credit_hour',
			[
				'attribute' => 'program.pro_name_short',
				'label' => 'Program',
			],
			
            [
                'label' => 'Published',
                'format' => 'html',
                'value' => function($model){
					if($model->publishedVersion){
						$lbl = 'YES';
						$color = 'success';
					}else{
						$lbl =  'NO';
						$color = 'danger';
					}
					
					return '<span class="label label-'.$color.'">'.$lbl.'</span>';
                    
                }
            ],
			[
                'label' => 'Dev Status',
                'format' => 'html',
                
                'value' => function($model){
					if($model->developmentVersion){
						return $model->developmentVersion->labelStatus;
					}else{
						return 'NONE';
					}
                    
                }
            ],

];
?>
<div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<div class="row">
<div class="col-md-6">
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> New Course', ['create'], ['class' => 'btn btn-success']) ?>  
		
		<?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $exportColumns,
	'filename' => 'COURSE_DATA_' . date('Y-m-d'),
	'onRenderSheet'=>function($sheet, $grid){
		$sheet->getStyle('A2:'.$sheet->getHighestColumn().$sheet->getHighestRow())
		->getAlignment()->setWrapText(true);
	},
	'exportConfig' => [
        ExportMenu::FORMAT_PDF => false,
		ExportMenu::FORMAT_EXCEL_X => false,
    ],
]);?>
		
		
		
 </div>

<div class="col-md-6" align="right">

<?=$this->render('_search', ['model' => $searchModel])?>
</div>

</div>


    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
         'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
		'export' => false,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'course_code',
				'contentOptions' => ['style' => 'width: 10%'],
				
			],
            
			[
				'attribute' => 'course_name',
				'contentOptions' => ['style' => 'width: 45%'],
				'format' => 'html',
				'label' => 'Course Name',
				'value' => function($model){
					return strtoupper($model->course_name) . ' / <i>' . strtoupper($model->course_name_bi) . '</i>';
				}
				
			],
            [
                'label' => 'Published',
                'format' => 'html',
                'value' => function($model){
					if($model->publishedVersion){
						$lbl = 'YES';
						$color = 'success';
					}else{
						$lbl =  'NO';
						$color = 'danger';
					}
					
					return '<span class="label label-'.$color.'">'.$lbl.'</span>';
                    
                }
            ],
			[
                'label' => 'Dev Status',
                'format' => 'html',
                
                'value' => function($model){
					if($model->developmentVersion){
						return $model->developmentVersion->labelStatus;
					}else{
						return 'NONE';
					}
                    
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 9%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/course-admin/update/', 'course' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },

                ],
            
            ],
        ],
    ]); ?></div>
</div>

</div>
