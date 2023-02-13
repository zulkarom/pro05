<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Fasi */
/* @var $form ActiveForm */

$this->title = "SENARAI PELAJAR";

?>


<div class="box">
<div class="box-body">




<?php
$err = 'Fail to connect to UMK Portal';

if($response){
	?>

<div class="row">
<div class="col-md-8"><?php 
echo strtoupper('<h4>Semester ' . $model->semester->niceFormat());echo '<br />';
echo $model->acceptedCourse->course->course_code;echo '<br />';
echo $model->acceptedCourse->course->course_name;
echo ' - ' .$model->groupName . '</h4>';
echo '<br />';
?></div>

<div class="col-md-4">
<div class="form-group" align="right"><a href="<?=Url::to(['student/attendance-sheet-pdf', 'a' => $model->id])?>" target="_blank" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-download-alt"></span> Helaian Kehadiran</a>
<a href="<?=Url::to(['student/attendance-summary-pdf', 'a' => $model->id])?>" target="_blank" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-download-alt"></span> Kehadiran (QR Code)</a> </div> 
<div class="form-group" align="right"><a href="<?=Url::to(['student/mark-template-excel', 'a' => $model->id])?>" target="_blank" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-download-alt"></span> Template Markah</a> </div>
</div>

</div>
	
	
	<?php
	if($response->result){
		echo '<table class="table table-striped">
		<thead>
		<tr>
		<th>#</th>
		<th>No. Matrik</th>
		<th>Nama</th>
		</tr>
		</thead>
		';
		$i = 1;
		foreach($response->result as $s){
			echo '<tr>';
			echo '<td>' . $i . '. </td>';
			echo '<td>' . $s->id . '</td>';
			echo '<td>' . $s->name . '</td>';
			echo '</tr>';
		$i++;
		}
		echo '</table>';
	}else{
		echo 'no result';
	}
}else{
	echo $err ;
}
?></div>
</div>

