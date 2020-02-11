<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Course Learning Outcome: ' . $model->course->course_name . ' '. $model->course->course_code;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'CLO';
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
	
<div class="box">
<div class="box-header"></div>
<div class="box-body">	
    
    <p><strong>At the end of this course, student should be able to:</strong></p>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
               <th width="5%">CLO</th>
                <th>CLO Text (BM)</th>
                <th>CLO Text (EN)</th>
                <th class="text-center" style="width: 4%;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php 
		$i = 1;
		foreach ($clos as $indexClo => $clo){ ?>
            <tr class="clo-item">
           
            <td>CLO<?= $i?></td>
                <td class="vcenter">
                    <?= $form->field($clo, "[{$clo->id}]clo_text")->textarea(['rows' => '3'])->label(false) ?>
                </td>
				
				<td class="vcenter">
                    <?= $form->field($clo, "[{$clo->id}]clo_text_bi")->textarea(['rows' => '3'])->label(false) ?>
                </td>
                

                <td class="text-center vcenter">
                    <a href="<?=Url::to(['course-clo-delete', 'version' => $model->id, 'clo' => $clo->id])?>" class="remove-clo btn btn-default btn-sm"><span class="fa fa-remove"></span></a>
                </td>
            </tr>
         <?php 
		 $i++;
		 }
		 
		 ?>
        </tbody>
        
        <tfoot>
            <tr>
				<td></td>
                <td colspan="3">
                <a href="<?=Url::to(['course-clo-add', 'version' => $model->id])?>" class="add-clo btn btn-default btn-sm"><span class="fa fa-plus"></span> ADD CLO</a>
				
				<br /> <i>* please save first before add new</i>
                
                </td>
    
            </tr>
        </tfoot>
        
    </table>
    
    
<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>


    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE COURSE LEARNING OUTCOME', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


