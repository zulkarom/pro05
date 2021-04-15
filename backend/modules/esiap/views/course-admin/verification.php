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
			['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],
		
            
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
                'label' => 'Verification By',
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

</div>

<br />

<?php 


$verify->file_controller = 'course-admin';
echo UploadFile::fileInput($verify, 'signiture', true)?>



<div class="row">
<div class="col-md-2">
    <?= $form->field($verify, 'tbl4_verify_size')->textInput(['maxlength' => true, 'type' => 'number'
                            ])?>
    </div>
<div class="col-md-1">
    <?= $form->field($verify, 'tbl4_verify_y')->textInput(['maxlength' => true, 'type' => 'number'
                            ]) ?>
    </div>

</div>

<?php /* =Html::submitButton('<span class="fa fa-save"></span> SAVE SIGNITURE', 
    ['class' => 'btn btn-default btn-sm', 'name' => 'actiontype', 'value' => 'save',
    ]) */?> 
	
</div>
</div>



<div class="form-group">
        
		
	
	<?= Html::submitButton('<span class="fa fa-check"></span> Verify Selected', ['class' => 'btn btn-success', 'name'=> 'actiontype', 'value' => 'verify']) ?> 

<?= Html::submitButton('<span class="fa fa-remove"></span> Unverify Selected', ['class' => 'btn btn-warning', 'name'=> 'actiontype', 'value' => 'unverify']) ?>

    </div>



<div class="form-group">
        

    </div>

<?php ActiveForm::end(); ?>


<?php 

$js = '
$("#checkAll").click(function(){
    $(\'input:checkbox\').not(this).prop(\'checked\', this.checked);
});

';
$this->registerJs($js);
?>


</div>
