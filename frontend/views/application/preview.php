<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Component;
use backend\models\Course;
use backend\models\Semester;
use backend\models\Campus;

/* @var $this yii\web\View */
/* @var $model common\models\Application */

$this->title = 'PERMOHONAN FASILITATOR';
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="application-update">

 <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="application-form">



	
	<div class="row">

<div class="col-md-4">

	<div class="form-group">
<label>Semester</label>
<div><?=$model->semester->niceFormat()?></div>
<div></div>
</div>
	
	</div>
	
	<div class="col-md-4">
	<label><?=$model->getAttributeLabel('fasi_type_id')?></label>
	<div><?php
	
	$type = array(1 =>'Fasilitator',2=>'Pembantu Fasilitator');
	
	echo $type[$model->fasi_type_id]; 
	
	?></div></div>
	
	
	
</div>


<div class="row">
<div class="col-md-4">
<label><?=$model->getAttributeLabel('campus.campus_name')?></label>
	<div><?php

	echo $model->campus->campus_name; 
	
	?></div>
</div>
<div class="col-md-4"><div class="form-group">
<label>Status Permohonan</label>
<div><?=$model->getWfLabel()?></div>
<div></div>
</div></div>
</div>


    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
				<th>Komponen</th>
                <th>Kursus</th>

            </tr>
        </thead>
        <tbody class="container-items">
        <?php $i = 1;
		foreach ($courses as $indexCourse => $course): ?>
            <tr class="course-item">
                <td><?=$i?>
                    </td>
            
                <td class="vcenter">

					
					<?=$course->course->component->name?>
                    
                </td>
				
				<td>
				<?=$course->course->course_name ?>
				</td>

            </tr>
         <?php $i++; endforeach; ?>
        </tbody>
        
        
    </table>
    
 
  

</div></div>
</div>


    <div class="form-group">
	
	<?=$form->field($model, 'submit_at')->hiddenInput(['value' => time()])->label(false)?>

	 <?= Html::a('Kembali', ['application/update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('Sah & Hantar', ['class' => 'btn btn-primary', 'name' => 'progress', 'value' => 'submit']) ?>
    </div>
	
 <?php ActiveForm::end(); ?>

</div>
