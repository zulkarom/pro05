<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use kartik\date\DatePicker;
use common\models\SessionType;
use common\models\Hour;
use common\models\Upload;


$form = ActiveForm::begin(['id' => 'dynamic-form']); 
 
 echo $form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false);
 
 echo $form->field($model, 'month')->hiddenInput()->label(false);
 
 echo $form->field($model, 'year')->hiddenInput()->label(false);
 
 ?>


<div class="box">
<div class="box-header">

<h3 class="box-title">BAHAGIAN B</h3>

</div>
<div class="box-body"><div class="claim-form">

<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.claim-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-item',
        'deleteButton' => '.remove-item',
        'model' => $items[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'item_date',
			'hour_start',
			'hour_end',
			'session_type'
        ],
    ]);  ?>
	
	<input type="hidden" id="fasi-rate" value="<?=$model->application->rate_amount?>" />
    <div class="table-responsive"><table style="min-width:1000px" class="table table-bordered table-striped">
        <thead>
            <tr>
				<th width="3%"></th>
                <th width="17%">Tarikh</th>
				<th width="13%">Masa Mula</th>
				<th width="13%">Masa Akhir</th>
				<th width="17%">Jenis Sesi</th>
				<th width="13%">Pengiraan</th>
				<th>Jumlah</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($items as $indexItem => $item): ?>
            <tr class="claim-item">
				<td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows"></i>
                    </td>
			
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $item->isNewRecord) {
                            echo Html::activeHiddenInput($item, "[{$indexItem}]id");
                        }
                    ?>
					
					<?=Html::activeHiddenInput($item, "[{$indexItem}]claim_id", ['value' => $model->id]);?>
					
			
                 
					
					<?=$form->field($item, "[{$indexItem}]item_date")->widget(DatePicker::classname(), [
						'removeButton' => false,
			
						'pluginOptions' => [
							'autoclose'=>true,
							'format' => 'yyyy-mm-dd',
							'todayHighlight' => true,
							'value' => date('Y-d-m')
							
						],
						
						
					])->label(false);

					?>
					
					
                </td>
				
				<td class="vcenter">
          
					
					
					
					<?= $form->field($item, "[{$indexItem}]hour_start")->dropDownList(
					ArrayHelper::map(Hour::find()->all(),'id', 'hour_format'), ['class'=>'form-control calc-amount calc-all' ,'prompt' => 'Please Select' ]
					)->label(false) ?>


                </td>
				
				<td class="vcenter">
				
					<?= $form->field($item, "[{$indexItem}]hour_end")->dropDownList(
					ArrayHelper::map(Hour::find()->all(),'id', 'hour_format'), ['class'=>'form-control calc-amount' ,'prompt' => 'Please Select' ]
					)->label(false) ?>
					
                </td>
				
				<td class="vcenter">
                    <?= $form->field($item, "[{$indexItem}]session_type")->dropDownList(
					ArrayHelper::map(SessionType::find()->all(),'id', 'type_name'), ['prompt' => 'Please Select' ]
					)->label(false) ?>
                </td>
				<td class="calc-detail">
				</td>
				<td class="calc-sub-total"></td>

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-item btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
		
		<tfoot>
            <tr>
			<td></td>
                <td colspan="4">
				<button type="button" class="add-item btn btn-default btn-sm"><span class="fa fa-plus"></span> New Item</button>
				
				</td>
                <td><strong id="claim-total-hour"></strong></td>
				<td><strong id="claim-total"></strong></td>
				<td></td>
            </tr>
        </tfoot>
		
    </table></div>
	
	<input type="hidden" value="<?=count($items)?>" id="total-items" />
	
	
	<div class="row">
<div class="col-md-6"><i>* maksimum jam dalam sebulan : <span id="max_month"><?=$setting->hour_max_month?></span></i><br />
	
	<i>* jumlah jam tuntutan ini : <span id="total-this"></span></i><br />
	
	<span style="color:red;display:none" id="warning-month"><span class="glyphicon glyphicon-exclamation-sign"></span> <i>Jumlah jam telah melebihi had maksimum tuntutan dalam sebulan</i></span>
	
	</div>


