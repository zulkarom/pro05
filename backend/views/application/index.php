<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use backend\models\Semester;
use backend\models\FasiType;
use backend\models\Campus;
use kartik\export\ExportMenu;

$exportColumns = [
['class' => 'yii\grid\SerialColumn'],
			
			[
			 'attribute' => 'fasi_name',
			 'label' => 'Nama Fasilitator',
			 'contentOptions' => [ 'style' => 'width: 35%;' ],
			 'format' => 'html',
			
			 'value' => function($model){
				return strtoupper($model->fasi->user->fullname);
			 }
			],
			[
			 'label' => 'NRIC',
			 'contentOptions' => [ 'style' => 'width: 35%;' ],
			
			 'value' => function($model){
				return '="' . strtoupper($model->fasi->nric) . '"';
			 }
			],
			[
			 'label' => 'Kategori',
			 'contentOptions' => [ 'style' => 'width: 35%;' ],
			
			 'value' => function($model){
				 if($model->fasi->umk_staff == 1){
					 return 'STAFF UMK';
				 }else{
					 return 'FASILITATOR LUAR';
				 }
			 }
			],
			[
			 'label' => 'Kursus',
			 'value' => function($model){
				return $model->listAppliedCoursesString("\n");
			 }
			],
			[
			 'attribute' => 'fasi_type_id',
			 'value' => 'fasiType.type_name',
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
			
			],
			
			[
			 'attribute' => 'status',
			 'label' => 'Status',
			
			 // getAllStatusesArray()
			 'value' => function($model){
				 return strtoupper($model->getWorkflowStatus()->getLabel()); 
				 }


			],
];

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$curr_sem = Semester::getCurrentSemester();
$this->title = 'PERMOHONAN FASILITATOR';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('../semester/_semester_select', [
        'model' => $semester,
    ]) ?>
<div class="form-group"><?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $exportColumns,
	'filename' => 'PERMOHONAN_DATA_' . date('Y-m-d'),
	'onRenderSheet'=>function($sheet, $grid){
		$sheet->getStyle('A2:'.$sheet->getHighestColumn().$sheet->getHighestRow())
		->getAlignment()->setWrapText(true);
	},
	'exportConfig' => [
        ExportMenu::FORMAT_PDF => false,
		ExportMenu::FORMAT_EXCEL_X => false,
    ],
]);?></div>
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
				$html = strtoupper($model->fasi->user->fullname) . '<br />' . $model->listAppliedCoursesString();
				if($model->showingVerified()){
					if(!$model->acceptedCourse){
						$html .= '<br /><span style="color:red;font-size:12px"><i class="fa fa-warning"></i> Kursus ini tidak mempunyai kursus yang diluluskan semasa sokongan. Go to View -> Maklumat Permohonan klik Edit, Lulus = Yes</span>';
					}
				}
				return $html;
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