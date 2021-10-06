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
$model = $version->course;
?>
<div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<div class="row">


<div class="col-md-7" align="right">


</div>

</div>



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

</div>  <br />


<?=$this->render('../course/_view_course', [
            'model' => $version->course,
			'version' => $version,
			'current' => false

    ]);
?>



<?php $form = ActiveForm::begin(); ?>
<div class="box box-info">
<div class="box-body">
<div class="row">

<div class="col-md-3">

<?php 
$version->verified_at = date('Y-m-d');
?>
 <?=$form->field($version, 'verified_at')->widget(DatePicker::classname(), [
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


 <?=$form->field($version, 'faculty_approve_at')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
])->label('Faculty\'s Approval At');
?>

</div>
<div class="col-md-3">


 <?=$form->field($version, 'senate_approve_at')->widget(DatePicker::classname(), [
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
    <?= $form->field($version, 'verified_size')->textInput(['maxlength' => true, 'type' => 'number'
                            ])->label('Image Size Adj')?>
    </div>
<div class="col-md-1">
    <?= $form->field($version, 'verified_adj_y')->textInput(['maxlength' => true, 'type' => 'number'
    ])->label('Vert.Position Adj')?>
    </div>

</div>

<i>
* 
* For the signature, use png format image with transparent background. You can click <a href="https://www.remove.bg/" target="_blank">Remove.bg</a> to easily remove background.<br />
* Approximate size pixel 200 x 100.<br />
* Increase Image Size Adj to make the image bigger and vice versa.<br />
* Increase Vertical Position Adj to move the image upwards and vice versa. <br />
</i>
<br />

<?php /* =Html::submitButton('<span class="fa fa-save"></span> SAVE SIGNITURE', 
    ['class' => 'btn btn-default btn-sm', 'name' => 'actiontype', 'value' => 'save',
    ]) */?> 
	
<div class="form-group">	<?= Html::submitButton('<span class="fa fa-check"></span> Verify Course Version', ['class' => 'btn btn-success', 'name'=> 'actiontype', 'value' => 'verify']) ?> </div>
	
	
</div>
</div>
<?php ActiveForm::end(); ?>





<?php $form = ActiveForm::begin(); ?>
<div class="box box-danger">
<div class="box-body">

<div class="row">
<div class="col-md-8">
<?= $form->field($reject_form, 'verified_note')->textarea(['rows' => '4'])->label('Note for reupdate') ?>
</div>

</div>

	

<div class="form-group"><?= Html::submitButton('Return to Reupdate', ['class' => 'btn btn-warning', 'name'=> 'actiontype', 'value' => 'unverify']) ?></div>
	
	
</div>
</div>
<?php ActiveForm::end(); ?>




</div>