<div class="col-md-6"><i>* maksimum jam satu semester : <span id="max_sem"><?=$setting->hour_max_sem?></span></i><br />
	<i>* jumlah jam telah dituntut semester ini : <span id="claimed_sem"><?=$model->getHoursClaimedByApp()?></span></i><br />
	
	<span style="color:red; display:none" id="warning-semester"><span class="glyphicon glyphicon-exclamation-sign"></span> <i>Jumlah jam telah melebihi had maksimum tuntutan dalam satu semester</i></span>
	</div>
</div>
	
	
	
	
    <?php DynamicFormWidget::end(); ?>

    
  

</div></div>
</div>


<div class="box">
<div class="box-body">


<table class="table table-striped table-hover">

<tbody>
	<?php 
	if($model->claimFiles){
		foreach($model->claimFiles as $file){
			$file->file_controller = 'claim';
			?>
			<tr>
				<td><?=Upload::fileInput($file, 'claim', false, true)?></td>
			</tr>
			<?php
		}
	} 
	
	?>
</tbody>

</table>
<br />
<button type="submit" class="btn btn-default" name="wflow" value="add-file" ><span class="glyphicon glyphicon-plus"></span> Tambah Salinan Kehadiran</button>

</div>
</div>


<?php if($model->getWfStatus() == 'draft' or $model->getWfStatus() == 'returned'){ ?>
 <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan', ['class' => 'btn btn-default', 'name' => 'wflow', 'value' => 'draft']) ?> 
		
		<?= Html::submitButton('<span class="glyphicon glyphicon-send"></span> Hantar', ['class' => 'btn btn-warning', 'name' => 'wflow', 'value' => 'submit', 'data' => [
                'confirm' => 'Andakah anda pasti untuk hantar tuntutan ini?'
            ],
]) ?>
    </div>
<?php } ?>	
	

<?php ActiveForm::end(); ?>



<?php

$today = date('Y-d-m');

$js = <<<'EOD'


jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
	$( ".krajee-datepicker" ).each(function() {
	   $(this).removeData().kvDatepicker('destroy');
		$(this).kvDatepicker(eval($(this).attr('data-krajee-kvdatepicker')));
  }); 
	
	load_calculation();
	recalculate();
	
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e, item) {
calc_total();

	
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

load_calculation();

$('.calc-all').each(function(){
	var el = $(this);
	calc_element(el);
});

function recalculate(){
	var kira = $('.calc-all').length;
	for(i=0;i<kira;i++){
		//alert(i);
		var el = $('#claimitem-'+ i +'-hour_start');
		calc_element(el);
	}
}


function load_calculation(){
	$('.calc-amount').change(function(){	
	var el = $(this);
	calc_element(el);
	
	});	
}

function calc_element(el){
	var rate = parseFloat($('#fasi-rate').val());
	var arr_this = el.attr('id').split('-');
	var item_index = arr_this[1];
	var start = parseInt($('#claimitem-' + item_index + '-hour_start').val());
	var end = parseInt($('#claimitem-' + item_index + '-hour_end').val());
	var total = end - start;
	if(total > 0){
		str_hours = '<span class="sub-total-hour">' + total + '</span> x ' + 'RM' + rate;
		rsl = total * rate;
		str_total = 'RM<span class="sub-total-item">' + rsl + '<span>';
	}else{
		str_hours = '';
		str_total = '';
	}
	el.parents().eq(2).children('td.calc-detail').html(str_hours);
	el.parents().eq(2).children('td.calc-sub-total').html(str_total);
	calc_total();
}

function calc_total(){
	var rate = parseFloat($('#fasi-rate').val());
	var sub = 0 ;
	var hour = 0;
	$('.sub-total-item').each(function(){
		sub += parseFloat($(this).text());
	});
	$('.sub-total-hour').each(function(){
		hour += parseFloat($(this).text());
	});
	$('#claim-total').text('RM' + sub);
	$('#claim-total-hour').text(hour + ' x ' + 'RM' + rate);
	$('#total-this').text(hour);
	var max_month = parseFloat($('#max_month').text());
	var max_sem = parseFloat($('#max_sem').text());
	var claimed_sem = parseFloat($('#claimed_sem').text());
	if(hour > max_month){
		$('#warning-month').show();
	}else{
		$('#warning-month').hide();
	}
	var total_sem = hour + claimed_sem;
	if(total_sem > max_sem){
		$('#warning-semester').show();
	}else{
		$('#warning-semester').hide();
	}
	
}

EOD;

JuiAsset::register($this);
$this->registerJs($js);



?>
