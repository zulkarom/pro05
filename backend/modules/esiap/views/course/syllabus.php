<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use yii\bootstrap\Modal;
use kartik\sortable\Sortable;
use kartik\select2\Select2;



/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */


$this->title = 'Course Syllabus';
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Syllabus';
?>

<?=$this->render('_header',[
'course' => $model->course
])?>

<?php $form = ActiveForm::begin(['id' => 'formsyll']); ?>
<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>
	
<div class="box">
<div class="box-body">	
    


	<table class='table table-hover table-striped'>
	<thead><tr>
	<th width='8%'>WEEK</th>
	
	<th width='10%'>CLO</th>
	<th>TOPICS</th>
	<th>DURATION<br />
	
	</th>
	<th></th>
	
	</tr></thead>
<?php 

$totalclo = count($clos);
$i = 1;
$week_num = 1;
$arr_week = array();
$array_week_sorting = array();
foreach($syllabus as $row){ ?>
	<tr>
	<td>
	<?php 
	$show_week = '';
	if($row->duration > 1){
		$end = $week_num + $row->duration - 1;
		$show_week = $week_num . ' - ' . $end;
	}else{
		$show_week = $week_num;
	}
	$arr_week[$week_num] = 'WEEK ' . $show_week;
	
	echo $show_week;
	$week_num = $week_num + $row->duration;
	?>
	<input id="input-week-<?php echo $i ; ?>" name="input-week-<?php echo $i ; ?>" type="hidden" value="" />
	</td>
	<td>
	<?php 
	$clo = json_decode($row->clo);
	if(!$clo){
		$clo = array();
	}
	for($f=1;$f<=$totalclo;$f++){
		$check = in_array($f, $clo) ? "checked" : "";
		echo '<div class="form-group"><label><input type="checkbox" value="'.$f.'" name="'.$i.'-clo[]" '.$check.' /> CLO'.$f . "</label></div>";
	}
	
	?>
	</td>
	<td>
		<div id='topic-<?php echo $i; ?>'>
		<?php 
		$arr_all = json_decode($row->topics);
		$ex_topic = '';
		$topic_num = 1;
		if($arr_all){
		foreach($arr_all as $rt){
			if($topic_num == 1){
					$ex_topic = $rt->top_bm;
				}
		?>
		<div class='topic-container form-group'>
		<div class='row'>
		<div class='col-md-1'><label>Topik: </label>
		<br><i>(BM)</i>
		</div>
		<div class='col-md-5'>
			<div class='form-group'>
			<textarea rows="1" class='form-control topic-text'><?php echo $rt->top_bm;?></textarea>
			
			</div>
		</div>
		<div class='col-md-1'><label>Topic: </label><br><i>(EN)</i></div>
		<div class='col-md-5'>
			<div class='form-group'>
			<textarea rows="1" class='form-control topic-text'><?php echo $rt->top_bi;?></textarea>
			</div>
		</div>
		</div>
		
		<!--  -->
		<div class='consubtopic'>
		<div class='consubtopicinput'>
		<?php 
		
		if($rt->sub_topic){
			
			foreach($rt->sub_topic as $rst){
				
			?>
				<div class='row-subtopic'><div class='row'>
				<div class='col-md-1'></div>
				<div class='col-md-1'><label>Sub (BM): </label></div>
				<div class='col-md-4'>
				<div class='form-group'>
				<textarea rows='1' class='form-control subtopic-text'><?php echo $rst->sub_bm;?></textarea>
				</div>
				</div>
				<div class='col-md-1'></div>
				<div class='col-md-1'><label>Sub (EN): </label></div>
				<div class='col-md-4'>
				<div class='form-group'>
				<textarea rows='1' class='form-control subtopic-text'><?php echo $rst->sub_bi;?></textarea>
				</div>
				</div>
				</div></div>
			<?php
			
			}
		}
		?>
		</div>
			<div class='row'>
				<div class='col-md-1'></div>
				<div class='col-md-6'>
				<i style='font-size:12px'><a href="javascript:void(0)" class='addsubtopic' >
				<span class='glyphicon glyphicon-plus'></span> Add Sub Topic</a> &nbsp; <a href="javascript:void(0)" class='removesubtopic'>
				<span class='glyphicon glyphicon-remove'></span> Remove Last Sub Topic</a></i>
				</div>
			</div>
		</div>
		</div>
		<?php 
		$topic_num++;
		} } 
		
		$array_week_sorting[] = ['content' => 'WEEK ' . $show_week . ' ' . $ex_topic, 'options' => ['id' => $row->id, 'class' => 'week-item']];
		?>
		</div>
		
		
		<br />
		<button type='button' class='btn btn-default btn-sm' id='btn-topic-<?php echo $i;?>'>
		<span class='glyphicon glyphicon-plus'></span> Add Topic</button> <button type='button' class='btn btn-default btn-sm' id='btnx-topic-<?php echo $i;?>'>
		<span class='glyphicon glyphicon-remove'></span> Remove Last Topic</button>
	
	
	
	</td>
	
	
	<td>
	
	<?php 
	$weeks = ['1' => '1 Week','2' => '2 Weeks','3' => '3 Weeks','4' => '4 Weeks','5' => '5 Weeks'];
	
	?>
	
	<select class="form-control" id="week-duration-<?php echo $i ; ?>" name="week-duration-<?php echo $i ; ?>">
		<?php 
		foreach($weeks as $val => $week){
			$sel = $row->duration == $val ? 'selected' : '';
			echo '<option value="'.$val.'" '.$sel.'>'.$week.'</option>';
		}
		
		?>
	</select>
	
	</td>
	
	
	<td>
	
	<a href="javascript:void(0)" data="<?=$row->id?>" class="btn-delete-week"><span class="glyphicon glyphicon-remove"></span></a> 
	

	
	</td>
	
	
	
	</tr>
	
<?php
$i++;
}

