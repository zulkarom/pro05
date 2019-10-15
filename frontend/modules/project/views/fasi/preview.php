<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\Project */

$this->title = 'Lihat & Hantar Kertas Kerja';
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-update">
<div class="box">
<div class="box-body">

<h3><?=$model->pro_name?></h3>

<br />

<?php 

if($model->status == 0){
?>
<a href="<?=Url::to(['update/index', 'token' => $model->pro_token])?>" target="_blank"><b><span class="glyphicon glyphicon-download-alt"></span> KEMASKINI KERTAS KERJA DI SINI</b></a>
<?php
}else{
?>
<a href="<?=Url::to(['update/download', 'token' => $model->pro_token])?>" target="_blank"><b><span class="glyphicon glyphicon-download-alt"></span> LIHAT KERTAS KERJA DI SINI</b></a>
<?php
}


?>



<?php $form = ActiveForm::begin(); ?>
<?=$form->field($model, 'status')->hiddenInput(['value' => 20])->label(false)?>
     <?php
	 if ($model->status == 0){
		 echo 'KERTAS KERJA DALAM STATUS DERAF DAN BELUM DIHANTAR UNTUK DISEMAK<br />';
	 }else if($model->status == 20){
		 echo 'KERTAS KERJA TELAH DIHANTAR KE PUSAT KOKURIKULUM<br />';
	 }
	 ?>
        
    <br />
        <div class="form-group">
            <?php 
			if($model->status == 10){
				echo Html::submitButton('<span class="glyphicon glyphicon-arrow-left"></span> KEMBALI KEMASKINI', ['class' => 'btn btn-warning', 'name' => 'wfaction', 'value' => 'return']);
				echo ' ';
				
				echo Html::submitButton('HANTAR KE PUSAT KOKURIKULUM', ['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'submit']);
			}
			 
			
			
			?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
</div>

   

</div>
