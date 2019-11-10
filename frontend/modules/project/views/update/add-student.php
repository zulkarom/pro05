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
<div class="col-md-9">



<?= $form->field($student, 'student_name', ['template' => '{label}{input}<i>Gunakan huruf besar permulaan perkataan. e.g Abdul Somad Bin Karim</i>{error}'])->textInput() ?>



<div class="row">
<div class="col-md-6"><?= $form->field($student, 'student_matric') ?></div>

<div class="col-md-6"> <?= $form->field($student, 'program', ['template' => '{label}{input}<i>e.g. SAK, SAR, SAB</i>{error}
            ']
)->textInput(['maxlength' => 5])  ?>
</div>

</div>
      
       
        <?= $form->field($student, 'email') ?></div>


</div>
	
	
  <br />

<div class="form-group">
            <?= Html::submitButton('TAMBAH/EDIT PELAJAR', ['class' => 'btn btn-primary']) ?>
        </div>
        
    <?php ActiveForm::end(); ?>

</div><!-- site-index -->




</div>

</section>
<br /><br /><br /><br /><br /><br />




