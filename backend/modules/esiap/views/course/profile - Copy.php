<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Course Proforma: ' . $model->course->course_name . ' '. $model->course->course_code;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Pro Forma';
?>

 <?php $form = ActiveForm::begin(); ?>
	
<div class="box">
<div class="box-header"></div>
<div class="box-body">	

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'prerequisite')->dropDownList($model->course->allCoursesArray()) ?></div>

</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'synopsis')->textarea(['rows' => '6']) ?></div>

<div class="col-md-6"><?= $form->field($model, 'synopsis_bi')->textarea(['rows' => '6']) ?></div>

</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'objective')->textarea(['rows' => '6']) ?></div>

<div class="col-md-6"><?= $form->field($model, 'objective_bi')->textarea(['rows' => '6']) ?></div>
</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'rational')->textarea(['rows' => '6']) ?></div>

<div class="col-md-6"><?= $form->field($model, 'rational_bi')->textarea(['rows' => '6']) ?></div>


</div>

<br />
<div class="form-group">
<label style="font-size:16px">Transferable Skills</label><br />
Skills learned in the course of study which can be useful and utilized in other settings. Please separate items with semi colon (;) only. For you convenience, you may click one of items to be included the transferable textbox below.<br />

<small>
<?php 
$trans_eg = [
['Kemahiran kognitif', 'Cognitive skills'],						
['Kemahiran interpersonal' , 'Interpersonal skills'],						
['Kemahiran komunikasi', 'Communication skills'],			
['Kemahiran digital', 'Digital skills'],		
['Kemahiran pengiraan', 'Numeracy skills'],				
['Kepimpinan, autonomi dan tanggungjawab', 'Leadership, autonomy and responsibility'],
['Kemahiran personal', 'Personal skills'],	
['Kemahiran keusahawanan', 'Entrepreneurial skills'],	
['Etika dan professionalism', 'Ethics and professionalism']
];
$i = 1;
foreach($trans_eg as $eg){
	$comma = $i == 1 ? '' : ', ';
	echo '<a href="javascript:void(0)" class="egskill">' . $eg[0] .' / '. $eg[1] . '</a><br />';
$i++;
}
$this->registerJs('

$(".egskill").click(function(){
	var val = $(this).text();
	//alert(val);
	var arr = val.split("/")
	var bm = arr[0].trim();
	var bi = arr[1].trim();
	$("#courseprofile-transfer_skill").text($("#courseprofile-transfer_skill").text().trim());
	$("#courseprofile-transfer_skill_bi").text($("#courseprofile-transfer_skill_bi").text().trim());
	
	var bm_origin = $("#courseprofile-transfer_skill").text();
	var bi_origin = $("#courseprofile-transfer_skill_bi").text();
	var bm_text = ";" + bm;
	var bi_text = ";" + bi;
	
	
	//alert(bm_text);
	
	$("#courseprofile-transfer_skill").append(bm_text);
	$("#courseprofile-transfer_skill_bi").append(bi_text);
	
	//alert(bm);
});


');
?>
</small>

</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'transfer_skill')->textarea(['rows' => '5']) ?></div>

<div class="col-md-6"><?= $form->field($model, 'transfer_skill_bi')->textarea(['rows' => '5']) ?></div>


</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'feedback')->textarea(['rows' => '4']) ?></div>

<div class="col-md-6"><?= $form->field($model, 'feedback_bi')->textarea(['rows' => '4']) ?></div>


</div>


    
</div>
</div>


    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE COURSE PROFORMA', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


