<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseVersionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Versions for ' . $course->course_code .' '. $course->course_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-version-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
	<?= Html::a('Back', ['/course/list'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Create Course Version', ['course-version-create', 'course' => $course->id], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'version_name',
			[
                'attribute' => 'is_active',
				'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'is_active', [1=>'YES', 2 => 'NO'],['class'=> 'form-control','prompt' => 'Choose Is Active']),
				'value' => function($model){
					return $model->labelActive;
					
				}
                
            ],
			[
                'attribute' => 'status',
				'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'is_active', [0=>'DRAFT', 10 => 'SUBMITTED', 20 => 'VERIFIED'],['class'=> 'form-control','prompt' => 'Choose Status']),
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
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['/esiap/course/course-version-update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
