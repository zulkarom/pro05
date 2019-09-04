<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Rate;
use backend\models\Campus;

/* @var $this yii\web\View */
/* @var $model common\models\Application */
/* @var $form yii\widgets\ActiveForm */

$accept = $model->getAcceptedCourse();
if($accept){
	$model->selected_course = $accept->course_id;
}


$form = ActiveForm::begin(['id' =>'form-verify']); ?>

<?= $form->errorSummary($model); ?>

<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">BORANG SOKONGAN</h3>

</div>
<div class="box-body">




   
  <div class="row">
  <div class="col-md-3">

<?= $form->field($model, 'selected_course')->dropDownList(
        $model->listAppliedCourses(), ['prompt' => 'Please Select' ]
    ) 
; ?>


</div>
<div class="col-md-3">

<?= $form->field($model, 'group_id')->dropDownList(
        ArrayHelper::map($model->getListGroup(),'id', 'group_name'), ['prompt' => 'Please Select' ]
    ) 
; ?>


</div>

<div class="col-md-3">

<?= $form->field($model, 'rate_amount', [
    'addon' => ['prepend' => ['content'=>'RM']]
]
)->dropDownList(
        ArrayHelper::map(Rate::find()->all(),'rate_amount', 'rate_amount'), ['prompt' => 'Please Select' ]
    ) ->label('Kadar Bayaran (per jam)')
; ?>


</div>



</div>
	
	
<div class="row">
<div class="col-md-7"><?= $form->field($model, 'verify_note')->textarea(['rows' => '4'])  ?>
<i>* click to insert - </i><a href="javascript:void()" id="note-template-1"><span id="template-1">Disokong dengan kadar bayaran RM<span id="temp-amount">80</span><span></a><br /><br /> 
</div>

</div>

<?php 
$this->registerJs('
$("#application-rate_amount").change(function(){
	var val = $(this).val();
	$("#temp-amount").text(val);
});

$("#note-template-1").click(function(){
	var text = $("#template-1").text();
	$("#application-verify_note").append(text);
});

');

?>
    
<div class="form-group"><?=Html::button('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', 
	['class' => 'btn btn-default', 'id' => 'btn-save-verify', 'name' => 'wfaction', 'value' => 'save-verify',
	])?></div>
    

</div>
</div>


<div class="form-group">
	
	<?=Html::button('Kembali Ke Pemohon',
	['class' => 'btn btn-danger', 'id' => 'kembali'
	])?>
	
	<input type="hidden" id="form-choice" name="form-choice" value="save-verify" />
	
	<?=Html::button('Sokong Permohonan', 
	['class' => 'btn btn-warning', 'id' => 'btn-verify', 'name' => 'wfaction', 'value' => 'verify'
	])?>

    </div>
	

<?php 
ActiveForm::end(); 


$js = '
$("#kembali").click(function(){
	var what = confirm("Adalah anda pasti untuk menghantar balik permohonan ini kepada pemohon?");
	if(what){
		window.location.href = "'.Url::to(['application/return-back', 'id' => $model->id ]).'";
	}
});

$("#btn-verify").click(function(){
	var course = $("#application-selected_course").val();
	var group = $("#application-group_id").val();
	var rate = $("#application-rate_amount").val();
	
	
	if(course && group && rate){
		if(confirm("Adakah anda pasti untuk menyokong permohonan ni?")){
			$("#form-choice").val("verify");
			$("#form-verify").submit();
		}
	}else{
		alert("Sila isi semua dulu");
	}
	
	
});

$("#btn-save-verify").click(function(){
	$("#form-choice").val("save-verify");
	$("#form-verify").submit();

});

';

$this->registerJs($js);