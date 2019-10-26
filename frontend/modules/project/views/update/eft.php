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
<div class="col-md-11">

<div class="row">
<div class="col-md-7"><?= $form->field($model, 'eft_name') ?></div>

<div class="col-md-5"><?= $form->field($model, 'eft_ic') ?>
</div>

</div>


<div class="row">
<div class="col-md-4"><?php 
$list = ['BIMB'=>'BIMB', 'MAYBANK'=>'MAYBANK', 'CIMB'=>'CIMB', 'BSNB'=>'BSNB', 'AMBANK'=>'AMBANK', 'RHB'=>'RHB', 'BANK MUAMALAT'=>'BANK MUAMALAT', 'BANK RAKYAT'=>'BANK RAKYAT', 'PUBLIC BANK'=>'PUBLIC BANK'  , 999 => 'LAIN-LAIN (SILA NYATAKAN)'];

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
?></div>

<div class="col-md-6"><?= $form->field($model, 'eft_account') ?>
</div>

</div>


<div class="row">
<div class="col-md-7"><?= $form->field($model, 'eft_email') ?></div>

</div>




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
