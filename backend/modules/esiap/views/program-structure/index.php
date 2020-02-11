<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Program Structures';
$this->params['breadcrumbs'][] = $this->title;
echo $model->pageHeader();
?>


<div class="program-structure-index">

    <p>
        <?php echo Html::button('<span class="glyphicon glyphicon-plus"></span>  Include Course', ['value' => Url::to(['structure-create', 'program' => $model->program_id]), 'class' => 'btn btn-success', 'id' => 'modalButton']);
		
Modal::begin([
    'header' => '<h4>Include Course</h4>',
	'id' =>'modal',
	'size' => 'modal-lg'
]);

echo '<div id="modalContent"></div>';

Modal::end();

$this->registerJs('

$(function(){
  $("#modalButton").click(function(){
      $("#modal").modal("show")
        .find("#modalContent")
        .load($(this).attr("value"));
  });
});

');
		
		
		?>
		
		
    </p>

<div class="box">
<div class="box-header"></div>
<div class="box-body">    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'year',
            'sem_num',
            [
				'label' => 'Course',
				'format' => 'html',
				'value' => function($model){
					if($model->courseVersion){
						if($model->courseVersion->course){
							$course = $model->courseVersion->course;
							return $course->course_code . ' ' . $course->course_name . '<br /><i style="font-size:11px">Version: ' . $model->courseVersion->version_name . '</i>';
						}
						
					}
					
				}
				
			],
			
			[
				'attribute' => 'course_type',
				'value' => function($model){
					return $model->courseType->type_name;
				}
				
			],
            
			
            
            //'sem_num_part',
            //'year_part',

            
			['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 13%'],
                'template' => '{update} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						return Html::button('<span class="fa fa-edit"></span>', ['value' => Url::to(['structure-update', 'id' => $model->id]), 'class' => 'btn btn-warning btn-sm modalUpdateButton']);
                    },
                    'delete'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-remove"></span>', ['/esiap/program/structure-delete', 'id' => $model->id], [
							'class' => 'btn btn-danger btn-sm',
							'data' => [
								'confirm' => 'Are you sure you want to remove this course from the structure?',
								'method' => 'post',
							],

						]) 
				;
                    }
                ],
            
            ],


        ],
    ]); ?></div>
</div>

</div>


<?php
		
Modal::begin([
    'header' => '<h4>Update Course</h4>',
	'id' =>'modal-update',
	'size' => 'modal-lg'
]);

echo '<div id="modalContent"></div>';

Modal::end();

$this->registerJs('

$(function(){
  $(".modalUpdateButton").click(function(){
      $("#modal-update").modal("show")
        .find("#modalContent")
        .load($(this).attr("value"));
  });
});

');
		
		
		?>