<?php 
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'e-SIAP MODULE';
$this->params['breadcrumbs'][] = $this->title;

?>

<i>Electronic Structured and Integrated Academic Package</i>
<br /><br />


<div class="box box-primary">
<div class="box-header">
<h3 class="box-title">My Course(s)</h3>
</div>
<div class="box-body">

<div class="table-responsive"><?= GridView::widget([
        'dataProvider' => $dataProvider2,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'course.course_code',
            'course.course_name',
			'course.course_name_bi',
			'course.credit_hour',


            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 25%'],
                'template' => '{fk1} {fk2} {fk3}',
                //'visible' => false,
                'buttons'=>[
                    'fk1'=>function ($url, $model) {
						$version = $model->course->publishedVersion;
						if($version){
							return Html::a('<span class="glyphicon glyphicon-download-alt"></span> FK01',['/esiap/course/fk1/', 'course' => $model->course_id],['target' => '_blank','class'=>'btn btn-danger btn-sm']);
						}else{
							return '-';
						}
                        
                    },
					'fk2'=>function ($url, $model) {
						$version = $model->course->publishedVersion;
						if($version){
							return Html::a('<span class="glyphicon glyphicon-download-alt"></span> FK02',['/esiap/course/fk2/', 'course' => $model->course_id],['target' => '_blank','class'=>'btn btn-danger btn-sm']);
						}else{
							return '-';
						}
                        
                    },
					'fk3'=>function ($url, $model) {
						$version = $model->course->publishedVersion;
						if($version){
							return Html::a('<span class="glyphicon glyphicon-download-alt"></span> FK03',['/esiap/course/fk3/', 'course' => $model->course_id],['target' => '_blank','class'=>'btn btn-danger btn-sm']);
						}else{
							return '-';
						}
                        
                    },
                ],
            
            ],
        ],
    ]); ?></div></div>
</div>


<div class="box box-danger">
<div class="box-header">
<h3 class="box-title">Under Development Course(s)</h3>
</div>
<div class="box-body"><div class="table-responsive"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'course.course_code',
            'course.course_name',
			'course.course_name_bi',
			'course.credit_hour',
			[
				'attribute' => 'course.developmentVersion.labelStatus',
				'label' => 'Status',
				'format' => 'html'
				
				
			],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						$version = $model->course->developmentVersion;
						if($version){
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/course/update/', 'course' => $model->course_id],['class'=>'btn btn-warning btn-sm']);
						}else{
							return 'NO UDV';
						}
                        
                    },
                ],
            
            ],
        ],
    ]); ?></div></div>
</div>

<?php 
if($dataProvider4->getCount() > 0){?>
<div class="box box-primary">
<div class="box-header">
<h3 class="box-title">My Program(s)</h3>
</div>
<div class="box-body">

<div class="table-responsive"><?= GridView::widget([
        'dataProvider' => $dataProvider4,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'program.pro_name',


            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 25%'],
                'template' => '',
                //'visible' => false,
                'buttons'=>[
                ],
            
            ],
        ],
    ]); ?></div></div>
</div>
<?php 
}

if($dataProvider3->getCount() > 0){?>
<div class="box box-danger">
<div class="box-header">
<h3 class="box-title">Under Development Program(s)</h3>
</div>
<div class="box-body"><div class="table-responsive"><?= GridView::widget([
        'dataProvider' => $dataProvider3,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'program.pro_name',
			[
				'attribute' => 'program.developmentVersion.labelStatus',
				'label' => 'Status',
				'format' => 'html'
			],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						$version = $model->program->developmentVersion;
						if($version){
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/program/update/', 'program' => $model->program_id],['class'=>'btn btn-warning btn-sm']);
						}else{
							return 'NO UDV';
						}
                        
                    },
                ],
            
            ],
        ],
    ]); ?></div></div>
</div>

<?php } ?>