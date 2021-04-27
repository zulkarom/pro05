<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use backend\modules\staff\models\Staff;
use kartik\date\DatePicker;
use common\models\UploadFile;



backend\assets\KnobAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'View Course Information';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="course-update">


<div class="course-form">

<?=$this->render('_header',[
'course' => $model
])?>




<div class="dropdown">


  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">View Other Version
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
		<?php 
		$versions = $model->versions;
		if($versions){
			foreach($versions as $v){
				echo '<li><a href="'.Url::to(['course/html-view', 'course' => $model->id, 'version' => $v->id]).'" target="_blank">'.$v->version_name .'</a></li>';
			}
		}
		
		?>
  
    
    
	
  </ul>

<?php echo $model->reportList('View Doc Report', $version->id); ?>
<?php 
if(array_key_exists('course-files',Yii::$app->modules)){
	echo Html::a('Back to Course File', ['/course-files/coordinator/current-coordinator-page', 'course' => $model->id], ['class' => 'btn btn-default']);
        }
 ?> 

</div>  <br />

<div class="box box-solid">
<div class="box-header">
<i class="fa fa-bar-chart-o"></i>

</div>

<div class="box-body">
<?php 
$per = $model->developmentVersion->progress;
$version = $model->developmentVersion;
$profile = percent($version->pgrs_info);
$clo = percent($version->pgrs_clo);
$plo = percent($version->pgrs_plo);
$tax = percent($version->pgrs_tax);
$soft = percent($version->pgrs_soft);
$delivery = percent($version->pgrs_delivery);
$syll = percent($version->pgrs_syll);
$slt = percent($version->pgrs_slt);
$assess = percent($version->pgrs_assess);
$assess_per = percent($version->pgrs_assess_per);
$ref = percent($version->pgrs_ref);

?>

<div class="row">

<?=show_knob($per, 'Overall Progress', ['view-course', 'course' => $model->id])?>
<?=show_knob($profile, 'Course Profile', ['update', 'course' => $model->id])?>
<?=show_knob($assess, 'Assessment', ['course-assessment', 'course' => $model->id])?>
<?=show_knob($clo, 'Course Learning Outcomes', ['course-clo', 'course' => $model->id])?>
<?=show_knob($plo, 'CLO PLO', ['clo-plo', 'course' => $model->id])?>
<?=show_knob($tax, 'CLO Taxonomy', ['clo-taxonomy', 'course' => $model->id])?>
</div>

</div>
</div>


<div class="box box-solid">
<div class="box-header">
<i class="fa fa-bar-chart-o"></i>

</div>
<div class="box-body">
<div class="row">
<?=show_knob($delivery, 'CLO Methods', ['clo-delivery', 'course' => $model->id])?>
<?=show_knob($assess_per, 'CLO Assessment', ['clo-assessment', 'course' => $model->id])?>
<?=show_knob($soft, 'CLO Softskill', ['clo-softskill', 'course' => $model->id])?>
<?=show_knob($syll, 'Syllabus', ['course-syllabus', 'course' => $model->id])?>
<?=show_knob($syll, 'Student Learning Time', ['course-slt', 'course' => $model->id])?>
<?=show_knob($ref, 'Reference', ['course-reference', 'course' => $model->id])?>
</div>

</div>
</div>


<?=$this->render('_view_course', [
            'model' => $model,
			'version' => $version,
			'current' => true

    ]);
?>
</div>
</div>



<?php 
if($version->status == 0 and $model->IAmCoursePic()){
$form = ActiveForm::begin(); 

if($version->prepared_by == 0){
	$version->prepared_by = Yii::$app->user->identity->id;
}

if($version->prepared_at == '0000-00-00'){
	$version->prepared_at = date('Y-m-d');
}

?>

<div class="box box-info">
<div class="box-body">
<div class="row">
<div class="col-md-6"><?=$form->field($version, 'prepared_by')->dropDownList(Staff::activeStaffUserArray(), ['prompt' => 'Choose'])?></div>

<div class="col-md-3">


 <?=$form->field($version, 'prepared_at')->widget(DatePicker::classname(), [
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


$version->file_controller = 'course';
echo UploadFile::fileInput($version, 'preparedsign', true)?>



<div class="row">
<div class="col-md-1">
    <?= $form->field($version, 'prepared_size')->textInput(['maxlength' => true, 'type' => 'number'
                            ])->label('Image Adj Size') ?>
    </div>
<div class="col-md-1">
    <?= $form->field($version, 'prepared_adj_y')->textInput(['maxlength' => true, 'type' => 'number'
                            ])->label('Image Adj Y') ?>
    </div>

</div>


</div>
</div>


	<?=$form->field($version, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>

<div class="form-group" align="center">
        
		<?=Html::submitButton('<span class="fa fa-save"></span> SAVE SIGNITURE', 
    ['class' => 'btn btn-default', 'name' => 'wfaction', 'value' => 'btn-save',
    ])?> <?=Html::submitButton('<span class="glyphicon glyphicon-send"></span> SUBMIT COURSE', 
    ['class' => 'btn btn-warning', 'name' => 'wfaction', 'value' => 'btn-submit', 'data' => [
                'confirm' => 'Are you sure to submit this course information?'
            ],
    ])?>

    </div>

    <?php ActiveForm::end(); 
	
}else{
	echo 'This course information has been submitted at ' . date('d M Y', strtotime($version->prepared_at));
}
	?>



<?php 

function percent($num){
	if($num == 2){
		return 100;
	}else if($num == 1){
		return 50;
	}else{
		return 0;
	}
}

function show_knob($percentage, $title, $url){
	$color = '#0000000';
	$width = $percentage ;
		if($percentage <= 20){
			$color = '#f56954';//danger
		}else if($percentage <= 30){
			$color = '#f56954';//danger
		}else if($percentage <= 60){
			$color = '#f39c12';//warning
		}else if($percentage <= 99){
			$color =  '#00c0ef';//info
		}else if($percentage >= 100){
			$color = '#00a65a';
		}
	return '<div class="col-xs-6 col-md-2 text-center">
<input type="text" class="knob" value="' . $percentage . '" data-skin="tron" data-thickness="0.2" data-width="100" data-readonly="true" data-height="100" data-fgColor="'.$color.'">
<div class="knob-label"><a href="'.Url::to($url).'"> '.$title.'</a></div>
</div>';
}

$this->registerJs('
$(".knob").knob({
            "min":0,
            "max":100,
            "step": 1,
            "displayPrevious": true,
            "readOnly": true,
            "draw" : function () { $(this.i).val(this.cv + "%"); }
        });



');



?>