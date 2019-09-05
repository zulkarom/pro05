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


<?=$this->render('_menu', ['token' => $model->pro_token, 'page' => 'pendapatan'])?>


<div class="site-index">

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>

<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.resource-item',
        'limit' => 20,
        'min' => 1,
        'insertButton' => '.add-resource',
        'deleteButton' => '.remove-resource',
        'model' => $resources[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',
            'rs_name',
            'rs_quantity',
			'rs_amount'
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
                <th>PENDAPATAN</th>
                <th width="25%">KUANTITI</th>
				<th width="25%">JUMLAH</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($resources as $i => $resource): ?>
            <tr class="resource-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="icon icon-arrows-alt"></i>
                    </td>
            
                <td class="vcenter">
                    <?php
                        // necessary for upresource action.
                        if (! $resource->isNewRecord) {
                            echo Html::activeHiddenInput($resource, "[{$i}]id");
                        }
                    ?>
                    <?= $form->field($resource, "[{$i}]rs_name")->label(false) ?>
                </td>
				
				<td class="vcenter">
                    <?= $form->field($resource, "[{$i}]rs_quantity")->label(false) ?>
                </td>
                
                <td class="vcenter">
					<?= $form->field($resource, "[{$i}]rs_amount")->label(false) ?>


                </td>

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-resource btn btn-default btn-sm"><span class="icon icon-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
            <td></td>
                <td colspan="3">
                <button type="button" class="add-resource btn btn-default btn-sm"><span class="icon icon-plus"></span> Tambah Pendapatan</button>
                
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

