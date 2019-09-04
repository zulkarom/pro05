<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use frontend\models\EducationLevel;

$this->title = "PENDIDIKAN";
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<?=$form->field($model, 'edu_updated_at')->hiddenInput(['value' => time()])->label(false)?>

<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.edu-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-edu',
        'deleteButton' => '.remove-edu',
        'model' => $education[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'institution',
			'year_grad',
			'level'
        ],
    ]); ?>
	
	
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
				<th width="5%"></th>
                <th>Institusi</th>
				<th>Nama Kelayakan<br /><span style="font-weight:none;font-size:9px"><i>e.g. Sarjana Muda Pengurusan Perniagaan</i></span></th>
				<th width="10%">Tahun Graduasi</th>
				<th width="15%">Tahap</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($education as $indexEdu => $edu): ?>
            <tr class="edu-item">
				<td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows"></i>
                    </td>
			
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $edu->isNewRecord) {
                            echo Html::activeHiddenInput($edu, "[{$indexEdu}]id");
                        }
                    ?>
                    <?= $form->field($edu, "[{$indexEdu}]institution")->label(false) ?>
                </td>
				
				<td class="vcenter">
                    <?= $form->field($edu, "[{$indexEdu}]edu_name")->label(false) ?>
                </td>
				
				<td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $edu->isNewRecord) {
                            echo Html::activeHiddenInput($edu, "[{$indexEdu}]id");
                        }
                    ?>
                    <?= $form->field($edu, "[{$indexEdu}]year_grad")->label(false) ?>
                </td>
				
				<td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $edu->isNewRecord) {
                            echo Html::activeHiddenInput($edu, "[{$indexEdu}]id");
                        }
                    ?>
                   
					
					<?= $form->field($edu, "[{$indexEdu}]level")->dropDownList(
        ArrayHelper::map(EducationLevel::find()->all(),'level', 'edu_name'), ['prompt' => 'Please Select' ]
    )->label(false)?>

                </td>

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-edu btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
		
		<tfoot>
            <tr>
			<td></td>
                <td colspan="3">
				<button type="button" class="add-edu btn btn-default btn-sm"><span class="fa fa-plus"></span> Tambah Pendidikan</button>
				
				</td>
                <td>
				
				
				</td>
            </tr>
        </tfoot>
		
    </table>
	
	<div class="form-group">
<label>Status</label> <?=$model->listStatus('edu_updated_at', 'fasiEdus');?>
<div></div>
</div>
	
	
	
    <?php DynamicFormWidget::end(); ?>
	
	<div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Simpan Pendidikan', ['class' => 'btn btn-primary']) ?>
    </div>


	<?php ActiveForm::end(); ?></div>
</div>
	
<?php 
/* $script = <<< JS

	
jQuery(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
});

jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    console.log("afterInsert");
});

jQuery(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    console.log("Deleted item!");
});

jQuery(".dynamicform_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});
	



JS;
$this->registerJs($script); */

?>



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