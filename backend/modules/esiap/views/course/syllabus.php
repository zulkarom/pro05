<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use yii\bootstrap\Modal;
use kartik\sortable\Sortable;



/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */


$this->title = 'Syllabus: ' . $model->course->course_name . ' '. $model->course->course_code;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>

<?php $form = ActiveForm::begin(['id' => 'formsyll']); ?>
	
<div class="box">
<div class="box-header"></div>
<div class="box-body">	

<i>* Do consider to put also mid semester break here normally at Week 7 or Week 8 <br />Topik (BM) = Cuti Pertengahan Semester | Topic (EN) = Mid Semester Break</i>
    
<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>




	<table class='table table-hover table-striped'>
	<thead><tr><th width='10%'>WEEK</th><th width='10%'>CLO</th><th>TOPICS</th><th></th></tr></thead>
<?php 
$totalclo = count($clos);
$i = 1;
foreach($syllabus as $row){ ?>
	<tr>
	<td><label>WEEK</label>
	<input type="text" class="form-control" value="<?=$row->week_num?>" name="week-num-<?=$i?>" required />
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
		if($arr_all){
		foreach($arr_all as $rt){
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
		<?php } } ?>
		</div>
		
		
		<br />
		<button type='button' class='btn btn-default btn-sm' id='btn-topic-<?php echo $i;?>'>
		<span class='glyphicon glyphicon-plus'></span> Add Topic</button> <button type='button' class='btn btn-default btn-sm' id='btnx-topic-<?php echo $i;?>'>
		<span class='glyphicon glyphicon-remove'></span> Remove Last Topic</button>
	
	
	
	</td>
	<td>
	
	<?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['course/course-syllabus-delete', 'version' => $model->id, 'id' => $row->id], [
            'data' => [
                'confirm' => 'Are you sure you want to delete this week?',
                'method' => 'post',
            ],
        ]) ?>

	
	</td>
	</tr>
	
<?php
$i++;
}

?>

<tr><td colspan="3">


	<div class="row">
	<div class="col-md-1">


</div>
<div class="col-md-11"><a href="<?=Url::to(['course/course-syllabus-add', 'version' => $model->id])?>" class="btn btn-warning btn-sm"><span class='glyphicon glyphicon-plus'></span> Add Week</a> 


<?php 
Modal::begin([
    'header' => '<h5>Re-order Weeks</h5>',
    'toggleButton' => ['label' => '<i class="glyphicon glyphicon-move"></i> Re-order Weeks', 'class' => 'btn btn-warning btn-sm'],
	'size' => 'modal-sm',
    'footer' => '<div class="form-group">
                            <a id="btn-reorder" href="'.Url::to(['course/course-syllabus-reorder', 'id' => 24]) .'" class="btn btn-success">Re-order</a> 
                         </div>

                         <?php ActiveForm::end(); ?>'
]);

$array = [];

foreach($syllabus as $row){
	$array[] = ['content' => 'WEEK ' . $row->week_num, 'options' => ['id' => $row->id, 'class' => 'week-item']];
}

echo Sortable::widget([
    'type' => Sortable::TYPE_LIST,
	'showHandle'=>true,
	'pluginEvents' => [
		'sortupdate' => 'function() {updateWeekSorting();}',
	],
    'items' => $array
]); 

Modal::end();

?>

</div>



</div>
	
	<br /><i>* please save before adding or removing weeks</i>
	</td><td colspan="2"></td></tr>
<?php 
if(!$model->final_week){
	$model->final_week = '17-19';
}
if(!$model->study_week){
	$model->study_week = '16';
}

?>
<tr><td>
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
</td></tr>	
	
	
</table>

</div></div>


    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE SYLLABUS', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


<?php JSRegister::begin(); ?>
<script>
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