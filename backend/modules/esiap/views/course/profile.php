<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use backend\modules\staff\models\Staff;

/* @var $this yii\web\View */
/* @var $profile backend\modules\esiap\models\Course */

$this->title = 'Course Proforma';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Pro Forma';
?>

<?=$this->render('_header',[
'course' => $profile->courseVersion->course
])?>


<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
	
<div class="box">
<div class="box-header">

</div>
<div class="box-body">	



<div class="row">
<div class="col-md-6"><?= $form->field($profile, 'synopsis')->textarea(['rows' => '6']) ?></div>



<div class="col-md-6"><?= $form->field($profile, 'synopsis_bi')->textarea(['rows' => '6']) ?></div>

</div>


<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_staff',
        'widgetBody' => '.container-items-staff',
        'widgetItem' => '.staff-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-staff',
        'deleteButton' => '.remove-staff',
        'model' => $staffs[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
                <th>Name(s) of Academic Staff : </th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items-staff">
        <?php foreach ($staffs as $i => $staff): ?>
            <tr class="staff-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows-alt"></i>
                    </td>

            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $staff->isNewRecord) {
                            echo Html::activeHiddenInput($staff, "[{$i}]id");
                        }
                    ?>
                    <?= $form->field($staff, "[{$i}]staff_id")
					->dropDownList(Staff::listAcademicStaffArray(), ['prompt' => 'Please Select' ])->label(false) ?>
                </td>
                
               

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-staff btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="3">
                <button type="button" class="add-staff btn btn-default btn-sm"><span class="fa fa-plus"></span> New Academic Staff</button>
                
                </td>
     
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>

<?= $form->field($profile, 'prerequisite')->dropDownList($profile->course->allCoursesArray()) ?>
    
<div class="row">
<div class="col-md-6"><?= $form->field($profile, 'offer_sem')->dropDownList([1=>1,2=>2,3=>3], ['prompt' => 'Please Select' ]) ?></div>

<div class="col-md-6"><?= $form->field($profile, 'offer_year')->dropDownList([1=>1,2=>2,3=>3, 4=>4, 5=>5], ['prompt' => 'Please Select' ]) ?></div>
</div>

<div class="row">
<div class="col-md-6"><?= $form->field($profile, 'objective')->textarea(['rows' => '6']) ?></div>

<div class="col-md-6"><?= $form->field($profile, 'objective_bi')->textarea(['rows' => '6']) ?></div>
</div>

<div class="row">
<div class="col-md-6"><?= $form->field($profile, 'rational')->textarea(['rows' => '6']) ?></div>

<div class="col-md-6"><?= $form->field($profile, 'rational_bi')->textarea(['rows' => '6']) ?></div>


</div>

<div class="row">
<div class="col-md-6"><?= $form->field($profile, 'feedback')->textarea(['rows' => '4']) ?></div>

<div class="col-md-6"><?= $form->field($profile, 'feedback_bi')->textarea(['rows' => '4']) ?></div>
</div>



<br />


<?php 

if($profile->courseVersion->version_type_id == 1){
	?>
<div class="row">
<div class="col-md-6"><?= $form->field($profile, 'transfer_skill')->textarea(['rows' => '5']) ?></div>

<div class="col-md-6"><?= $form->field($profile, 'transfer_skill_bi')->textarea(['rows' => '5']) ?></div>


</div>


<?php	
}else if($profile->courseVersion->version_type_id == 2){
	?>


<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.transferable-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-transferable',
        'deleteButton' => '.remove-transferable',
        'model' => $transferables[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
                <th>Transferable Skills</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($transferables as $i => $transferable): ?>
            <tr class="transferable-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows-alt"></i>
                    </td>

            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $transferable->isNewRecord) {
                            echo Html::activeHiddenInput($transferable, "[{$i}]id");
                        }
                    ?>
                    <?= $form->field($transferable, "[{$i}]transferable_id")->dropDownList($profile->transferableList, ['prompt' => 'Please Select' ])->label(false) ?>
                </td>
                
               

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-transferable btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="3">
                <button type="button" class="add-transferable btn btn-default btn-sm"><span class="fa fa-plus"></span> New Transferable Skill</button>
                
                </td>
     
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>

	
<?php
}

?>

<div class="row">
<div class="col-md-6"><?= $form->field($profile, 'requirement')->textarea(['rows' => '4']) ?></div>

<div class="col-md-6"><?= $form->field($profile, 'requirement_bi')->textarea(['rows' => '4']) ?></div>
</div>

<div class="row">
<div class="col-md-6"><?= $form->field($profile, 'additional')->textarea(['rows' => '4']) ?></div>

<div class="col-md-6"><?= $form->field($profile, 'additional_bi')->textarea(['rows' => '4']) ?></div>
</div>

</div>
</div>


    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE COURSE PROFORMA', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


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

$(".container-items-staff").sortable({
    items: "tr",
    cursor: "move",
    opacity: 0.6,
    axis: "y",
    handle: ".sortable-handle",
    helper: fixHelperSortable,
    update: function(ev){
        $(".dynamicform_wrapper_staff").yiiDynamicForm("updateContainer");
    }
}).disableSelection();

EOD;

JuiAsset::register($this);
$this->registerJs($js);
?>
