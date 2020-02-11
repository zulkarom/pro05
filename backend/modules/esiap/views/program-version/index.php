<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseVersionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Program Versions';
$this->params['breadcrumbs'][] = ['label' => 'Program', 'url' => ['/esiap/program-admin/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Update', 'url' => ['/esiap/program-admin/update', 'program' => $course->id]];
$this->params['breadcrumbs'][] = 'Version List';
?>
<div class="course-version-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php 
	/* 
	
	<?= Html::a('Back', ['/esiap/program-admin/update', 'course' => $course->id], ['class' => 'btn btn-default']) ?>
	*/
			?>
			
	<p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> New Version', ['program-version-create', 'program' => $program->id], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'version_name',
				'format' => 'html',
				'value' => function($model){
					return $model->version_name . '<br /> <i> - created at '.date('d M Y', strtotime($model->created_at)).'</i>';
				}
				
			],
			
			[
                'attribute' => 'is_published',
				'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'is_published', [1=>'YES', 2 => 'NO'],['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->labelPublished;
					
				}
                
            ],
            
			[
                'attribute' => 'is_developed',
				'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'is_developed', [1=>'YES', 2 => 'NO'],['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->labelActive;
					
				}
                
            ],
			
			[
                'attribute' => 'status',
				'label' => 'Dev Status',
				'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'is_developed', [0=>'DRAFT', 10 => 'SUBMITTED', 20 => 'VERIFIED'],['class'=> 'form-control','prompt' => 'Choose Status']),
				'value' => function($model){
					return $model->labelStatus;
					
				}
                
            ],

            

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['/esiap/program-admin/program-version-update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
