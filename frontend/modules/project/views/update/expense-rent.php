<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
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


<?=$this->render('_menu', ['token' => $model->pro_token, 'page' => 'belanja'])?>


<h4>Sewaan</h4>
<div class="site-index">

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>

<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.expense-item',
        'limit' => 20,
        'min' => 1,
        'insertButton' => '.add-expense',
        'deleteButton' => '.remove-expense',
        'model' => $expenses[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',
            'exp_name',
            'quantity',
			'amount'
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
                <th>SEWAAN</th>
                <th width="25%">KUANTITI</th>
				<th width="25%">JUMLAH</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($expenses as $i => $expense): ?>
            <tr class="expense-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="icon icon-arrows-alt"></i>
                    </td>
            
                <td class="vcenter">
                    <?php
                        // necessary for upexpense action.
                        if (! $expense->isNewRecord) {
                            echo Html::activeHiddenInput($expense, "[{$i}]id");
                        }
                    ?>
                    <?= $form->field($expense, "[{$i}]exp_name")->label(false) ?>
                </td>
				
				<td class="vcenter">
                    <?= $form->field($expense, "[{$i}]quantity")->label(false) ?>
                </td>
                
                <td class="vcenter">
					<?= $form->field($expense, "[{$i}]amount")->label(false) ?>


                </td>

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-expense btn btn-default btn-sm"><span class="icon icon-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
            <td></td>
                <td colspan="3">
                <button type="button" class="add-expense btn btn-default btn-sm"><span class="icon icon-plus"></span> Tambah Perbelanjaan</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>


       
        
    <br />
        <div class="form-group">
            <?= Html::submitButton('SIMPAN', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-index -->




</div>

</section>
<br /><br /><br /><br /><br /><br />



<?php

$js = <<<'EOD'

var fixHelperSortable = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};

$(".container-items").sortable({
    items: "tr",
    cursor: "move",
    opacity: 0.6,
    axis: "y",
    handle: ".sortable-handle",
    helper: fixHelperSortable,
    update: function(ev){
        $(".dynamicform_wrapper").yiiDynamicForm("updateContainer");
    }
}).disableSelection();

EOD;

JuiAsset::register($this);
$this->registerJs($js);
?>

