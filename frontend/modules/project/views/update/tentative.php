<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;


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


<?=$this->render('_menu', ['token' => $model->pro_token, 'page' => 'tentatif'])?>


<div class="person-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

     <?=$form->field($model, 'updated_at')->hiddenInput(['value' => 1])->label(false)?>


    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.day-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-day',
        'deleteButton' => '.remove-day',
        'model' => $days[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'description',
        ],
    ]); ?>
   <div > <table class="table">

        <tbody class="container-items">
        <?php foreach ($days as $indexDay => $day): ?>
            <tr class="day-item">
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $day->isNewRecord) {
                            echo Html::activeHiddenInput($day, "[{$indexDay}]id");
                        }
                    ?>
					
					<div class="row">
<div class="col-md-2">


<?=$form->field($day, "[{$indexDay}]pro_date")->widget(DatePicker::classname(), [
						'removeButton' => false,
						'pluginOptions' => [
							'autoclose'=>true,
							'format' => 'yyyy-mm-dd',
							'todayHighlight' => true,
							
						],
						
						
					])->label('Tarikh');
					?></div>
					<div class="col-md-4">
					<div class="form-group">&nbsp;</div>
					
					<button style="font-size:15px" type="button" class="remove-day btn btn-default btn-sm"><span class="icon icon-remove"></span> Buang Hari</button></div>

</div>
					 

					
					
					
					<?= $this->render('_form-times', [
                        'form' => $form,
                        'indexDay' => $indexDay,
                        'times' => $times[$indexDay],
                    ]) ?>
					
                </td>
      
    
            </tr>
         <?php endforeach; ?>
        </tbody>
	<tfoot>
            <tr>
                <td colspan="2">
                <button style="font-size:15px" type="button" class="add-day btn btn-default btn-sm"><span class="icon icon-plus"></span> Tambah Hari</button>
                
                </td>
             
            </tr>
        </tfoot>
    </table></div>
    <?php DynamicFormWidget::end(); ?>
    
    <div class="form-group">
        <?= Html::submitButton('SIMPAN', ['class' => 'btn btn-primary', 'style' => 'font-size:19px']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>




</div>

</section>


<?php

$js = <<<'EOD'

jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    $( ".krajee-datepicker" ).each(function() {
       $(this).removeData().kvDatepicker('destroy');
        $(this).kvDatepicker(eval($(this).attr('data-krajee-kvdatepicker')));
  });          
});

jQuery(".dynamicform_inner").on("afterInsert", function(e, item) {

    $( ".krajee-timepicker" ).each(function() {
       $(this).removeData().timepicker('destroy');
        $(this).timepicker(eval($(this).attr('data-krajee-timepicker')));
  });          
});


EOD;

$this->registerJs($js);
?>



