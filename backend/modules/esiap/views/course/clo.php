<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Course Learning Outcome';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'CLO';
?>

<?=$this->render('_header',[
'course' => $model->course
])?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
	
<div class="box">
<div class="box-header"></div>
<div class="box-body">	
    
    <p><strong>At the end of this course, student should be able to:</strong></p>
	<i><span style="color:red">* Do not include numbering and Taxonomy / PLO mapping in CLO text</span></i><br />

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
					<b><i><?=$clo->clo_text. ' ' . $clo->taxoPloBracket?></i></b>
                </td>
				
				<td class="vcenter">
                    <?= $form->field($clo, "[{$clo->id}]clo_text_bi")->textarea(['rows' => '3'])->label(false) ?>
					<b><i><?=$clo->clo_text_bi. ' ' . $clo->taxoPloBracket?></i></b>
                </td>
                

                <td class="text-center vcenter">
				
				<?= Html::a('<span class="fa fa-remove"></span>', ['course-clo-delete', 'version' => $model->id, 'clo' => $clo->id], [
            'class' => 'remove-clo btn btn-default btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this CLO? All setting related to this CLO also will be deleted.',
                'method' => 'post',
            ],
        ]) ?>

				
				
                   
                
				
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
				
				<br /> <i>* To add or remove clo, please save first if you have made any change.</i>
                
                </td>
    
            </tr>
        </tfoot>
        
    </table>
    
    
<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>


</div>
</div>

<div class="form-group">
<?php 
$check = $model->pgrs_clo == 2 ? 'checked' : '';
?>
<label><input type="checkbox" id="complete" name="complete" value="1" <?=$check?> /> Mark as complete
</label>
</div>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE COURSE LEARNING OUTCOME', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


