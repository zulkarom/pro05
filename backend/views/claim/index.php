<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\Common;
use backend\models\Semester;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClaimSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$sem = Semester::getCurrentSemester();


$this->title = 'SENARAI TUNTUTAN';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('../semester/_semester_select', [
        'model' => $semester,
    ]) ?>
	
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="claim-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
			 'attribute' => 'fasi_name',
			 'label' => 'Nama Fasilitator',
			 'filter' => Html::activeInput('text', $searchModel, 'fasi_name', ['class' => 'form-control', 'placeholder' => 'Cari Fasilitator...']),
			 'value' => function($model){
				return strtoupper($model->application->fasi->user->fullname);
			 }
			],

            [
				'attribute' => 'month',
				'label' => 'Bulan',
				'filter' => Html::activeDropDownList($searchModel, 'month', Common::months(),['class'=> 'form-control','prompt' => 'Pilih Bulan']),
				'value' => function($model){
					return strtoupper($model->monthName());
				}
			],
            'year',
            [
			 'attribute' => 'status',
			 'label' => 'Status',
			 'format' => 'html',
			 'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->getAllStatusesArray(),['class'=> 'form-control','prompt' => 'Pilih Status']),
			 'value' => function($model){
				 return $model->getWfLabel(); 

				 
				 }


			],
            //'submit_at',
            //'status',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn',
				 'contentOptions' => ['style' => 'width: 8.7%'],
				'template' => '{view}',
				//'visible' => false,
				'buttons'=>[
					'view'=>function ($url, $model) {
						return '<a href="'.Url::to(['/claim/view/', 'id' => $model->id]).'" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-search"></span> VIEW</a>';
					}
				],
			
			],
        ],
    ]); ?>
</div></div>
</div>