?>

<tr><td colspan="3">


	<div class="row">

<div class="col-md-4"><button type="button" id="btn-add-week" class="btn btn-warning btn-sm"><span class='glyphicon glyphicon-plus'></span> Add Week</button> 


<?php 
Modal::begin([
    'header' => '<h5>Re-order Weeks</h5>',
    'toggleButton' => ['label' => '<i class="glyphicon glyphicon-move"></i> Re-order Weeks', 'class' => 'btn btn-warning btn-sm'],
	'size' => 'modal-md',
    'footer' => '<div class="form-group">
                            <a id="btn-reorder" href="'.Url::to(['course/course-syllabus-reorder', 'id' => $model->course->id]) .'" class="btn btn-success">Re-order</a> 
                         </div>'
]);


echo Sortable::widget([
    'type' => Sortable::TYPE_LIST,
	'showHandle'=>true,
	'pluginEvents' => [
		'sortupdate' => 'function() {updateWeekSorting();}',
	],
    'items' => $array_week_sorting
]); 

Modal::end();

?>

</div>

<div class="col-md-4"><label>Mid-Semester Break After Week: </label></div>

<div class="col-md-3"><?php 
$sem_break = json_decode($model->syllabus_break);

echo Select2::widget([
    'name' => 'sem_break',
    'value' => $sem_break,
    'data' => $arr_week,
    'options' => ['multiple' => true, 'required' => true, 'placeholder' => 'Select week ...']
]);

?>
</div>

</div>
	



	</td><td colspan="2"></td></tr>
<?php 
/* if(!$model->final_week){
	$model->final_week = '17-19';
}
if(!$model->study_week){
	$model->study_week = '16';
}
 */
?>

<?php 
/* <tr><td>
	<label>WEEK</label>
	<input type="text" class="form-control" value="<?=$model->study_week?>" name="study-week" />
	
	</td>
	
	<td colspan="3" style="vertical-align:middle">Minggu Ulang Kaji<br />
<i>Study Week</i>
</td></tr>	

<tr><td>
	<label>WEEK</label>
	<input type="text" class="form-control" value="<?=$model->final_week?>" name="final-week" />
	
	</td>
	
	<td colspan="3" style="vertical-align:middle">Peperiksaan Akhir<br />
<i>Final Exam</i>
</td></tr>	 */

?>

	
	
</table>

</div></div>


    <div class="form-group">
	<input type="hidden" id="delete-week-id" name="delete-week-id" value="" />
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE SYLLABUS', ['class' => 'btn btn-primary', 'name' => 'btn-submit', 'id' => 'btn-submit', 'value' => 'normal']) ?>
    </div>

    <?php ActiveForm::end(); ?>


<?php JSRegister::begin(); ?>
<script>

$("#btn-add-week").click(function(){
	$("#btn-submit").val("add-week");
	$("form#formsyll").submit();
});

$(".btn-delete-week").click(function(){
	var id = $(this).attr("data");
	$("#delete-week-id").val(id);
	$("#btn-submit").val("delete-week");
	$("form#formsyll").submit();
});



var tw = <?=count($syllabus)?>;
for(i=1;i<=tw;i++){
		$("#btn-topic-"+i).click(function(){
			var att = $(this).attr('id');
			att = att.split('-');
			var week = att[2];
			$("#topic-" + week).append(genTopic());
			btnSubTopic();
			clearBtn();
			btnSubTopic();
			 autosizeTextarea();
			
		});
		$("#btnx-topic-"+i).click(function(){
			var att = $(this).attr('id');
			att = att.split('-');
			var week = att[2];
			$("#topic-" + week + " div.topic-container").last().remove();
			
		});
		
		
		
	}
	
	btnSubTopic();
	
	$("form#formsyll").submit(function(){
    putJson();
	});




