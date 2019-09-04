<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Component;
use backend\models\Course;
use backend\models\Semester;
use backend\models\Campus;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;

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
	
	<div class="col-md-4"><?= $form->field($model, 'fasi_type_id')->radioList(array(1 =>'Fasilitator',2=>'Pembantu Fasilitator')); ?></div>
	
	
	
</div>


<div class="row">
<div class="col-md-4"><?= $form->field($model, 'campus_id')->dropDownList(
		ArrayHelper::map(Campus::find()->all(),'id', 'campus_name'), ['prompt' => 'Select Campus' ]
	) ?></div>
<div class="col-md-4"><div class="form-group">
<label>Status Permohonan</label>
<div><?=$model->getWfLabel()?></div>
<div></div>
</div></div>
</div>







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
                <br />
				<i>* dibenarkan maksimum dua pilihan kursus sahaja</i>
				<br />
				<i>* hanya satu kursus sahaja akan diluluskan</i>
                </td>
         
            </tr>
        </tfoot>
        
    </table>
    
    
    
    <?php DynamicFormWidget::end(); ?>
    

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



	
  

</div></div>
</div>


    <div class="form-group">
	
	<?= Html::submitButton('Simpan Sebagai Deraf', ['class' => 'btn btn-default', 'name' => 'progress', 'value' => 'draft']) ?>
	 
        <?= Html::submitButton('Hantar', ['class' => 'btn btn-primary', 'name' => 'progress', 'value' => 'submit', 'data' => [
                'confirm' => 'Adakah anda pasti untuk menghantar permohonan ini?'
            ],
]) ?>
    </div>
	
 <?php ActiveForm::end(); ?>

</div>
