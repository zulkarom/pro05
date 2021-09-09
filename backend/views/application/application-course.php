<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use backend\models\Semester;
use backend\models\FasiType;
use backend\models\Campus;
use backend\modules\esiap\models\Course;
use kartik\export\ExportMenu;
use kartik\select2\Select2;

$exportColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    
    [
        'label' => 'KOD & NAMA KURSUS',
        'value' => function($model){
        if($model->course){
            return $model->course->course_code . ' ' . $model->course->course_name;
        }
        
        }
        ],
        
        
        [
            'label' => 'NAMA CALON',
            'attribute' => 'fasi_name',
            'value' => function($model){
            return strtoupper($model->application->fasi->user->fullname);
            },
            
            ],
            
            [
                'label' => 'NO.TELEFON',
                'attribute' => 'phone',
                'value' => function($model){
                return strtoupper($model->application->fasi->handphone);
                },
                
                ],
                
                [
                    'label' => 'EMAIL',
                    'attribute' => 'email',
                    'value' => function($model){
                    return $model->application->fasi->user->email;
                    },
                    
                    ],
                    
                    [
                        'attribute' => 'fasi_type_id',
                        'label' => 'JENIS',
                        'value' => 'application.fasiType.type_name',
                    ],
                    
                    [
                        'attribute' => 'application.campus_id',
                        'label' => 'KAMPUS',
                        'value' => 'application.campus.campus_name',
                    ],
                    
                    [
                        'attribute' => 'status',
                        'label' => 'STATUS',
                        'format' => 'html',
                        // getAllStatusesArray()
                        'value' => function($model){
                        return $model->application->getWfLabel();
                        }
                        
                        
                        ],
                        
                        [
                            'attribute' => 'group',
                            'label' => 'GROUP',
                            'value' => function($model){
                            if($model->application->applicationGroup){
                                return $model->application->groupName;
                            }else{
                                return '-';
                            }
                            
                            }
                            
                            
                            ],
];

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$curr_sem = Semester::getCurrentSemester();
$this->title = 'PERMOHONAN MENGIKUT KURSUS';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('../semester/_semester_select', [
        'model' => $semester,
    ]) ?>
<div class="form-group">

<?=ExportMenu::widget([
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
]);?>


</div>
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
                'label' => 'KOD & NAMA KURSUS',
                'filter' => Select2::widget([
                    'name' => 'ApplicationCourseSearch[course_id]',
                    'model' => $searchModel,
                    'value' => $searchModel->course_id,
                    'data' => ArrayHelper::map(Course::find()->orderBy('course_name ASC')
                        ->where(['faculty_id' => Yii::$app->params['faculty_id'], 'is_dummy' => 0])
                        ->all(),'id', 'codeCourseString'),
                   // 'size' => Select2::MEDIUM,
                    'options' => [
                        'placeholder' => 'Select Course',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
                'value' => function($model){
                if($model->course){
                    return $model->course->course_code . ' ' . $model->course->course_name;
                }
                
                }
                ],
            
            
            [
                'label' => 'NAMA CALON',
                'attribute' => 'fasi_name',
                'value' => function($model){
                return strtoupper($model->application->fasi->user->fullname);
                },
                
            ],
            
            [
                'label' => 'NO.TELEFON',
                'attribute' => 'phone',
                'value' => function($model){
                return strtoupper($model->application->fasi->handphone);
                },
                
           ],
           
           [
               'label' => 'EMAIL',
               'attribute' => 'email',
               'value' => function($model){
               return $model->application->fasi->user->email;
               },
               
           ],
           
           [
               'attribute' => 'fasi_type_id',
               'label' => 'JENIS',
               'value' => 'application.fasiType.type_name',
               'filter' => Html::activeDropDownList($searchModel, 'fasi_type_id', ArrayHelper::map(FasiType::find()->asArray()->all(), 'id', 'type_name'),['class'=> 'form-control','prompt' => 'Pilih Jenis']),
           ],

            [
			 'attribute' => 'application.campus_id',
			 'label' => 'KAMPUS',
			 'value' => 'application.campus.campus_name',
			 'filter' => Html::activeDropDownList($searchModel, 'campus_id', ArrayHelper::map(Campus::find()->asArray()->all(), 'id', 'campus_name'),['class'=> 'form-control','prompt' => 'Pilih Kampus']),
			],
			
			[
			 'attribute' => 'status',
			 'label' => 'STATUS',
			 'format' => 'html',
			'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->getAllStatusesArray(),['class'=> 'form-control','prompt' => 'Pilih Status']),
			 // getAllStatusesArray()
			 'value' => function($model){
				 return $model->application->getWfLabel(); 
				 }


			],
			
			[
			    'attribute' => 'group',
			    'label' => 'GROUP',
			   // 'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->getAllStatusesArray(),['class'=> 'form-control','prompt' => 'Pilih Status']),
			    // getAllStatusesArray()
			    'value' => function($model){
    			    if($model->application->applicationGroup){
    			        return $model->application->groupName;
    			    }else{
    			        return '-';
    			    }
			            
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
						if($model->application->status == 'ApplicationWorkflow/e-release' or $model->application->status == 'ApplicationWorkflow/f-accept'){
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