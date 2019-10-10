<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\date\DatePicker;


/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\Project */
/* @var $form ActiveForm */

?>

<section class="ftco-services ftco-no-pb">

<div class="container">
<div class="heading-section" align="center">
	<h2 class="mb-4"><span>Kemaskini Kertas Kerja</span> </h2>   
  </div>


<?=$this->render('_header', ['model' => $model])?> 	  


<?=$this->render('_menu', ['token' => $model->pro_token, 'page' => 'student'])?>


<div class="site-index">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row">
<div class="col-md-5"> <?= $form->field($student, 'student_matric', ['template' => '<div class="row">
            <div class="col-sm-3">{label}</div>
            <div class="col-sm-8">{input}{error}
            </div>
            </div>'])->textInput() ?></div>

<div class="col-md-5"><div class="form-group">
            <?= Html::submitButton('SETERUSNYA', ['class' => 'btn btn-warning']) ?>
        </div>
</div>

</div>


        
    <?php ActiveForm::end(); ?>

</div><!-- site-index -->




</div>

</section>
<br /><br /><br /><br /><br /><br />




