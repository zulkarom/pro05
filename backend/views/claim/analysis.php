<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\Campus;
use backend\models\Semester;
use common\models\Common;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$sem = Semester::getCurrentSemester();


$this->title = 'ANALISIS TUNTUTAN SEMESTER ' . strtoupper($sem->niceFormat());
$this->params['breadcrumbs'][] = $this->title;
?>
  
 
  <?php $form = ActiveForm::begin(); ?>
  
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="application-index">

<?=$this->render('_search', ['model' => $searchModel])?>


<?php 
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
				return strtoupper($model->acceptedCourse->course->course_code . '<br />' . $model->acceptedCourse->course->course_name) . '<br /><b>(' . $model->groupName . ')</b>';
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