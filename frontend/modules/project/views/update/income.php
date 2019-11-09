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
     
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
                <th>PENDAPATAN</th>
                <th width="25%">KUANTITI</th>
				<th width="25%">JUMLAH (RM)</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($resources as $i => $resource): 
		$core = false;
		$style = '';
		$class = 'resource-item';
		if($resource->rs_core == 1){
				$core = true;
				$style = 'style="vertical-align:middle"';
				$class = 'resource-item';
			}
		?>
            <tr class="resource-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        
                    </td>
                <td class="vcenter" <?=$style?>>
				
                    <?php
                        // necessary for upresource action.
                        if (! $resource->isNewRecord) {
                            echo Html::activeHiddenInput($resource, "[{$i}]id");
                        }
						if($core){
							echo '<div style="display:none">' . $form->field($resource, "[{$i}]rs_name")->label(false) . '</div>';
							echo '<span>&nbsp;' . $resource->rs_name . '</span>' ;
						}else{
							echo $form->field($resource, "[{$i}]rs_name")->label(false);
						}
                    ?>
                    
                </td>
				
				<td class="vcenter">
                    <?= $form->field($resource, "[{$i}]rs_quantity")->label(false) ?>
                </td>
                
                <td class="vcenter">
					<?= $form->field($resource, "[{$i}]rs_amount")->label(false) ?>


                </td>

                <td class="text-center vcenter" style="width: 90px; verti">
				<?php 
				if(!$core){
					echo '<button type="button" class="remove-resource btn btn-default btn-sm"><span class="icon icon-remove"></span></button>';
				}else{
					echo '<button type="button" style="display:none" class="remove-resource btn btn-default btn-sm"><span class="icon icon-remove"></span></button>';
				}
				
				?>
                   
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

$this->registerJs('

$(".dynamicform_wrapper").on("afterInsert", function (e, item) {
  var input = item.getElementsByTagName("td")[1].children[0];
  var str_id = input.getAttribute("id");
  var arr_id = str_id.split("-");
  var id = arr_id[1];
  var td = $("#resource-" + id + "-id").parent()
  td.find("div").show();
  td.find("span").hide();
  td.parent().find("td button").show();

});


');

?>

