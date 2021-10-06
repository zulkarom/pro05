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
$this->params['breadcrumbs'][] = ['label' => 'Preview', 'url' => ['course/view-course', 'course' => $model->course_id, 'version' => $model->id]];
$this->params['breadcrumbs'][] = 'Course Syllabus';
?>

<?=$this->render('_header',[
'course' => $model->course, 
    'version' => $model
])?>

<?php $form = ActiveForm::begin(['id' => 'formsyll']); ?>
<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>
	
<div class="box box-primary">
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
$list_weeks = ['1' => '1 Week'];
for($ii=2;$ii<=5;$ii++){
	$list_weeks[$ii] = $ii.' Weeks';
}
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
		<div class='col-md-1'><label>TOPIC: </label>
		<br><i>(BM)</i>
		</div>
		<div class='col-md-5'>
			<div class='form-group'>
			<textarea rows="1" class='form-control topic-text'><?php echo $rt->top_bm;?></textarea>
			
			</div>
		</div>
		<div class='col-md-1'><label>TOPIC: </label><br><i>(EN)</i></div>
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
				<div class='col-md-1'><label>SUB (BM): </label></div>
				<div class='col-md-4'>
				<div class='form-group'>
				<textarea rows='1' class='form-control subtopic-text'><?php echo $rst->sub_bm;?></textarea>
				</div>
				</div>
				<div class='col-md-1'></div>
				<div class='col-md-1'><label>SUB (EN): </label></div>
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
		
		<?php 
Modal::begin([
    'header' => 'Quick Add Topics (#) and Sub Topics (*)',
    'toggleButton' => ['label' => '<span class="glyphicon glyphicon-file"></span> Quick Add', 'class' => 'btn btn-default btn-sm btn-quick', 'id' => 'btn-quick-' . $i],
	'size' => 'modal-lg',
    'footer' => '<div class="form-group">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-default">Close</button> 
		<button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-primary btn-insert-quick"  id="insert-'.$i.'">Insert</button> 
	 </div>'
]);
?>

<textarea class="form-control" id="quick-box-<?=$i?>" rows="10"></textarea>

<?php
Modal::end();



?>
		
	
	
	
	</td>
	
	
	<td>
	
	
	
	<select class="form-control" id="week-duration-<?php echo $i ; ?>" name="week-duration-<?php echo $i ; ?>">
		<?php 
		foreach($list_weeks as $val => $week){
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
                            <a id="btn-reorder" href="'.Url::to(['course/course-syllabus-reorder', 'id' => $model->course->id, 'version' => $model->id]) .'" class="btn btn-success">Re-order</a> 
                         </div>'
]);

echo '<div id="modal-order">';
echo Sortable::widget([
    'type' => Sortable::TYPE_LIST,
	'showHandle'=>true,
	'pluginEvents' => [
		'sortupdate' => 'function() {updateWeekSorting();}',
	],
    'items' => $array_week_sorting
]); 
echo '</div>';

Modal::end();

?>

</div>

<div class="col-md-5"><label>Mid-Semester Break After Week: </label><br />
<i style="font-size:12px">Note: mid-semester break will be inserted in FK2 according to this setting.</i>
</div>

<div class="col-md-3"><?php 
$sem_break = json_decode($model->syllabus_break);

echo Select2::widget([
    'name' => 'sem_break',
    'value' => $sem_break,
    'data' => $arr_week,
    'options' => ['multiple' => true, 'placeholder' => 'Select week ...']
]);

?>
</div>

</div>
	



	</td><td colspan="2"></td></tr>
	
	
</table>

</div></div>

<div class="form-group">
<?php 
$check = $model->pgrs_syll == 2 ? 'checked' : ''; ?>
<label>
<input type="checkbox" id="complete" name="complete" value="1" <?=$check?> /> Mark as complete
</label></div>


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
	if(confirm("Are you sure to delete this week?")){
		var id = $(this).attr("data");
		$("#delete-week-id").val(id);
		$("#btn-submit").val("delete-week");
		$("form#formsyll").submit();
	}
	
});

$(".btn-quick").click(function(){
	var str = $(this).attr("id");
	var arr = str.split("-");
	var id = arr[2];
	putQcode(id);
	//alert(code);
});

