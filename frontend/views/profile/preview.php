<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Upload;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Fasi */
/* @var $form ActiveForm */

$this->title = "PREVIEW";



?>
<style>
table.detail-view th {
	width:25%;
}
</style>


<div class="row">
<div class="col-md-6">

<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">MAKLUMAT PERIBADI</h3>

</div>
<div class="box-body">

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		
		'user.fullname',
		'user.email',
		'nric',
		'handphone',
		'genderName',
		'marital',
		'citizenName',
		'address_postal',
		'address_home',
		'birth_date:date',
        'birth_place',
		[
			'attribute' =>'distance_umk',
			'value' => $model->distance_umk . ' KM',
		],
		[
			'attribute' => 'personal_updated_at',
			'label' => 'Status',
			'format' => 'html',
			'value' => function($model){
				return $model->profileStatus('personal_updated_at');
			}
		]
		

        ],
    ]) ?>
	<br />
	<div class="form-group">
<?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Kemaskini Maklumat Peribadi', ['profile/index'], ['class' => 'btn btn-default']) ?>
</div>

</div>
</div></div>
<div class="col-md-6"><div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">MAKLUMAT PEKERJAAN</h3>

</div>
<div class="box-body">

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		
		'position_work',
		'position_grade',
		'department',
		'salary_grade', 
		'salary_basic', 
		'address_office', 
		'office_phone',
		'office_fax',
		'inStudy',
		'umkStaff',
		'staff_no',
		[
			'attribute' => 'job_updated_at',
			'label' => 'Status',
			'format' => 'html',
			'value' => function($model){
				return $model->profileStatus('job_updated_at');
			}
		]

        ],
    ]) ?>
<br />
	<div class="form-group">
<?= Html::a('<span class="glyphicon glyphicon-pencil"></span>  Kemaskini Maklumat Pekerjaan', ['profile/job'], ['class' => 'btn btn-default']) ?>
</div>

</div>
</div></div>
</div>



<div class="row">
<div class="col-md-6"><div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">MAKLUMAT PENDIDIKAN</h3>

</div>
<div class="box-body">

<table class="table table-striped table-hover">
<thead>
<tr>
	<th>Nama (Institusi)</th>
	<th>Tahun Graduasi</th>
	<th>Tahap</th>
</tr>
</thead>
<tbody>

<?php 
$edus = $model->fasiEdus;
if($edus){
	foreach($edus as $edu){
		echo '<tr>
		<td>'.$edu->edu_name .' ('.$edu->institution .')</td>
		<td>'.$edu->year_grad .'</td>
		<td>'.$edu->levelName->edu_name .'</td>
	</tr>';
	}
}

?>



	
</tbody>
</table>

<br />

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		[
			'attribute' => 'edu_updated_at',
			'label' => 'Status',
			'format' => 'html',
			'value' => function($model){
				return $model->listStatus('edu_updated_at', 'fasiEdus');
			}
		]

        ],
    ]) ?>


<br />
	<div class="form-group">
<?= Html::a('<span class="glyphicon glyphicon-pencil"></span>  Kemaskini Maklumat Pendidikan', ['profile/education'], ['class' => 'btn btn-default']) ?>
</div>

</div>
</div></div>
<div class="col-md-6"><div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">MAKLUMAT PENGALAMAN</h3>

</div>
<div class="box-body">

<table class="table table-striped table-hover">
<thead>
<tr>
	<th>Tempat</th>
	<th>Tempoh</th>
	<th>Bidang</th>
</tr>
</thead>
<tbody>
<?php 
$expes = $model->fasiExpes;
if($expes){
	foreach($expes as $expe){
		echo '<tr>
		<td>'.$expe->place .'</td>
		<td>'.date('M Y', strtotime($expe->date_start)) .' - '. date('M Y', strtotime($expe->date_end)) .'</td>
		<td>'.$expe->field .'</td>
	</tr>';
	}
}

?>
</tbody>
</table>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		[
			'attribute' => 'expe_updated_at',
			'label' => 'Status',
			'format' => 'html',
			'value' => function($model){
				return $model->listStatus('expe_updated_at', 'fasiExpes');
			}
		]

        ],
    ]) ?>


<br />
	<div class="form-group">
<?= Html::a('<span class="glyphicon glyphicon-pencil"></span>  Kemaskini Maklumat Pengalaman', ['profile/experience'], ['class' => 'btn btn-default']) ?>
</div>

</div>
</div></div>
</div>


<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">DOKUMEN</h3>

</div>
<div class="box-body">

<table id="w1" class="table table-striped table-bordered detail-view">

<tbody><tr>

<th>Gambar</th><td>
<?=Upload::showFile($model, 'profile', 'document') ?></td>

<th>Kad Pengenalan</th><td><?=Upload::showFile($model, 'nric', 'document') ?></td>

</tr>

<tr><th >Sijil</th><td colspan="3">

<?php 

if($model->fasiFiles){
	foreach($model->fasiFiles as $f){
		echo Upload::showFile($f, 'path', 'certificate') .' ';
	}
}
?>



</td></tr>


</tbody></table>
<br />
<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
		[
			'attribute' => 'document_updated_at',
			'label' => 'Status',
			'format' => 'html',
			'value' => function($model){
				return $model->documentStatus();
			}
		]

        ],
    ]) ?>

<br />
	<div class="form-group">
<?= Html::a('<span class="glyphicon glyphicon-pencil"></span>  Kemaskini Dokumen', ['document/index'], ['class' => 'btn btn-default']) ?>
</div>

</div>
</div>



 <?php $form = ActiveForm::begin(); ?>
 
 <?=$form->field($model, 'updated_at')->hiddenInput(['value' => 1])->label(false)?>
 
    <div class="form-group">
	 
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> KEMASKINI SEMUA', ['class' => 'btn btn-primary']) ?>
    </div>

 <?php ActiveForm::end(); ?>



