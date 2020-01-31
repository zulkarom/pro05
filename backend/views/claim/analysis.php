<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\Campus;
use backend\models\Semester;
use common\models\Common;
use kartik\export\ExportMenu;

$colums = [


];


/* @var $this yii\web\View */
/* @var $searchModel backend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = 'ANALISIS TUNTUTAN';
$this->params['breadcrumbs'][] = $this->title;

$sem = $semester->semester;


$colums_export = [
            ['class' => 'yii\grid\SerialColumn'],

			[
			 'attribute' => 'fasi_name',
			 'label' => 'FASILITATOR',
			 'contentOptions' => [ 'style' => 'width: 15%;' ],
			 'value' => function($model){
				 return strtoupper($model->fasi->user->fullname);
			 }
			],
            [
			//'attribute' => 'semester_id' ,
			'label' => 'KURSUS',
			'value' => function($model){
				if($model->acceptedCourse){
					return strtoupper($model->acceptedCourse->course->course_code . "\n" . $model->acceptedCourse->course->course_name) . "\n" . '(' . $model->groupName . ')';
				}
				
			},
			],
			
            [
			 'attribute' => 'campus_id',
			'label' => 'Kampus',
			//'with' => '10%',
			 'value' => function($model){
				 return strtoupper($model->campus->campus_name);
			 },
			
			], 
			[
				//'attribute' => 'rate_amount',
				'label' => 'KADAR',
				'headerOptions' => ['style'=>'text-align:center'],
				'contentOptions' => ['style'=>'text-align:center'],
				'value' => function($model){
					return $model->rate_amount;
				}
			]
			
        ];
		
		
$arr_month = $sem->getListMonthSem();
$months = Common::months_short();
foreach($arr_month as $m){
	$colums_export[] = [
	 'label' => strtoupper($months[$m]) ,
	 'format' => 'html',
	 
	 'value' => function($model,$c, $v,$r){
		 $hour = $model->getHourMonth($r->label);
		 if($hour > 0){
			 return $hour;
		 }else{
			 return '';
		 }
	 },
	 
	 

	];
}
$total_style = ['style'=>'text-align:center;background-color:#f9f9f9'];
$colums_export[] = [
	 'label' => 'JUMLAH JAM' ,
	 'headerOptions' => $total_style,
	 'contentOptions' => $total_style,
	 'value' => function($model){
		 return $model->getHourTotal();
	 }
	];
foreach($arr_month as $m){
	$colums_export[] = [
	 'label' => strtoupper($months[$m]) ,
	 'headerOptions' => ['style'=>'text-align:center'],
	 'value' => function($model,$c, $v,$r){
		 $amt = $model->getAmountMonth($r->label);
		 if($amt > 0){
			 return $amt;
		 }else{
			 return '';
		 }
	 }
	];
}

$colums_export[] = [
	 'label' => "JUMLAH \n(RM)" ,
	 'format' => 'html',
	 'value' => function($model){
		 $total = $model->getAmountTotal();
		 if($total > 0){
			 return $total ;
		 }else{
			 return '';
		 }
		 
	 }
	];
	

$colums_array = [
            ['class' => 'yii\grid\SerialColumn'],

			[
			 'attribute' => 'fasi_name',
			 'label' => 'FASILITATOR',
			 'contentOptions' => [ 'style' => 'width: 15%;' ],
			 'value' => function($model){
				 return strtoupper($model->fasi->user->fullname);
			 }
			],
            [
			//'attribute' => 'semester_id' ,
			'label' => 'KURSUS',
			'format' => 'html',
			'value' => function($model){
				if($model->acceptedCourse){
					return strtoupper($model->acceptedCourse->course->course_code . '<br />' . $model->acceptedCourse->course->course_name) . ' <br /><b>(' . $model->groupName . ')</b>';
				}
				
			},
			],
			
            /* [
			 'attribute' => 'campus_id',
			// 'label' => 'Location',
			//'with' => '10%',
			 'value' => function($model){
				 return strtoupper($model->campus->campus_name);
			 },
			 'filter' => Html::activeDropDownList($searchModel, 'campus_id', ArrayHelper::map(Campus::find()->asArray()->all(), 'id', 'campus_name'),['class'=> 'form-control','prompt' => 'Pilih Kampus']),
			], */
			[
				//'attribute' => 'rate_amount',
				'label' => 'KADAR',
				'headerOptions' => ['style'=>'text-align:center'],
				'contentOptions' => ['style'=>'text-align:center'],
				'value' => function($model){
					return 'RM' . $model->rate_amount;
				}
			]
			
        ];
		
		
$arr_month = $sem->getListMonthSem();
$months = Common::months_short();
foreach($arr_month as $m){
	$colums_array[] = [
	 'label' => strtoupper($months[$m]) ,
	 'format' => 'html',
	 
	 'value' => function($model,$c, $v,$r){
		 $hour = $model->getHourMonth($r->label);
		 if($hour > 0){
			 return $hour;
		 }else{
			 return '-';
		 }
	 },
	 
	 'contentOptions' => function ($model, $key, $index, $column) {
        return ['style' => 'text-align:center;background-color:' 
            . ($model->getHourMonth($column->label) == 0 ? '#ffd6e1' : '')];
		},

	];
}
$total_style = ['style'=>'text-align:center;background-color:#f9f9f9'];
$colums_array[] = [
	 'label' => 'JUMLAH JAM' ,
	 'format' => 'html',
	 'headerOptions' => $total_style,
	 'contentOptions' => $total_style,
	 'value' => function($model){
		 return '<b>' . $model->getHourTotal() . '</b>';
	 }
	];
foreach($arr_month as $m){
	$colums_array[] = [
	 'label' => strtoupper($months[$m]) ,
	 'headerOptions' => ['style'=>'text-align:center'],
	 'value' => function($model,$c, $v,$r){
		 $amt = $model->getAmountMonth($r->label);
		 if($amt > 0){
			 return 'RM' . $amt;
		 }else{
			 return '-';
		 }
	 }
	];
}

$colums_array[] = [
	 'label' => 'JUMLAH RM' ,
	 'format' => 'html',
	 'headerOptions' => $total_style,
	 'contentOptions' => $total_style,
	 'value' => function($model){
		 $total = $model->getAmountTotal();
		 if($total > 0){
			 return '<b>RM'. $total . '</b>';
		 }else{
			 return '-';
		 }
		 
	 }
	];
?>

<?= $this->render('../semester/_semester_select', [
        'model' => $semester,
    ]) ?>
  
 <div class="form-group"><?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $colums_export,
	'target'=>ExportMenu::TARGET_SELF,
	'filename' => 'JADUAL_TUNTUTAN_' . date('Y-m-d'),
	'onRenderSheet'=>function($sheet, $grid){
		$sheet->getStyle('A2:'.$sheet->getHighestColumn().$sheet->getHighestRow())
		->getAlignment()->setWrapText(true);
	},
	'exportConfig' => [
        ExportMenu::FORMAT_PDF => false,
		ExportMenu::FORMAT_EXCEL_X => false,
    ],
]);?></div>
  <?php $form = ActiveForm::begin(); ?>
  
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="application-index">

<?=$this->render('_search', ['model' => $searchModel])?>



<div class="table-responsive">
   <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
		//'filterModel' => $searchModel,
        'columns' => $colums_array,
    ]); ?>
</div>
	
</div>
</div>
</div>




<?php ActiveForm::end(); ?>


<?php 

$js = '
$("#checkAll").click(function(){
    $(\'input:checkbox\').not(this).prop(\'checked\', this.checked);
});

';
$this->registerJs($js);
?>