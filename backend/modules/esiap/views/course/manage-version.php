<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Course Information Version';
$this->params['breadcrumbs'][] = ['label' => 'Course Preview', 'url' => ['view-course', 'course' => $course->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<h4><?=$course->course_code . ' ' . $course->course_name ?></h4>
<div class="form-group">
<a href="<?=Url::to(['create-version', 'course' => $course->id])?>" class="btn btn-success">New Version</a>
</div>

<div class="course-index">

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'version_name',
            
            'preparedBy.fullname',
            
            'labelStatus:html',
            
            'isDeveloped:html',
            'isPublished:html',
            
            //'verifiedBy.fullname',
           // 'created_at:date',
            [
			     'label' => 'Documents',
                'format' => 'raw',
                'value' => function($model){
                    return $model->course->reportList('View Doc Report', $model->id);
                    
                }
                
            ],

            

            ['class' => 'yii\grid\ActionColumn',
                 //'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update} {course}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-pencil"></span> Version',['/esiap/course/update-version/', 'course' => $model->course->id, 'version' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
                    
                    'course'=>function ($url, $model) {
                    return Html::a('<span class="fa fa-pencil"></span> Course Info',['/esiap/course/view-course/', 'course' => $model->course->id, 'version' => $model->id],['class'=>'btn btn-primary btn-sm']);
                    },
					
					
                ],
            
            ],
        ],
    ]); ?></div>
</div>

</div>
