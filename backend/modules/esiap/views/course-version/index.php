<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseVersionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Versions: ' . $course->course_code .' '. $course->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Course List', 'url' => ['/esiap/course-admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Update', 'url' => ['/esiap/course-admin/update', 'course' => $course->id]];
$this->params['breadcrumbs'][] = 'Version List';
?>
<div class="course-version-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
	<?= Html::a('Back', ['/esiap/course-admin/update', 'course' => $course->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> New Version', ['course-version-create', 'course' => $course->id], ['class' => 'btn btn-success']) ?>
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
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['/esiap/course-admin/course-version-update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
