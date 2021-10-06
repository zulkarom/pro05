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
$this->params['breadcrumbs'][] = $model->course_code;
?>
<div class="course-update">


<div class="course-form">

<?=$this->render('_header',[
'course' => $model
])?>


  <a href="<?=Url::to(['/esiap/course/manage-version', 'course' => $model->id])?>" class="btn btn-default"><i class="fa fa-cog"></i> Course Info Version</a>


<?php echo $model->reportList('View Doc Report', $version->id); ?>
<?php 
if(array_key_exists('course-files',Yii::$app->modules)){
	echo Html::a('Back to Course File', ['/course-files/coordinator/current-coordinator-page', 'course' => $model->id], ['class' => 'btn btn-default']);
        }
 ?> 

 <br /> <br />
<?php 
//$version = $model->developmentVersion;

if(in_array($version->status, [0,13])){
	

?>
<div class="box box-solid">
<div class="box-header">
<i class="fa fa-bar-chart-o"></i>

</div>

<div class="box-body">
<?php 
$per = $model->developmentVersion->progress;

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

<?=show_knob($per, 'Overall Progress', [])?>
<?=show_knob($profile, 'Course Profile', ['update', 'course' => $model->id, 'version' => $version->id])?>
<?=show_knob($assess, 'Assessment', ['course-assessment', 'course' => $model->id, 'version' => $version->id])?>
<?=show_knob($clo, 'Course Learning Outcomes', ['course-clo', 'course' => $model->id, 'version' => $version->id])?>
<?=show_knob($plo, 'CLO PLO', ['clo-plo', 'course' => $model->id, 'version' => $version->id])?>
<?=show_knob($tax, 'CLO Taxonomy', ['clo-taxonomy', 'course' => $model->id, 'version' => $version->id])?>
</div>

</div>
</div>


<div class="box box-solid">
<div class="box-header">
<i class="fa fa-bar-chart-o"></i>

</div>
<div class="box-body">
<div class="row">
<?=show_knob($delivery, 'CLO Methods', ['clo-delivery', 'course' => $model->id, 'version' => $version->id])?>
<?=show_knob($assess_per, 'CLO Assessment', ['clo-assessment', 'course' => $model->id, 'version' => $version->id])?>
<?=show_knob($soft, 'CLO Softskill', ['clo-softskill', 'course' => $model->id, 'version' => $version->id])?>
<?=show_knob($syll, 'Syllabus', ['course-syllabus', 'course' => $model->id, 'version' => $version->id])?>
<?=show_knob($slt, 'Student Learning Time', ['course-slt', 'course' => $model->id, 'version' => $version->id])?>
<?=show_knob($ref, 'Reference', ['course-reference', 'course' => $model->id, 'version' => $version->id])?>
</div>

</div>
</div>

<?php } 

if($version->status == 13){
	?>
	
	<div class="box">
<div class="box-header">
<h3 class="box-title" style="color:red"><i class="fa fa-comments"></i> Correction Remark</h3>
</div>
<div class="box-body">
<?php echo nl2br(Html::encode($version->verified_note));?>

</div>
</div>
	
	
	<?php
}
?>




<?=$this->render('_view_course', [
            'model' => $model,
			'version' => $version,
			'current' => true

    ]);
?>
</div>
</div>



<?php 
if(in_array($version->status, [0, 13]) and $model->IAmCoursePic()){
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
<i>
* For the signature, use png format image with transparent background. You can click <a href="https://www.remove.bg/" target="_blank">Remove.bg</a> to easily remove background.<br />
* Approximate size pixel 200 x 100.<br />
* Increase Image Adj Size to make the image bigger and vice versa.<br />
* Increase Image Adj Y Size to move the image upwards and vice versa. <br />
* Is strongly recommended to save signature first and preview your signature in <a href="<?=Url::to(['fk2', 'course' => $model->id, 'version' => $version->id])?>" target="_blank">FK2</a>, <a href="<?=Url::to(['fk3', 'course' => $model->id, 'version' => $version->id])?>" target="_blank">FK3</a> and <a href="<?=Url::to(['tbl4-pdf', 'course' => $model->id, 'version' => $version->id])?>" target="_blank">Table 4</a> before submitting.
</i>
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
	$html = '<div class="col-xs-6 col-md-2 text-center">
<input type="text" class="knob" value="' . $percentage . '" data-skin="tron" data-thickness="0.2" data-width="100" data-readonly="true" data-height="100" data-fgColor="'.$color.'">
<div class="knob-label">';
if($url){
	$html .= '<a href="'.Url::to($url).'"> '.$title.'</a>';
}else{
	$html .= $title;
}


$html .= '</div>
</div>';
	return $html;
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