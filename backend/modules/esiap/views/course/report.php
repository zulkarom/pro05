<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use backend\modules\staff\models\Staff;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Preview & Submit';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Preview & Submit';


?>

<?=$this->render('_header',[
'course' => $model
])?>

<?php echo '<b>STATUS: </b>' . $version->labelStatus;
echo '<br /><br />';
?>

<div class="box box-danger">
<div class="box-body">
<h4>SENARAI FAIL KURSUS</h4>
<table class="table table-striped table-hover">

	<tbody><tr>
		<td width="5%">1.</td>
		<td><span class="glyphicon glyphicon-file"></span> FK01 - PRO FORMA KURSUS / <i>COURSE PRO FORMA</i>                             </td>
		<td><a href="<?=Url::to(['/esiap/course/fk1', 'course' => $model->id, 'dev' => 1])?>" target="_blank" class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
	</tr>
	<tr>
		<td width="5%">2.</td>
		<td><span class="glyphicon glyphicon-file"></span> FK02 - MAKLUMAT KURSUS / <i>COURSE INFORMATION </i>                               </td>
		<td><a href="<?=Url::to(['/esiap/course/fk2', 'course' => $model->id, 'dev' => 1])?>" target="_blank"  class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
	</tr>
	<tr>
		<td width="5%">3.</td>
		<td><span class="glyphicon glyphicon-file"></span> FK03 - PENJAJARAN KONSTRUKTIF / <i>CONSTRUCTIVE ALIGNMENT       </i>                         </td>
		<td><a href="<?=Url::to(['/esiap/course/fk3', 'course' => $model->id, 'dev' => 1])?>" target="_blank" class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
	</tr>
	
	<tr>
		<td width="5%">2.</td>
		<td><span class="glyphicon glyphicon-file"></span>TABLE 4 - MAKLUMAT KURSUS / <i>COURSE INFORMATION </i>                               </td>
		<td><a href="<?=Url::to(['/esiap/course/tbl4-excel', 'course' => $model->id, 'dev' => 1])?>" target="_blank"  class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span> EXCEL</a> <a href="<?=Url::to(['/esiap/course/tbl4', 'course' => $model->id, 'dev' => 1])?>" target="_blank"  class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span> PDF</a></td>
	</tr>
	
</tbody></table>


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


</div>
</div>


	<?=$form->field($version, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>

<div class="form-group" align="center">
        
		<?=Html::submitButton('<span class="glyphicon glyphicon-send"></span> SUBMIT COURSE', 
    ['class' => 'btn btn-warning', 'name' => 'wfaction', 'value' => 'btn-verify', 'data' => [
                'confirm' => 'Are you sure to submit this course information?'
            ],
    ])?>

    </div>

    <?php ActiveForm::end(); 
	
}else{
	echo 'This course information has been submitted at ' . date('d M Y', strtotime($version->prepared_at));
}
	?>

