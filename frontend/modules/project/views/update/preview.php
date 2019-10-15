<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

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


<?php 
if ($model->status == 0){
	echo $this->render('_menu', ['token' => $model->pro_token, 'page' => 'hantar']);
}
?>


<div class="site-index">

    <?php $form = ActiveForm::begin(); ?>
<?=$form->field($model, 'status')->hiddenInput(['value' => 10])->label(false)?>
     <?php
	 if ($model->status > 0){
		 echo 'KERTAS KERJA TELAH DIHANTAR<br />';
	 }
	 ?>
        
    <br />
        <div class="form-group">
		<?= Html::a('<i class="icon icon-download"></i> LIHAT PDF', ['download', 'token' => $model->pro_token], ['class' => 'btn btn-danger', 'target' => '_blank']) ?>  
            <?php 
			if($model->status == 0){
				echo Html::submitButton('HANTAR KE FASILITATOR', ['class' => 'btn btn-warning']);
			}
			 
			
			
			?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-index -->




</div>

</section>
<br /><br /><br /><br /><br /><br />




