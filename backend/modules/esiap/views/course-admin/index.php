<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Active Courses';
$this->params['breadcrumbs'][] = $this->title;



$exportColumns = [
	
	['class' => 'yii\grid\SerialColumn'],
			'course_code',
            'course_name',
			'course_name_bi',
			'credit_hour',
            'study_level',
			[
				'attribute' => 'program.pro_name_short',
				'label' => 'Program',
			],
			
            [
                'label' => 'Publish',
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
                'label' => 'Development',
                'format' => 'html',
                
                'value' => function($model){
					if($model->developmentVersion){
						return $model->developmentVersion->labelStatus;
					}else{
						return 'NONE';
					}
                    
                }
            ],
			
			[
				'label' => 'Course Owner',
				'format' => 'html',
				'value' => function($model){
					return $model->picStr;
				}
				
			],
			
			[
				'label' => 'Course Viewer',
				'format' => 'html',
				'value' => function($model){
					return $model->staffViewStr;
				}
				
			]

];
?>
<div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<div class="row">
<div class="col-md-3">
       <div class="form-group"> <?= Html::a('<span class="glyphicon glyphicon-plus"></span> New Course', ['create'], ['class' => 'btn btn-success']) ?>  
		
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
]);?></div>
		
		
		
 </div>

<div class="col-md-9" align="right">

<?=$this->render('_search', ['model' => $searchModel, 'element' => 'courseadminsearch-search_cat'])?>
</div>

</div>

<?php $form = ActiveForm::begin([
	'action' => Url::to(['/esiap/course-admin/table4'])
]); ?>

    <div class="box box-primary">
<div class="box-header"></div>
<div class="box-body">



<?php

if(Yii::$app->params['faculty_id'] == 21 ){
	$cat = [
				'label' => 'Component',
				'value' => function($model){
					return $model->component->name;
				}
				
			];
}else{
	$cat = [
				'label' => 'Program',
				'value' => function($model){
					if($model->program){
						return $model->program->pro_name_short;
					}
					
				}
				
			];
}

echo GridView::widget([
         'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
		'export' => false,
       // 'filterModel' => $searchModel,
        'columns' => [
			['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],
		
            
			[
				'attribute' => 'course_name',
			//	'contentOptions' => ['style' => 'width: 45%'],
				'format' => 'html',
				'label' => 'Course Code & Name',
				'value' => function($model){
					
					return Html::a( $model->course_code . ' ' . strtoupper($model->course_name) . '<br /><i>' . strtoupper($model->course_name_bi) . '</i> <span class="glyphicon glyphicon-pencil"></span>',['/esiap/course-admin/update/', 'course' => $model->id]);
					
					
				}
				
			],
			
			[
				'label' => 'Credit',
				'value' => function($model){
					return $model->credit_hour;
				}
				
			],
			'study_level',
			
			$cat ,
			
			[
				'label' => 'Course Owner',
				'format' => 'html',
				'value' => function($model){
					return $model->picStr;
				}
				
			],
			
			
			
           
			[
                'label' => 'Status',
                'format' => 'html',
                
                'value' => function($model){
					if($model->defaultVersion){
						
					    return $model->defaultVersion->labelStatus;
					}else{
						return 'NONE';
					}
                    
                }
            ],
/* 			 [
                'label' => 'Publish',
                'format' => 'html',
                'value' => function($model){
					if($model->publishedVersion){
						$lbl = 'YES';
						$color = 'success';
						$version = '<br /><i>' . $model->publishedVersion->version_name . '</i>';
					}else{
						$lbl =  'NO';
						$color = 'danger';
						$version = '';
					}
					
					return '<span class="label label-'.$color.'">'.$lbl.'</span>'.$version;
                    
                }
            ], */
			
			[
                'label' => 'Report',
                'format' => 'raw',
                'value' => function($model){
					return $model->reportList('View Doc Report');
                    
                }
            ],
			
			[
				'label' => 'Update',
			//	'contentOptions' => ['style' => 'width: 45%'],
				'format' => 'html',
				'value' => function($model){
					
					return Html::a( '<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/course-admin/update/', 'course' => $model->id], ['class' => 'btn btn-primary btn-sm']);
					
					
				}
				
			],
			


            
        ],
    ]); ?></div>
</div>



<div class="form-group">
        
<?= Html::submitButton('<span class="glyphicon glyphicon-download-alt"></span> Download Table 4 v2.0', ['class' => 'btn btn-success', 'name'=> 'actiontype', 'value' => 'generate']) ?>
    </div>
* Due to runtime limit, do consider to select only 5 courses max at a time.

<?php ActiveForm::end(); ?>


<?php 

$js = '
$("#checkAll").click(function(){
    $(\'input:checkbox\').not(this).prop(\'checked\', this.checked);
});

';
$this->registerJs($js);
?>


</div>
