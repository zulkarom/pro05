<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use backend\models\Semester;
use backend\models\FasiType;
use backend\models\Campus;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$curr_sem = Semester::getCurrentSemester();
$this->title = 'PERMOHONAN FASILITATOR';
$this->params['breadcrumbs'][] = $this->title;
$curr_sem = Semester::getCurrentSemester();
?>
<h4>Semester <?=$curr_sem->niceFormat()?></h4>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="application-index">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
			[
			 'attribute' => 'fasi_name',
			 'label' => 'Nama Fasilitator',
			 'contentOptions' => [ 'style' => 'width: 35%;' ],
			 'format' => 'html',
			 'filter' => Html::activeInput('text', $searchModel, 'fasi_name', ['class' => 'form-control', 'placeholder' => 'Cari Fasilitator...']),
			 'value' => function($model){
				return strtoupper($model->fasi->user->fullname) . '<br />' . $model->listAppliedCoursesString();
			 }
			],
			[
			 'attribute' => 'fasi_type_id',
			// 'label' => 'Location',
			 'value' => 'fasiType.type_name',
			 'filter' => Html::activeDropDownList($searchModel, 'fasi_type_id', ArrayHelper::map(FasiType::find()->asArray()->all(), 'id', 'type_name'),['class'=> 'form-control','prompt' => 'Pilih Jenis']),
			],

            /* [
			'attribute' => 'semester_id' ,
			'value' => function($model){
				return $model->semester->niceFormat();
			}], */
			
            [
			 'attribute' => 'campus_id',
			// 'label' => 'Location',
			 'value' => 'campus.campus_name',
			 'filter' => Html::activeDropDownList($searchModel, 'campus_id', ArrayHelper::map(Campus::find()->asArray()->all(), 'id', 'campus_name'),['class'=> 'form-control','prompt' => 'Pilih Kampus']),
			],
			
			[
			 'attribute' => 'status',
			 'label' => 'Status',
			 'format' => 'html',
			 'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->getAllStatusesArray(),['class'=> 'form-control','prompt' => 'Pilih Status']),
			 // getAllStatusesArray()
			 'value' => function($model){
				 return $model->getWfLabel(); 
				 }


			],

            ['class' => 'yii\grid\ActionColumn',
				 'contentOptions' => ['style' => 'width: 15%'],
				'template' => '{view} {letter}',
				//'visible' => false,
				'buttons'=>[
					'view'=>function ($url, $model) {

						return '<a href="'.Url::to(['/application/view/', 'id' => $model->id]).'" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-search"></span> VIEW</a>';
					},
					'letter'=>function ($url, $model) {
						if($model->status == 'ApplicationWorkflow/e-release' or $model->status == 'ApplicationWorkflow/f-accept'){
							return '<a href="'.Url::to(['/offer-letter/pdf/', 'id' => $model->id]).'" class="btn btn-danger btn-sm" target="_blank"><span class="glyphicon glyphicon-download-alt"></span> PDF</a>';
						}
						
					}
				],
			
			],

        ],
    ]); ?>
</div>
</div>
</div>