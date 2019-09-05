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


<?=$this->render('_menu', ['token' => $model->pro_token, 'page' => 'utama'])?>


<div class="site-index">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'pro_name')->textarea(['rows' =>2]) ?>
		<div class="row">
<div class="col-md-3">
 <?=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>


</div>

<div class="col-md-3">



 <?=$form->field($model, 'date_end')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>


</div>

<div class="col-md-4"> <?= $form->field($model, 'pro_time') ?>
</div>

</div>


        <?= $form->field($model, 'location') ?>
		
		
		
        <div class="row">
<div class="col-md-6"><?= $form->field($model, 'purpose')->textarea(['rows' =>5]) ?></div>

<div class="col-md-6"> <?= $form->field($model, 'background')->textarea(['rows' =>5]) ?>
</div>

</div>
		
        
		
        
        
       
        <?= $form->field($model, 'pro_target') ?>
		
		<?= $form->field($model, 'collaboration') ?>
        <?= $form->field($model, 'agency_involved') ?>
        
    <br />
        <div class="form-group">
            <?= Html::submitButton('SIMPAN', ['class' => 'mybtn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-index -->




</div>

</section>
<br /><br /><br /><br /><br /><br />




