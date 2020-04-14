<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Reference';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Reference';
?>

 <?php $form = ActiveForm::begin(); ?>

<?=$this->render('_header',[
'course' => $model->course
])?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">	

<div class="row">
<div class="col-md-3"># Use APA Style for References<br />
# Put * to make it italic e.g. *italic*<br />
# References should be 5 years latest edition. In certain cases, classic works can be used</div>

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
	
	foreach($ref as $row){
		if($i==1){$comm="";}else{$comm=", ";}
		$script .= $comm.$row->id;
		$yr = $row->ref_year;
		echo '<tr>
	<td>'.$i.'. <input type="hidden" value="'. $yr .'" id="curryear-'.$row->id.'" /></td>
		<td><textarea class="form-control" name="ref['.$row->id .'][full]" id="ref-full-'.$row->id .'">'.$row->ref_full .'</textarea></td>
		<td id="con-'.$row->id .'">';
		
		echo '<input type="text" name="ref['.$row->id .'][year]" id="ref-year-'.$row->id .'" class="form-control" value="'.$row->ref_year .'" />';
		
		echo '</td>
		';
		$main = $row->is_main;
		$check = $main == 1 ? "checked" : "" ;
		echo '<td><input type="hidden" name="ref['.$row->id .'][main]" value="0" /><input type="checkbox" name="ref['.$row->id .'][main]" value="1" '.$check.' /></td>
		<td>
		';
		$clas = $row->is_classic;
		if($clas == 1){
			$chk = "checked";
		}else{
			$chk = "";
		}
		echo '<input type="hidden" value="0" name="ref['.$row->id .'][isclassic]" id="chk-'.$row->id .'" class="chk-classic" /><input type="checkbox" value="1" name="ref['.$row->id .'][isclassic]" id="chk-'.$row->id .'" '.$chk.' class="chk-classic" />';

		echo '</td>
		<td><a href="'. Url::to(['course/course-reference-delete', 'course' => $model->course->id, 'version' => $model->id, 'id'=> $row->id]).'" class="rmv-ref" id="remove-'.$row->id .'"><span class="glyphicon glyphicon-remove"></span></a></td>
		
	</tr>
	
	<tr><td></td><td colspan="5"><b style="font-size:12px"><span class="glyphicon glyphicon-book"></span> 
	'.$row->formatedReference .'</b>
	</td></tr>
	
	';

	$i++;
	}
	
}
$script .="]";
?>
	
</table>
<br />
<a href="<?=Url::to(['course/course-reference-add', 'course' => $model->course->id, 'version' => $model->id])?>" id="btn-add" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-plus"></span> Add Reference</a>
<br /> <i>* please save before add or remove reference</i>

    
</div>
</div>


    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE REFERENCE', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

