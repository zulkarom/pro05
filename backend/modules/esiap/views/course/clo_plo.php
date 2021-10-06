<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use backend\modules\esiap\models\AssessmentCat;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'CLO vs. PLO';
$this->params['breadcrumbs'][] = ['label' => 'Preview', 'url' => ['course/view-course', 'course' => $model->course_id, 'version' => $model->id]];
$this->params['breadcrumbs'][] = 'CLO vs. PLO';
$form = ActiveForm::begin(['id' => 'form-clo-plo']);
?>

<?=$this->render('_header',[
'course' => $model->course, 
    'version' => $model
])?>
<div class="box">
<div class="box-header"></div>
<div class="box-body">

* Put only one PLO for each CLO

<?php

$plo_num = $model->ploNumber;



echo $form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false);

if($clos){
	echo '<table class="table">
	<thead>
	<tr>
		<th width="6%">#</th>
		<th width="50%">CLO</th>';
	
	for($i=1;$i<=$plo_num;$i++){
		echo '<th>PLO'.$i.'</th>';
	}
		
	echo '</tr>
	</thead>
	';
	$x = 1;
	
	foreach($clos as $index => $clo){
		echo '<tr>';
		echo '<td style="vertical-align:middle;" >CLO'.$x.'</td>';
		echo '<td style="vertical-align:middle;">' . $clo->clo_text . '<br /><i>'.$clo->clo_text_bi.'</i> '.$clo->taxoPloBracket.'</td>';
		
		for($i=1;$i<=$plo_num;$i++){
			$prop = 'PLO'.$i;
			$check = $clo->{$prop} == 1 ? 'checked' : '';
			echo '<td>';
			echo '<input type="hidden" name="plo['.$clo->id .'][PLO'.$i.']" value="0" />';
			echo '<input type="checkbox" class="chk-plo" data="clo-'.$clo->id .'" name="plo['.$clo->id .'][PLO'.$i.']" value="1" '.$check.' />';
			echo '</td>';
		}
		
		echo '</tr>';
		
		$x++;
	}
	echo '</table>';
}
?>



</div>
</div>

<div class="form-group">
<?php 
$check = $model->pgrs_plo == 2 ? 'checked' : ''; ?>
<label>
<input type="checkbox" id="complete" name="complete" value="1" <?=$check?> /> Mark as complete
</label></div>


<div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE CLO PLO', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end()?>

<?php JSRegister::begin(); ?>
<script>

$(".chk-plo").click(function(){
	var val = $(this).attr("data");
	$('input[data="' + val + '"]').each(function(){
		$(this).prop('checked' , false)
	});
	
	$(this).prop('checked' , true);

});

</script>
<?php JSRegister::end(); ?>