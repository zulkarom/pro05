<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use backend\models\Campus;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\models\Component;
use yii\jui\JuiAsset;
use yii\helpers\Url;
use backend\models\Rate;


/* @var $this yii\web\View */
/* @var $model common\models\Application */
/* @var $form yii\widgets\ActiveForm */
?>



<div class="application-form">

 <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<?= $form->field($model, 'fasi_type_id')->radioList(array(1 =>'Fasilitator',2=>'Pembantu Fasilitator')); ?>

    <?= $form->field($model, 'campus_id')->dropDownList(
		ArrayHelper::map(Campus::find()->all(),'id', 'campus_name')
	) ?>
	
	
	<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.course-item',
        'limit' => 2,
        'min' => 1,
        'insertButton' => '.add-course',
        'deleteButton' => '.remove-course',
        'model' => $courses[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'course_id'
        ],
    ]); ?>
    
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%"></th>
				<th>Komponen</th>
                <th>Kursus</th>
				<th>Lulus</th>
  
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($courses as $indexCourse => $course): ?>
            <tr class="course-item">
                <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows"></i>
                    </td>
            
                <td class="vcenter">
                    <?php

                        // necessary for update action.
                        if (! $course->isNewRecord) {
                            echo Html::activeHiddenInput($course, "[{$indexCourse}]id");
							$course->component_id = $course->course->component_id;
                        }
                    ?>
					
					<?= $form->field($course, "[{$indexCourse}]component_id")->dropDownList(
		ArrayHelper::map(Component::find()->all(),'id', 'name'), ['prompt' => 'Pilih Komponen', 'class' => 'form-control component-select select-choice', 'required' => true ]
	)->label(false) ;

	?>
                    
                </td>
				
				<td>
				<?= $form->field($course, "[{$indexCourse}]course_id")->dropDownList(
		$course->siblingCourses(), ['prompt' => 'Pilih Kursus',  'class' => 'form-control select-choice']
	)->label(false) ?>
				</td>
				
				<td>
				<?= $form->field($course, "[{$indexCourse}]is_accepted")->dropDownList([1=>'Yes', 0 => 'No'])->label(false) ?>
				
				</td>


                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-course btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
            <td></td>
                <td colspan="3">
				
                <button type="button" class="add-course btn btn-default btn-sm"><span class="fa fa-plus"></span> Tambah Pilihan Kursus</button>
               
                </td>
         
            </tr>
        </tfoot>
        
    </table>
    
    
    
    <?php DynamicFormWidget::end(); ?>
	
	
	<div class="row">
    <div class="col-md-3"><?= $form->field($model, 'verify_note')->textarea(['rows' => '4'])  ?>
</div>
<div class="col-md-3"><?= $form->field($model, 'rate_amount', [
    'addon' => ['prepend' => ['content'=>'RM']]
]
)->dropDownList(
        ArrayHelper::map(Rate::find()->all(),'rate_amount', 'rate_amount'), ['prompt' => 'Please Select' ]
    ) ->label('Kadar Bayaran (per jam)')
; ?>
</div>
<div class="col-md-3"><?= $form->field($model, 'group_id')->dropDownList(
        ArrayHelper::map($model->getListGroupAll(),'id', 'group_name'), ['prompt' => 'Please Select' ]
    ) 
; ?></div>

<div class="col-md-3"><?= $form->field($model, 'ambilan_id')->dropDownList(
        ArrayHelper::map($model->getListAmbilan(),'id', 'ambilan_name'), ['prompt' => 'Select if any' ]
    ) 
; ?></div>





</div>
	
	
	
	





  

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$js = "function getTargetId(element){
	var val = element.val();
	var campus = $('#application-campus_id').val();
	var curr_id = element.attr('id');
	var index_id_arr = curr_id.split('-');
	var index_id = index_id_arr[1];
	var target_id =  'applicationcourse-' + index_id + '-course_id';
	
	
	if(campus){
		$('#' + target_id).html('<option>Loading...</option>');
		
		$.ajax({url: '".Url::to(['application/list-course', 'component' => ''])."' + val + '&campus=' + campus, success: function(result){
		var str = '';
		if(result){
			var course = JSON.parse(result);
			for(i=0;i<course.length;i++){
				//console.log(course[i].course_name);
				str += '<option value=\"' + course[i].id + '\">' + course[i].course_code + ' - ' + course[i].course_name + '</option>';
			}
		}
        
		
		
		
		$('#' + target_id).html(str);
    }});
	}else{
		element.val('')
		alert('Sila pilih kampus terlebih dahulu.');
	}
	
}


";

$this->registerJs($js);


$js = <<<'EOD'



jQuery( ".component-select" ).change(function() {
	   getTargetId($(this));
});

jQuery( "#application-campus_id" ).change(function() {
	   jQuery(".select-choice").each(function(){
		   jQuery(this).val('')
	   });
})



jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
	jQuery( ".component-select" ).change(function() {
		var target_id = $(this).attr('id');
	   getTargetId($(this));
})         
});

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
