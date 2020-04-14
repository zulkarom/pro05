<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use backend\modules\esiap\models\AssessmentCat;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */


$this->title = 'Course Assessment';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Assessment';
?>

<?=$this->render('_header',[
'course' => $model->course
])?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
	
<div class="box">
<div class="box-header"></div>
<div class="box-body">	

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
               
                <th>Assessment (BM)</th>
                <th>Assessment (EN)</th>
				<th>Category</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($items as $indexItem => $item): ?>
            <tr class="row-item">
        
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $item->isNewRecord) {
                            echo Html::activeHiddenInput($item, "[{$indexItem}]id");
                        }
                    ?>
                    <?= $form->field($item, "[{$indexItem}]assess_name")->label(false) ?>
                </td>
				
				<td class="vcenter">
                    <?= $form->field($item, "[{$indexItem}]assess_name_bi")->label(false) ?>
                </td>
				
				<td class="vcenter">
                    <?= $form->field($item, "[{$indexItem}]assess_cat")->dropDownList(
        ArrayHelper::map(AssessmentCat::find()->all(),'id', 'cat_name_bi'), ['prompt' => 'Please Select' ]
    )
->label(false) ?>
                </td>
                

                <td class="text-center vcenter" style="width: 90px;">
                    <a href="<?=Url::to(['course-assessment-delete', 'version' => $model->id, 'id' => $item->id])?>" class="remove-item btn btn-default btn-sm"><span class="fa fa-remove"></span></a>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
         
                <td colspan="3">
                <a href="<?=Url::to(['course-assessment-add', 'version' => $model->id])?>" class="add-item btn btn-default btn-sm"><span class="fa fa-plus"></span> New Assessment</a>
				<br /><br /><i>* please save before add or remove assessment</i>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>
    
    
<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>






</div>
</div>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE ASSESSMENT', ['class' => 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>