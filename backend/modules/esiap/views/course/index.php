<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-index">

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'course_code',
            'course_name',
            'course_name_bi',
            'credit_hour',

            ['class' => 'yii\grid\ActionColumn',
                 //'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/course/update/', 'course' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
					
					
                ],
            
            ],
        ],
    ]); ?></div>
</div>

</div>
