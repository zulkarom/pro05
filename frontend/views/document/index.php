<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Upload;
use kartik\widgets\ActiveForm;

use frontend\models\FasiFile;

$this->title = "DOKUMEN";

$model->file_controller = 'document';
?>






<div class="box">
<div class="box-header"></div>
<div class="box-body">


<table class="table table-striped table-hover">

<tbody>
	<tr>
		<td><?=Upload::fileInput($model, 'profile', true)?></td>
	</tr>
	<tr>
		<td><?=Upload::fileInput($model, 'nric')?></td>
	</tr>
	
	<?php 
	/* <tr>
				<td><?=Upload::fileInput($model, 'salary')?></td>
			</tr> */
	
	?>
	
			
	
	
	
	
</tbody>
</table>





 

</div>
</div>

<h1>SIJIL</h1>
<div class="box">
<div class="box-header"></div>
<div class="box-body">


<table class="table table-striped table-hover">

<tbody>
	<?php 
	if($model->fasiFiles){
		foreach($model->fasiFiles as $file){
			$file->file_controller = 'certificate';
			?>
			<tr>
				<td><?=Upload::fileInput($file, 'path', false, true)?></td>
			</tr>
			<?php
		}
	}
	
	?>
</tbody>
</table>
<br />
<a href="<?=Url::to(['certificate/add'])?>" class="btn btn-default" ><span class="glyphicon glyphicon-plus"></span> Tambah Sijil</a>
</div>
</div>

		<div class="form-group">
<label>Status</label> <?=$model->documentStatus();?>
<div></div>
</div>




 <?php $form = ActiveForm::begin()?>
 <?=$form->field($model, 'document_updated_at')->hiddenInput(['value' => time()])->label(false)?>
 <div class="form-group">
            <?= Html::submitButton('Simpan Dokumen', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

