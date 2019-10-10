<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
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


<?=$this->render('_menu', ['token' => $model->pro_token, 'page' => 'student'])?>


<div class="person-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

     <?=$form->field($model, 'updated_at')->hiddenInput(['value' => 1])->label(false)?>


    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.position-item',
        'limit' => 50,
        'min' => 1,
        'insertButton' => '.add-position',
        'deleteButton' => '.remove-position',
        'model' => $modelsPosition[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'position',
        ],
    ]); ?>
   <div > 
   
   
   <table class="table">
   <thead>
   <tr>
   <th width="40%">Jawatankuasa</th>
   <th>Pelajar</th>
   </tr>
   </thead>

        <tbody class="container-items">
        <?php foreach ($modelsPosition as $indexPosition => $modelPosition): ?>
            <tr class="position-item">
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $modelPosition->isNewRecord) {
                            echo Html::activeHiddenInput($modelPosition, "[{$indexPosition}]id");
                        }
                    ?>
					

<?=$form->field($modelPosition, "[{$indexPosition}]position")->label(false);
					?>
<button style="font-size:15px" type="button" class="remove-position btn btn-default btn-sm"><span class="icon icon-remove"></span> Buang Jawatankuasa</button>
					
		
					 
					
					
                </td>
				
				<td>
				
				<?php 					
					echo  $this->render('_form-members', [
                        'form' => $form,
                        'indexPosition' => $indexPosition,
                        'modelsMember' => $modelsMember[$indexPosition],
						'model' => $model
						
                    ])?>
				
				
				</td>
      
    
            </tr>
         <?php endforeach; ?>
        </tbody>
	<tfoot>
            <tr>
                <td colspan="2">
                <button style="font-size:15px" type="button" class="add-position btn btn-default btn-sm"><span class="icon icon-plus"></span> Tambah Jawatankuasa</button>
                
                </td>
             
            </tr>
        </tfoot>
    </table></div>
    <?php DynamicFormWidget::end(); ?>
    
    <div class="form-group">
        <?= Html::submitButton('SIMPAN', ['class' => 'btn btn-primary', 'style' => 'font-size:19px']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>




</div>

</section>




