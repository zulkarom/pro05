<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Reference';
$this->params['breadcrumbs'][] = ['label' => 'Preview', 'url' => ['course/view-course', 'course' => $model->course_id, 'version' => $model->id]];
$this->params['breadcrumbs'][] = 'Reference';
?>

 <?php $form = ActiveForm::begin(); ?>

<?=$this->render('_header',[
'course' => $model->course, 
    'version' => $model
])?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">	

<div class="row">
<div class="col-md-3"># Use APA Style for References<br />
# Put * to make it italic e.g. *italic*<br />
# References should be 5 years latest edition. In certain cases, classic works can be used <br />
<span style="color:red"># Do not include numbering in references</span>
</div>

<div class="col-md-9"><i>Example:</i><br/>
<table align="left" border="0" cellpadding="3" class="table">
	<tr align="left" valign="top">
		<td><b>BOOK:</b> </td>
		<td>Rowling, J.K. (2001). *Harry Potter and the socerer's stone.* London: Bloomsburg Children's.</td>
	</tr>
	<tr align="left" valign="top">
		<td><b>JOURNAL:</b> </td>
		<td>Jacoby, W. G. (1994). Public attitudes toward government spending. *American Journal of Political Science, 38(2)*, 336-361.</td>
	</tr>
	<tr align="left" valign="top">
		<td><b>WEBSITE:</b> </td>
		<td>Satalkar, B. (2010, July 15). *Water aerobics.* Retrieved from http://www.buzzle.com</td>
	</tr>
</table>

<br />
 
</div>

</div>



<table class="table table-striped table-hover">
<thead>
	<tr>
		<th width="2%">No.</th>
		<th>Full Reference</th>
		<th width="10%">Year</th>
		
		<th width="5%">Main</th>
		<th style="text-align:center" width="5%">Classic<br />Work</th>
		<th width="2%"></th>
	</tr>
</thead>
<?php 
$curr = date('Y');
$min = $curr - 4;
$script="[";
if($ref){
	$i = 1;
	
	foreach($ref as $indexItem => $item){
		if($i==1){$comm="";}else{$comm=", ";}
		
		
		echo '<tr>
	<td>'.$i.'. </td>
		<td>';
		
		echo Html::activeHiddenInput($item, "[{$indexItem}]id");
		
		echo $form->field($item, "[{$indexItem}]ref_full")->textarea(['rows' => '1'])->label(false);
		
		echo '</td>
		<td>';
		
		
		
		//echo '<input type="text" name="ref['.$row->id .'][year]" id="ref-year-'.$row->id .'" class="form-control" value="'.$yr .'" />';
		$item->ref_year = $item->ref_year == '0000' ?  '' : $item->ref_year;
		echo $form->field($item, "[{$indexItem}]ref_year")->label(false);
		
		echo '</td><td>';
		

		echo $form->field($item, "[{$indexItem}]is_main")->checkbox(['value' => '1', 'label'=> '']); 
		
		echo '</td>
		<td>
		';
	
		
		echo $form->field($item, "[{$indexItem}]is_classic")->checkbox(['value' => '1', 'label'=> '']); 

		echo '</td>
		<td>';
		
		echo Html::a('<span class="fa fa-remove"></span>', ['course/course-reference-delete', 'course' => $model->course->id, 'version' => $model->id, 'id' => $item->id], [
            'class' => 'rmv-ref',
			'id' => 'remove-'.$item->id,
            'data' => [
                'confirm' => 'Are you sure you want to delete this Reference?',
                'method' => 'post',
            ],
        ]);
		
		
		
		echo '</td>
		
	</tr>
	
	<tr><td></td><td colspan="5">
	</td></tr>
	
	';

	$i++;
	}
	
}
$script .="]";

//<b style="font-size:12px"><span class="glyphicon glyphicon-book"></span> </b>'.$row->formatedReference .'
?>
	
</table>
<i>* To add or remove a reference, please save first if you have made any change.</i><br />
<a href="<?=Url::to(['course/course-reference-add', 'course' => $model->course->id, 'version' => $model->id])?>" id="btn-add" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> Add Reference</a>


    
</div>
</div>

<div class="form-group">
<?php 
$check = $model->pgrs_ref == 2 ? 'checked' : ''; ?>
<label>
<input type="checkbox" id="complete" name="complete" value="1" <?=$check?> /> Mark as complete
</label></div>


    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE REFERENCE', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

