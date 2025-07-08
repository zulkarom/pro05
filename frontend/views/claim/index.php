<?php

use backend\models\ClaimSetting;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'SENARAI TUNTUTAN';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="claim-index">

	<p>
		<?= Html::a('<span class="glyphicon glyphicon-plus"></span> PERMOHONAN TUNTUTAN', ['create'], ['class' => 'btn btn-primary']) ?>
	</p>

	<?php
	// Calculate total of total_hour
	$totalHour = 0;
	foreach ($dataProvider->getModels() as $model) {
		$totalHour += $model->total_hour;
	}
	
	?>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'showFooter' => true,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			[
				'label' => 'Subjek',
				'value' => function($model){
					$course = $model->application->acceptedCourse->course;
					return $course->course_code . ' ' . $course->course_name;
				}
			],
			[
				'label' => 'Bulan',
				'attribute' => 'month',
				'value' => function($model){
					return $model->monthName();
				}
			],
			'year',
			[
				'label' => 'Jumlah Tuntutan',
				'value' => function($model){
					$rate = $model->application->rate_amount;
					return 'RM' . number_format($model->total_hour * $rate , 0);
				}
			],
			[
				'label' => 'Jumlah Jam',
				'value' => function($model){
					return $model->total_hour;
				},
				'footer' => '<b>Jumlah: ' . $totalHour . '</b>',
				'footerOptions' => ['style' => 'font-weight:bold;'],
			],
			[
				'attribute' => 'status',
				'label' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->wfLabel;
				}
			],
			[
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['style' => 'width: 8.7%'],
				'template' => '{view} {delete}',
				//'visible' => false,
				'buttons'=>[
					'view'=>function ($url, $model) {
						if($model->wfStatus == 'draft' or $model->wfStatus == 'returned'){
							return '<a href="'.Url::to(['/claim/update/', 'id' => $model->id]).'" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-pencil"></span> UPDATE</a>';
						}else{
							return '<a href="'.Url::to(['/claim/update/', 'id' => $model->id]).'" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-search"></span> VIEW</a>';
						}
					},
					'delete'=>function ($url, $model) {
						if($model->wfStatus == 'draft' or $model->wfStatus == 'returned'){
							return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete-claim', 'id' => $model->id], [
								'class' => 'btn btn-danger btn-sm',
								'data-confirm' => 'Adakah anda pasti untuk memadam tuntutan ini?',
								'data-method' => 'post',
							]);
						}
					}
				],
			],
		],
	]);
	?>
</div>


<?php 
$setting = ClaimSetting::findOne(1);
$claimed_hour = 0;
if ($application) {
	$claimed_hour = $application->getHourTotal();
}
?>
<div class="row">
<div class="col-md-6">
	

	
	</div>


<div class="col-md-6">
<i>* maksimum jam satu semester : <span id="max_sem"><?=$setting->hour_max_sem?></span></i><br />
	<i>* jumlah jam telah dituntut semester ini : <span id="claimed_sem"><?=$claimed_hour?></span></i><br />
	

	<?php if($claimed_hour >= $setting->hour_max_sem){ ?>
	<span style="color:blue" id="warning-semester"><span class="glyphicon glyphicon-exclamation-sign"></span> <i>Jumlah jam telah mencapai had maksimum tuntutan dalam satu semester</i></span>
	<?php } ?>

	</div>
</div>



</div>
</div>
