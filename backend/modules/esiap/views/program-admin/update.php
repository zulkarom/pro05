<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\modules\esiap\models\ProgramCategory;
use backend\modules\esiap\models\StudyMode;
use backend\modules\esiap\models\ProgramLevel;
use backend\models\Department;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\modules\staff\models\Staff;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Program */

$this->title = 'Update Program';
$this->params['breadcrumbs'][] = ['label' => 'Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="program-update">

  <?php $form = ActiveForm::begin(); ?>
<div class="row">
<div class="col-md-6">
<div class="box box-primary">
<div class="box-header"></div>
<div class="box-body"><div class="program-form">

  

    <?= $form->field($model, 'pro_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pro_name_bi')->textInput(['maxlength' => true]) ?>
	
	<div class="row">
<div class="col-md-6"> <?= $form->field($model, 'pro_name_short')->textInput(['maxlength' => true]) ?></div>

<div class="col-md-6"> 


<?= $form->field($model, 'pro_level')->dropDownList(
        ArrayHelper::map(ProgramLevel::find()->all(),'id', 'level_name'), ['prompt' => 'Please Select' ]
    ) ?>


</div>

<div class="col-md-6">
<?= $form->field($model, 'status')->dropDownList( [1 => 'YES' , 0 => 'NO'] ) ?>

</div>

</div>

   <div class="row">
<div class="col-md-6">

<?= $form->field($model, 'department_id')->dropDownList(
        ArrayHelper::map(Department::find()->all(),'id', 'dep_name'), ['prompt' => 'Please Select' ]
    ) ?>




</div>

<div class="col-md-6"><?= $form->field($model, 'pro_cat')->dropDownList(
        ArrayHelper::map(ProgramCategory::find()->all(),'id', 'cat_name'), ['prompt' => 'Please Select' ]
    ) ?>
</div>

</div>
	
    <div class="row">
<div class="col-md-6"> <?= $form->field($model, 'grad_credit')->textInput() ?></div>

<div class="col-md-6">



<?= $form->field($model, 'study_mode')->dropDownList(
        ArrayHelper::map(StudyMode::find()->all(),'id', 'mode_name'), ['prompt' => 'Please Select' ]
    ) ?>

</div>

</div>


   

</div>


   

 

</div></div>


<div class="box box-warning">
<div class="box-header">
<h3 class="box-title">Staff Access for View</h3>
</div>
<div class="box-body">

<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items-access',
        'widgetItem' => '.access-item',
        'limit' => 20,
        'min' => 1,
        'insertButton' => '.add-access',
        'deleteButton' => '.remove-access',
        'model' => $accesses[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',
            'staff_id',
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">

        <tbody class="container-items-access">
        <?php foreach ($accesses as $i => $access): ?>
            <tr class="access-item">
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $access->isNewRecord) {
                            echo Html::activeHiddenInput($access, "[{$i}]id");
                        }
                    ?>
                    <?= $form->field($access, "[{$i}]staff_id")->dropDownList(ArrayHelper::map(Staff::activeStaff(), 'id', 'user.fullname'), ['prompt' => 'Select'])->label(false) ?>
                </td>

                <td class="text-center vcenter" style="width: 40px;">
                    <button type="button" class="remove-access btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td>
                <button type="button" class="add-access btn btn-default btn-sm"><span class="fa fa-plus"></span> New Staff Access</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>


</div>
</div>



</div>

<div class="col-md-6">
<div class="box box-warning">
<div class="box-header">
<h3 class="box-title">Course Version</h3>
</div>
<div class="box-body">

<div class="table-responsive">
  <table class="table table-striped table-hover">
  <thead>
  <tr>
  <th colspan="2">Published Version</th>
  </tr>
  </thead>
    <tbody>
      <tr>
        <td>Version Name</td>
        <td><?php 
		if($model->publishedVersion){
			echo $model->publishedVersion->version_name;
		}else{
			echo 'None';
		}
		?>
		
		</td>
      </tr>
	  
	  <tr>
        <td>Preparation</td>
        <td><?php 
		if($model->publishedVersion){
			if($model->publishedVersion->preparedBy){
				echo $model->publishedVersion->preparedBy->fullname . ' ('.$model->publishedVersion->prepareDate.')';
			}
			
		}else{
			echo 'None';
		}
		?>
		
		</td>
      </tr>
	 
	  
	  <tr>
        <td>Verification</td>
        <td><?php 
		if($model->publishedVersion){
			if($model->publishedVersion->verifiedBy){
				echo $model->publishedVersion->verifiedBy->fullname . ' ('.$model->publishedVersion->verifiedDate.')';
			}
			
		}else{
			echo 'None';
		}
		?>
		
		</td>
      </tr>
	  
	  <tr>
        <td>Approval</td>
        <td><?php 
		if($model->publishedVersion){
			if($model->publishedVersion->senate_approve_show){
				$senate = $model->publishedVersion->senateDate;
			}else{
				$senate = '-';
			}
			echo 'Faculty: '.$model->publishedVersion->facultyDate.'<br />
			Senate: ' . $senate;
			
		}else{
			echo 'None';
		}
		?>
		
		</td>
      </tr>


    </tbody>
  </table>
</div>

<div class="table-responsive">
  <table class="table table-striped table-hover">
  <thead>
  <tr>
  <th colspan="2">Under Development Version (UDV)</th>
  </tr>
  </thead>
    <tbody>
      <tr>
        <td>Version Name</td>
        <td><?php 
		if($model->developmentVersion){
			echo $model->developmentVersion->version_name;
		}else{
			echo 'None';
		}
		?>
		
		</td>
      </tr>
	  <tr>
        <td>Status</td>
        <td>
		<?php 
		if($model->developmentVersion){
			echo $model->developmentVersion->labelStatus;
		}else{
			echo 'None';
		}
		?>
		
		</td>
      </tr>
	  <tr>
        <td>Action</td>
        <td><?php 
		if($model->developmentVersion){
			echo Html::a('<span class="glyphicon glyphicon-pencil"></span> Update Version', ['/esiap/program-admin/program-version-update', 'id' => $model->developmentVersion->id], [
					'class' => 'btn btn-warning btn-sm',
					
				]);
		}else{
			echo 'None';
		}
		
		
		
		?></td>
      </tr>
     <tr>
        <td><a class="btn btn-default btn-sm" href="<?=Url::to(['/esiap/program-admin/program-version', 'program' => $model->id])?>"><span class='glyphicon glyphicon-cog'></span> Manage Version</a></td>
        <td></td>
      </tr>
    </tbody>
  </table>
</div>

</div>
</div>


<div class="box box-danger">
<div class="box-header">
<h3 class="box-title">Staff in Charge for Development</h3>
</div>
<div class="box-body">

<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>

<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.pic-item',
        'limit' => 20,
        'min' => 1,
        'insertButton' => '.add-pic',
        'deleteButton' => '.remove-pic',
        'model' => $pics[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',
            'staff_id',
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">

        <tbody class="container-items">
        <?php foreach ($pics as $i => $pic): ?>
            <tr class="pic-item">
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $pic->isNewRecord) {
                            echo Html::activeHiddenInput($pic, "[{$i}]id");
                        }
                    ?>
                    <?= $form->field($pic, "[{$i}]staff_id")->dropDownList(ArrayHelper::map(Staff::activeStaff(), 'id', 'user.fullname'), ['prompt' => 'Select'])->label(false) ?>
                </td>

                <td class="text-center vcenter" style="width: 40px;">
                    <button type="button" class="remove-pic btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td>
                <button type="button" class="add-pic btn btn-default btn-sm"><span class="fa fa-plus"></span> New Staff in Charge</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>


</div>
</div>



</div>

</div>

 <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"> </i> SAVE PROGRAM', ['class' => 'btn btn-primary']) ?>
    </div>


   <?php ActiveForm::end(); ?>

</div>
