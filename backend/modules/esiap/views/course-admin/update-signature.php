<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\UploadFile;


/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Preparer Signature' ;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
$version = $model;
?>


<?php 
$form = ActiveForm::begin(); 
?>
<h4><?=$model->course->course_name?></h4>
<h4><?=$model->version_name?></h4>
<div class="box">
<div class="box-body">


<?php 


$version->file_controller = 'course';
echo UploadFile::fileInput($version, 'preparedsign', true)?>



<div class="row">
<div class="col-md-1">
    <?= $form->field($version, 'prepared_size')->textInput(['maxlength' => true, 'type' => 'number'
                            ])->label('Image Adj Size') ?>
    </div>
<div class="col-md-1">
    <?= $form->field($version, 'prepared_adj_y')->textInput(['maxlength' => true, 'type' => 'number'
                            ])->label('Image Adj Y') ?>
    </div>

</div>
</div>
</div>


	<?=$form->field($version, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>

<div class="form-group" align="center">
        
		<?=Html::submitButton('<span class="fa fa-save"></span> SAVE SIGNITURE', 
    ['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'btn-save',
    ])?>

    </div>

    <?php ActiveForm::end(); 
	
	?>

