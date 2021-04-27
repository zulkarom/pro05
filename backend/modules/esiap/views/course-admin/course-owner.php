<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use backend\modules\esiap\models\Program;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Owners';
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
$program = '';
$kp = Program::findOne(['head_program' => Yii::$app->user->identity->staff->id]);
if($kp){
	$program = $kp->pro_name_bi . ' ('.$kp->pro_name_short.')';
}
?>
<div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<div class="row">
<div class="col-md-9">

<h4><?=$program?></h4>
</div>
<div class="col-md-3" align="right">
       <div class="form-group"> 
		
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


</div>


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
            ['class' => 'yii\grid\SerialColumn'],
		
            
			[
				'attribute' => 'course_name',
			//	'contentOptions' => ['style' => 'width: 45%'],
				'format' => 'html',
				'label' => 'Course Code & Name',
				'value' => function($model){
					
					return Html::a( $model->course_code . ' ' . strtoupper($model->course_name) . '<br /><i>' . strtoupper($model->course_name_bi) . '</i> <span class="glyphicon glyphicon-pencil"></span>',['/esiap/course-admin/update-owner/', 'course' => $model->id]);
					
					
				}
				
			],
			
			[
				'label' => 'Credit',
				'value' => function($model){
					return $model->credit_hour;
				}
				
			],
			
			$cat ,
			
			[
				'label' => 'Course Owner',
				'format' => 'html',
				'value' => function($model){
					return $model->picStr;
				}
				
			],

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
					
					return Html::a( '<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/course-admin/update-owner/', 'course' => $model->id], ['class' => 'btn btn-primary btn-sm']);
					
					
				}
				
			],
			


            
        ],
    ]); ?></div>
</div>




</div>
