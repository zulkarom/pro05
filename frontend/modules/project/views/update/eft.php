<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;

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


<?=$this->render('_menu', ['token' => $model->pro_token, 'page' => 'eft'])?>

<h3>Borang EFT</h3>
<i>* Borang maklumat akaun bank bagi tujuan bayaran secara EFT</i>

<br /><br />


<?php $form = ActiveForm::begin(); ?>

<div class="row">
<div class="col-md-8">


<?= $form->field($model, 'eft_name') ?>
<?= $form->field($model, 'eft_ic') ?>
<?= $form->field($model, 'eft_account') ?>


<?php 
$list = ['BIMB'=>'BIMB', 'MAYBANK'=>'MAYBANK', 'CIMB'=>'CIMB', 'BSNB'=>'BSNB', 999 => 'LAIN-LAIN (SILA NYATAKAN)'];

$drop = false;
if($model->eft_bank){
	if(in_array($model->eft_bank, $list)){
		$drop = true;
	}
}else{
	$drop = true;
}

if($drop){
	echo $form->field($model, 'eft_bank', ['template' => '{label}<div id="con-bank">{input}</div>{error}'])->dropDownList($list);
}else{
	echo $form->field($model, 'eft_bank');
}




?>
<?= $form->field($model, 'eft_email') ?>


</div>
</div>




   <br />
        <div class="form-group">
            <?= Html::submitButton('SIMPAN', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
	
	
	

</div>




</section>



 <br /> <br />
 
 <?php JSRegister::begin(); ?>
<script>
$("#project-eft_bank").change(function(){
    var val = $(this).val();
    if(val == 999){
        var html = '<input type="text" id="project-eft_bank" placeholder="Sila Nyatakan..." class="form-control" name="Project[eft_bank]" / >';
        $("#con-bank").html(html);
    }
});
</script>
<?php JSRegister::end(); ?>
