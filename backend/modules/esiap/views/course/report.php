<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Preview & Submit: ' . $model->course_name . ' '. $model->course_code;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
echo '<b>STATUS: </b>' . $version->labelStatus;
echo '<br /><br />';
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">
<h4>SENARAI FAIL KURSUS</h4>
<table class="table table-striped table-hover">

	<tbody><tr>
		<td width="5%">1.</td>
		<td><span class="glyphicon glyphicon-file"></span> FK01 - PRO FORMA KURSUS / <i>COURSE PRO FORMA</i>                             </td>
		<td><a href="<?=Url::to(['/esiap/course/fk1', 'course' => $model->id])?>" target="_blank" class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
	</tr>
	<tr>
		<td width="5%">2.</td>
		<td><span class="glyphicon glyphicon-file"></span> FK02 - MAKLUMAT KURSUS / <i>COURSE INFORMATION </i>                               </td>
		<td><a href="<?=Url::to(['/esiap/course/fk2', 'course' => $model->id])?>" target="_blank"  class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
	</tr>
	<tr>
		<td width="5%">3.</td>
		<td><span class="glyphicon glyphicon-file"></span> FK03 - PENJAJARAN KONSTRUKTIF / <i>CONSTRUCTIVE ALIGNMENT       </i>                         </td>
		<td><a href="<?=Url::to(['/esiap/course/fk3', 'course' => $model->id])?>" target="_blank" class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
	</tr>
	
</tbody></table>


</div>
</div>

<?php 
if($version->status == 0 and $model->coordinator == Yii::$app->user->identity->id){
$form = ActiveForm::begin(); 

?>

	<?=$form->field($version, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>
	<?=$form->field($version, 'status')->hiddenInput(['value' => 10])->label(false)?>
<div class="form-group" align="center">
        
		<?=Html::submitButton('HANTAR MAKLUMAT KURSUS', 
    ['class' => 'btn btn-warning', 'name' => 'wfaction', 'value' => 'btn-verify', 'data' => [
                'confirm' => 'Adakah anda pasti untuk hantar?'
            ],
    ])?>

    </div>

    <?php ActiveForm::end(); 
	
}
	?>

