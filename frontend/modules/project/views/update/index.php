<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;


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

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

        <?= $form->field($model, 'pro_name')->textarea(['rows' =>2]) ?>
		


        <?= $form->field($model, 'location') ?>
		
		
		
        <div class="row">
<div class="col-md-6"><?= $form->field($model, 'purpose')->textarea(['rows' =>10]) ?></div>

<div class="col-md-6"> <?= $form->field($model, 'background')->textarea(['rows' =>10]) ?>
</div>

</div>

<div class="row">
<div class="col-md-10">


<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.objective-item',
        'limit' => 20,
        'min' => 1,
        'insertButton' => '.add-objective',
        'deleteButton' => '.remove-objective',
        'model' => $objectives[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',

        ],
    ]); ?>

    <label>Objektif Kertas Kerja</label>
    <div class="table-responsive"><table class="table">
        <tbody class="container-items">
        <?php foreach ($objectives as $i => $objective): ?>
            <tr class="objective-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;width: 10px;">
                        <i class="icon icon-arrows-alt"></i>
                    </td>
            
                <td class="vcenter">
                    <?php
                        // necessary for upobjective action.
                        if (! $objective->isNewRecord) {
                            echo Html::activeHiddenInput($objective, "[{$i}]id");
                        }
                    ?>
                    <?= $form->field($objective, "[{$i}]obj_text")->textarea(['rows' => 2])->label(false) ?>
                </td>
				

                <td class="text-center vcenter" style="width: 10px;">
                    <button type="button" class="remove-objective btn btn-default btn-sm"><span class="icon icon-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
            <td></td>
                <td colspan="1">
                <button type="button" class="add-objective btn btn-default btn-sm"><span class="icon icon-plus"></span> Tambah Objective</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table></div>
    <?php DynamicFormWidget::end(); ?>

</div>


</div>
		
        
		
        
        
       
        <?= $form->field($model, 'pro_target') ?>
		
		<?= $form->field($model, 'collaboration') ?>
        <?= $form->field($model, 'agency_involved') ?>
        
    <br />
        <div class="form-group">
            <?= Html::submitButton('SIMPAN', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- site-index -->




</div>

</section>





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