function putJson(){
	for(g=1;g<=tw;g++){
		var myArray = [];
	var topic;
	var subtopic;
 	$("#topic-"+g+" .topic-text").each(function(i,obj){
		var val = $(this).val();
		if(isEven(i)){
			topic = new Object();
			topic.top_bm = val;
		}else{
			topic.top_bi = val;
			var mySubArray = [];
			$(this).parents('.topic-container').children('.consubtopic').children('.consubtopicinput').find('.subtopic-text').each(function(x){
				var subval = $(this).val();
				if(isEven(x)){
					subtopic = new Object();
					subtopic.sub_bm = subval;
				}else{
					subtopic.sub_bi = subval;
					mySubArray.push(subtopic);
				}
				//alert();
			});
			//alert(sel);
			topic.sub_topic = mySubArray;
			myArray.push(topic);
		}
		
	}); 
	
	var myString = JSON.stringify(myArray);
	$("#input-week-"+g).val(myString);
	
	}
	
	
}

function isEven(n) {
   return n % 2 == 0;
}

function isOdd(n) {
   return Math.abs(n % 2) == 1;
}

function clearBtn(){
	$(".addsubtopic").off('click');
	$(".removesubtopic").off('click');
}

function btnSubTopic(){
	$(".addsubtopic").click(function(){
		var sel = $(this).parents("div.consubtopic").children(".consubtopicinput");
		sel.append(genSubTopic());
		 autosizeTextarea();
	});
	$(".removesubtopic").click(function(){
		var sel = $(this).parents("div.consubtopic").children(".consubtopicinput").children("div.row-subtopic"); 
		sel.last().remove();
			
	}); 
}

function genSubTopic(){
	var html = "<div class='row-subtopic'><div class='row'>";
	html += "<div class='col-md-1'></div>";
	html += "<div class='col-md-1'><label>Sub (BM): </label></div>";
	html += "<div class='col-md-4'>";
	html += "<div class='form-group'>";
	html += "<textarea rows='1' class='form-control subtopic-text' ></textarea>";
	html += "</div>";
	html += "</div>";
	html += "<div class='col-md-1'></div>";
	html += "<div class='col-md-1'><label>Sub (EN): </label></div>";
	html += "<div class='col-md-4'>";
	html += "<div class='form-group'>";
	html += "<textarea rows='1' class='form-control subtopic-text' ></textarea>";
	html += "</div>";
	html += "</div>";
	html += "</div></div>";
	return html;
}

function genTopic(){
	var html = "<div class='topic-container form-group'>";
		html += "<div class='row'>";
		html += "<div class='col-md-1'><label>Topik: </label>";
		html += "<br><i>(BM)</i>";
		html += "</div>";
		html += "<div class='col-md-5'>";
			html += "<div class='form-group'>";
			html += "<textarea rows='1' class='form-control topic-text' ></textarea>";
			html += "</div>";
		html += "</div>";
		html += "<div class='col-md-1'><label>Topic: </label><br><i>(EN)</i></div>";
		html += "<div class='col-md-5'>";
			html += "<div class='form-group'>";
			html += "<textarea rows='1' class='form-control topic-text' ></textarea>";
			html += "</div>";
		html += "</div>";
		html += "</div>";
		
		html += "	<div class='consubtopic'>";
		html += "<div class='consubtopicinput'> </div>";
			html += "<div class='row'>";
				html += "<div class='col-md-1'></div>";
				html += "<div class='col-md-6'>";
				
				html += "<i style='font-size:12px'><a href='javascript:void(0)' class='addsubtopic' >";
				html += "<span class='glyphicon glyphicon-plus'></span> Add Sub Topic</a> &nbsp; <a href='javascript:void(0)' class='removesubtopic'>";
				html += "<span class='glyphicon glyphicon-remove'></span> Remove Last Sub Topic</a></i>";
				html += "</div>";
			html += "</div>";
		html += "</div>";
			html += "</div>";
	
	return html;
}

function autosizeTextarea(){
    $("textarea").each(function(){
        autosize($(this));
    });
}

function updateWeekSorting(){
	var order = 0;
	var params = '';
	$("#w1").find('.week-item').each(function(i, el){
		order = i + 1;
		id = this.id;
		params += '&or[' + id + ']=' + order;
		
     });
	 var url = $('#btn-reorder').attr('href');
	 $('#btn-reorder').attr('href', url + params);
	 //console.log();
}

//var ids = $('#w1 li').map(function(i) { return this.id; }).get();

</script>
<?php JSRegister::end(); ?>