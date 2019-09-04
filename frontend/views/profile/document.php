<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\fileupload\FileUpload;


$this->title = "DOKUMEN ASAS";

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->errorSummary($model); ?>






<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?= FileUpload::widget([
    'model' => $model,
    'attribute' => 'profile_file',
	//'label' => 'hai',
    'url' => ['profile/upload-profile', 'id' => $model->id], // your url, this is just for demo purposes,
    'options' => ['accept' => 'image/*'],
    'clientOptions' => [
        'maxFileSize' => 2000000
    ],
    // Also, you can specify jQuery-File-Upload events
    // see: https://github.com/blueimp/jQuery-File-Upload/wiki/Options#processing-callback-options
    'clientEvents' => [
        'fileuploaddone' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
        'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
    ],
]); ?>


 

</div>
</div>


<div class="form-group">
        <?= Html::submitButton('Simpan Dokumen Asas', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>