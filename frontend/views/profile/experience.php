<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use kartik\date\DatePicker;

$this->title = "PENGALAMAN";
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<?=$form->field($model, 'expe_updated_at')->hiddenInput(['value' => time()])->label(false)?>

<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.expe-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-expe',
        'deleteButton' => '.remove-expe',
        'model' => $experience[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'place',
			'expe_date',
			'field'
        ],
    ]); ?>
	
	
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
				<th width="5%"></th>
                <th>Tempat</th>
				<th width="15%">Tarikh Mula<br />
				<i><small style="font-weight:normal">(tahun-bulan-hari)</small></i></th>
				<th width="15%">Tarikh Akhir<br />
				<i><small style="font-weight:normal">(tahun-bulan-hari)</small></i></th>
				<th width="25%">Bidang</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($experience as $indexExpe => $expe): ?>
            <tr class="expe-item">
				<td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows"></i>
                    </td>
			
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $expe->isNewRecord) {
                            echo Html::activeHiddenInput($expe, "[{$indexExpe}]id");
                        }
                    ?>
                    <?= $form->field($expe, "[{$indexExpe}]place")->label(false) ?>
                </td>
				
				<td class="vcenter">
          
					
					 <?=$form->field($expe, "[{$indexExpe}]date_start")->widget(DatePicker::classname(), [
						'removeButton' => false,
						'pluginOptions' => [
							'autoclose'=>true,
							'format' => 'yyyy-mm-dd',
							'todayHighlight' => true,
							
						],
						
						
					])->label(false);

					?>

                </td>
				
				<td class="vcenter">					
					<?=$form->field($expe, "[{$indexExpe}]date_end")->widget(DatePicker::classname(), [
						'removeButton' => false,
						'pluginOptions' => [
							'autoclose'=>true,
							'format' => 'yyyy-mm-dd',
							'todayHighlight' => true,
							
						],
						
						
					])->label(false);

					?>
					
                </td>
				
				<td class="vcenter">
                    <?= $form->field($expe, "[{$indexExpe}]field")->label(false) ?>
                </td>

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-expe btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
		
		<tfoot>
            <tr>
			<td></td>
                <td colspan="3">
				<button type="button" class="add-expe btn btn-default btn-sm"><span class="fa fa-plus"></span> Tambah Pengalaman</button>
				
				</td>
                <td>
				
				
				</td>
            </tr>
        </tfoot>
		
    </table>
	
		<div class="form-group">
<label>Status</label> <?=$model->listStatus('expe_updated_at', 'fasiExpes');?>
<div></div>
</div>
	
	
	
    <?php DynamicFormWidget::end(); ?>
	
	<div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan Pengalaman', ['class' => 'btn btn-primary']) ?>
    </div>


	<?php ActiveForm::end(); ?></div>
</div>
	


<?php
$js = <<<'EOD'

jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
	$( ".krajee-datepicker" ).each(function() {
	   $(this).removeData().kvDatepicker('destroy');
		$(this).kvDatepicker(eval($(this).attr('data-krajee-kvdatepicker')));
  });          
});

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