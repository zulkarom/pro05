<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use backend\modules\esiap\models\AssessmentCat;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */


$this->title = 'Course Assessment';
$this->params['breadcrumbs'][] = ['label' => 'Preview', 'url' => ['course/view-course', 'course' => $model->course->id, 'version' => $model->id]];
$this->params['breadcrumbs'][] = 'Assessment';
?>

<?=$this->render('_header',[
'course' => $model->course,
    'version' => $model
])?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
	
<div class="box">
<div class="box-header"></div>
<div class="box-body">	

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
               
                <th>Assessment Name (BM)</th>
                <th>Assessment Name (EN)</th>
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
        ArrayHelper::map(AssessmentCat::find()->where(['showing' => 1])->all(),'id', 'cat_name_bi'), ['prompt' => 'Please Select' ]
    )
->label(false) ?>
                </td>
                

                <td class="text-center vcenter" style="width: 90px;">
				
				<?= Html::a('<span class="fa fa-remove"></span>', ['course-assessment-delete', 'version' => $model->id, 'id' => $item->id], [
            'class' => 'remove-item btn btn-default btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this Assessment? All setting related to this Assessment also will be deleted.',
                'method' => 'post',
            ],
        ]) ?>
				
                   
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
         
                <td colspan="3">
                <a href="<?=Url::to(['course-assessment-add', 'version' => $model->id])?>" class="add-item btn btn-default btn-sm"><span class="fa fa-plus"></span> New Assessment</a>
				<br /><br /><i>* To add or remove assessment, please save first if you have made any change.</i>
                
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
<?php 
$check = $model->pgrs_assess == 2 ? 'checked' : ''; ?>
<label>
<input type="checkbox" id="complete" name="complete" value="1" <?=$check?> /> Mark as complete
</label></div>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE ASSESSMENT', ['class' => 'btn btn-primary']) ?>
    </div>


    <?php ActiveForm::end(); ?>