$(".btn-insert-quick").click(function(){
	var str = $(this).attr("id");
	var arr = str.split("-");
	var id = arr[1];
	$("#topic-" + id).html('');
	var str = $("#quick-box-"+id).val();
	var sub;
	var topic;
	var subtopic;
	str = str.trim();
	str = str.replace(/(\r\n|\n|\r)/gm, "");
	var html = '';
	var subhtml = '';
	//check #
	if (str.indexOf('#') > -1){
		var topic_arr = str.split("#");
		if(topic_arr){
			for(i=1;i< topic_arr.length;i++){
				sub = topic_arr[i];
				//check *
				if (sub.indexOf('*') > -1){
					sub_arr = sub.split('*');
					//topic 0
						topic = splitLang(sub_arr[0]);
						
					subhtml = '';
					for(x=1;x<sub_arr.length;x++){
						//sub topic
						subtopic = splitLang(sub_arr[x]);
						subhtml += genSubTopic(subtopic[0], subtopic[1]);
					}
					html += genTopic(topic[0], topic[1], subhtml);
				}else{
					//topic no sub
					topic = splitLang(sub);
					html += genTopic(topic[0], topic[1], '');
				}
				
			}
		}
	}
	
	$("#topic-" + id).html(html);
	btnSubTopic();
	$("textarea").each(function(){
        autosize($(this));
    });
});



var tw = <?=count($syllabus)?>;
for(i=1;i<=tw;i++){
		$("#btn-topic-"+i).click(function(){
			var att = $(this).attr('id');
			att = att.split('-');
			var week = att[2];
			$("#topic-" + week).append(genTopic('','',''));
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


function splitLang(lStr){
	if (lStr.indexOf('//') > -1){
		var arr = lStr.split('//');
		return [arr[0], arr[1]];
	}else if(lStr.indexOf('/') > -1){
		var arr = lStr.split('/');
		return [arr[0], arr[1]];
	}else{
		return [lStr, ''];
	}
}

function putQcode(week){

	var str = '';
 	$("#topic-"+week+" .topic-text").each(function(i,obj){
		var val = $(this).val();
		//alert(val);
		if(isEven(i)){
			str += '#' + val ;
		}else{
			if (val.indexOf('/') > -1){
				str += '//' +  val + "\n" ;
			}else{
				str += '/' +  val + "\n" ;
			}
			
			$(this).parents('.topic-container').children('.consubtopic').children('.consubtopicinput').find('.subtopic-text').each(function(x){
				var subval = $(this).val();
				if(isEven(x)){
					str +=  '*' + subval;
				}else{
					if (subval.indexOf('/') > -1){
						str +=  '//' +  subval + "\n";
					}else{
						str +=  '/' +  subval + "\n";
					}
					
				}
			});
		}
		
	}); 
	
	//return str;
	
	$("#quick-box-"+week).val(str);
	
	
	
}

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
		sel.append(genSubTopic('',''));
		 autosizeTextarea();
	});
	$(".removesubtopic").click(function(){
		var sel = $(this).parents("div.consubtopic").children(".consubtopicinput").children("div.row-subtopic"); 
		sel.last().remove();
			
	}); 
}

function genSubTopic(bm,bi){
	var html = "<div class='row-subtopic'><div class='row'>";
	html += "<div class='col-md-1'></div>";
	html += "<div class='col-md-1'><label>SUB (BM): </label></div>";
	html += "<div class='col-md-4'>";
	html += "<div class='form-group'>";
	html += "<textarea rows='1' class='form-control subtopic-text' >"+bm+"</textarea>";
	html += "</div>";
	html += "</div>";
	html += "<div class='col-md-1'></div>";
	html += "<div class='col-md-1'><label>SUB (EN): </label></div>";
	html += "<div class='col-md-4'>";
	html += "<div class='form-group'>";
	html += "<textarea rows='1' class='form-control subtopic-text' >"+bi+"</textarea>";
	html += "</div>";
	html += "</div>";
	html += "</div></div>";
	return html;
}

function genTopic(bm,bi, sub){
	var html = "<div class='topic-container form-group'>";
		html += "<div class='row'>";
		html += "<div class='col-md-1'><label>TOPIC: </label>";
		html += "<br><i>(BM)</i>";
		html += "</div>";
		html += "<div class='col-md-5'>";
			html += "<div class='form-group'>";
			html += "<textarea rows='1' class='form-control topic-text' >"+bm+"</textarea>";
			html += "</div>";
		html += "</div>";
		html += "<div class='col-md-1'><label>TOPIC: </label><br><i>(EN)</i></div>";
		html += "<div class='col-md-5'>";
			html += "<div class='form-group'>";
			html += "<textarea rows='1' class='form-control topic-text' >"+bi+"</textarea>";
			html += "</div>";
		html += "</div>";
		html += "</div>";
		
		html += "	<div class='consubtopic'>";
		html += "<div class='consubtopicinput'>"+sub+"</div>";
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
	$("#modal-order").find('.week-item').each(function(i, el){
		order = i + 1;
		id = this.id;
		params += '&or[' + id + ']=' + order;
		
     });
	
	 var url = $('#btn-reorder').attr('href');
	 // alert(url + params);
	 $('#btn-reorder').attr('href', url + params);
	 //console.log();
}

//var ids = $('#w1 li').map(function(i) { return this.id; }).get();

</script>
<?php JSRegister::end(); ?>