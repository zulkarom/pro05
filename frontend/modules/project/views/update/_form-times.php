<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\time\TimePicker;


?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-times',
    'widgetItem' => '.time-item',
    'limit' => 100,
    'min' => 1,
    'insertButton' => '.add-time',
    'deleteButton' => '.remove-time',
    'model' => $times[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'description'
    ],
]); ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="20%">Masa</th>
			<th width="50%">Atucara</th>
			<th>Lokasi</th>
            <th class="text-center">

            </th>
        </tr>
    </thead>
    <tbody class="container-times">
    <?php foreach ($times as $indexTime => $time): ?>
        <tr class="time-item">
            <td class="vcenter">
                <?php
                    // necessary for update action.
                    if (! $time->isNewRecord) {
                        echo Html::activeHiddenInput($time, "[{$indexDay}][{$indexTime}]id");
                    }
                ?>
				
				<?=$form->field($time, "[{$indexDay}][{$indexTime}]ttf_time")->widget(TimePicker::classname(), [
				'pluginOptions' => [
        'showSeconds' => false,
		'minuteStep' => 5
    ]
				
				]);?>
				
            </td>
			<td class="vcenter">
                <?= $form->field($time, "[{$indexDay}][{$indexTime}]ttf_item")->label(false)->textarea(['rows' => 3]) ?>
            </td>
			<td class="vcenter">
                <?= $form->field($time, "[{$indexDay}][{$indexTime}]ttf_location")->label(false)->textInput(['maxlength' => true]) ?>
            </td>
            <td class="text-center vcenter" style="width: 50px;">
                <button type="button" style="font-size:15px" class="remove-time btn btn-default btn-sm"><span class="icon icon-remove"></span></button>
            </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
	
	<tfoot>
            <tr>
                <td colspan="4">
                <button style="font-size:15px" type="button" class="add-time btn btn-default btn-sm"><span class="icon icon-plus"></span> Tambah Atucara</button>
                
                </td>
             
            </tr>
        </tfoot>
</table>
<?php DynamicFormWidget::end(); ?>

