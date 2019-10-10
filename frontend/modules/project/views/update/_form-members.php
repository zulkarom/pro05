<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;

//echo "[{$indexPosition}][]id";
//print_r($modelMembers[0]);
//die();
?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-members',
    'widgetItem' => '.member-item',
    'limit' => 50,
    'min' => 1,
    'insertButton' => '.add-member-' . $indexPosition,
    'deleteButton' => '.remove-member',
    'model' => $modelsMember[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'student_id'
    ],
]); ?>
<table class="table table-bordered">
    <tbody class="container-members">
    <?php foreach ($modelsMember as $indexMember => $modelMember): ?>
		<tr class="member-item">
			<td class="vcenter">
			<?php
                    // necessary for update action.
                    if (! $modelMember->isNewRecord) {
                        echo Html::activeHiddenInput($modelMember, "[{$indexPosition}][{$indexMember}]id");
                    }
                ?>
                <?= $form->field($modelMember, "[{$indexPosition}][{$indexMember}]student_id")->dropDownList($model->studentInvolved(), ['prompt' => 'Please Select' ])->label(false) ?>
            </td>
            <td class="text-center vcenter" style="width: 50px;">
                <button type="button" style="font-size:15px" class="remove-member btn btn-default btn-sm"><span class="icon icon-remove"></span></button>
            </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
	
	<tfoot>
            <tr>
                <td colspan="2">
                <button style="font-size:15px" type="button" class="add-member-<?=$indexPosition?> btn btn-default btn-sm"><span class="icon icon-plus"></span> Tambah Pelajar</button>
                
                </td>
             
            </tr>
        </tfoot>
</table>
<?php DynamicFormWidget::end(); ?>

