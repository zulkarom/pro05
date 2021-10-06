<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Verification';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<div class="row">


<div class="col-md-7" align="right">

<?=$this->render('_search', ['model' => $searchModel, 'element' => 'courseverificationsearch-search_cat'])?>
</div>

</div>

<?php $form = ActiveForm::begin(); ?>
    <div class="box box-primary">
<div class="box-header"></div>
<div class="box-body">



<?php

if(Yii::$app->params['faculty_id'] == 21 ){
	$cat = [
				'label' => 'Component',
				'value' => function($model){
					return $model->course->component->name;
				}
				
			];
}else{
	$cat = [
				'label' => 'Program',
				'value' => function($model){
					if($model->course->program){
						return $model->course->program->pro_name_short;
					}
					
				}
				
			];
}

echo GridView::widget([
         'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn'],
            
			[
				'attribute' => 'course_name',
			//	'contentOptions' => ['style' => 'width: 45%'],
				'format' => 'html',
				'label' => 'Course Code & Name',
				'value' => function($model){
					$course = $model->course;
					return $course->course_code . ' ' . strtoupper($course->course_name) . '<br /><i>' . strtoupper($course->course_name_bi) . '</i>';
					
					
				}
				
			],
			
			[
                'label' => 'Version',
                
                'value' => function($model){
					return $model->version_name;
                }
            ],
			
			$cat ,
			

			[
                'label' => 'Submission By',
                'format' => 'html',
                'value' => function($model){
					if($model->preparedBy){
						return $model->preparedBy->staff->niceName . '<br /><i> at ' . date('d M Y', strtotime($model->prepared_at)) . '</i>';
					}
					
                }
            ],
			
			[
                'label' => 'Status',
                'format' => 'html',
                'value' => function($model){
					return $model->labelStatus;
					
                }
            ],
			
			[
                'label' => 'Verification',
                'format' => 'html',
                'value' => function($model){
					if($model->status == 20 and $model->verifiedBy){
						return $model->verifiedBy->staff->niceName . '<br /><i> at ' . date('d M Y', strtotime($model->verified_at)) . '</i>';
					}
					
                }
            ],
			
			
			
           
	
			
			
			[
                'label' => 'Report',
                'format' => 'raw',
                'value' => function($model){
					return $model->course->reportList('View', $model->id);
                    
                }
            ],
			
			['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="fa fa-pencil"></span> View',['verification-page', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
                ],
            ],
			


            
        ],
    ]); ?></div>
</div>




<div class="box box-info">
<div class="box-body">
<div class="row">

<div class="col-md-3">

<?php 
$verify->verified_at = date('Y-m-d');
?>
 <?=$form->field($verify, 'verified_at')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,

    ],


]);
?>

</div>

<div class="col-md-3">


 <?=$form->field($verify, 'date1')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>

</div>
<div class="col-md-3">


 <?=$form->field($verify, 'date2')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
])->label("Senate’s Approval At");
?>

</div>

</div>

<br />

<?php 


$verify->file_controller = 'course-admin';
echo UploadFile::fileInput($verify, 'signiture', true)?>



<div class="row">
<div class="col-md-1">
    <?= $form->field($verify, 'tbl4_verify_size')->textInput(['maxlength' => true, 'type' => 'number'
    ])->label('Image Size Adj')?>
    </div>
<div class="col-md-1">
    <?= $form->field($verify, 'tbl4_verify_y')->textInput(['maxlength' => true, 'type' => 'number'
    ])->label('Vert.Position Adj') ?>
    </div>

</div>

<i>
* 
* For the signature, use png format image with transparent background. You can click <a href="https://www.remove.bg/" target="_blank">Remove.bg</a> to easily remove background.<br />
* Approximate size pixel 200 x 100.<br />
* Increase Image Size Adj to make the image bigger and vice versa.<br />
* Increase Vertical Position Adj to move the image upwards and vice versa. <br />
* Is strongly recommended to approve one course first to preview your signature before proceeding to other courses.
</i>

</div>
</div>



<div class="form-group">



	<?= Html::submitButton('<span class="fa fa-check"></span> Verify All Selected', ['class' => 'btn btn-success', 'name'=> 'actiontype', 'value' => 'verify']) ?> 

<?= Html::submitButton('<span class="fa fa-arrow-left"></span> Change to Submit Status', ['class' => 'btn btn-info', 'name'=> 'actiontype', 'value' => 'back']) ?>

    </div>


    <?php ActiveForm::end(); ?>





</div>
