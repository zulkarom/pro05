<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
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


<h4>hari</h4>
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
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
                <th>HARI</th>
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
					<?=$form->field($expense, 'exp_name');
					?>
                
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
                <button type="button" class="add-expense btn btn-default btn-sm"><span class="icon icon-plus"></span> Tambah Hari</button>
                
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




