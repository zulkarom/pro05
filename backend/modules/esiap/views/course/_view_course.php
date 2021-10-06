<?php 

use yii\helpers\Url;

?>
<div class="box box-primary">
<div class="box-header"></div>
<div class="box-body">



<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tbody>
	
	
	  <?php 
	  
	  if(!$current){
		  ?>
		  <tr>
        <td width="20%"><b>VERSION</b></td>
        <td><?=$version->version_name?></td>
      </tr>
	  <tr>
        <td width="20%"><b>DOCUMENTS</b></td>
        <td><?=$model->reportList('View Doc Report', $version->id)?></td>
      </tr>
		  
		  <?php
	  }
	  
	  
	  
	  
	  ?>
	  
	  
      <tr>
        <td width="20%"><b>COURSE CODE</b></td>
        <td><?=$model->course_code?></td>
      </tr>
	  
	  <tr>
        <td><b>COURSE NAME</b></td>
       <td><?=$model->course_name?> <br />
	   <i><?=$model->course_name_bi?></i>
	   </td>
      </tr>
	   <tr>
        <td><b>COURSE CLASSIFICATION</b></td>
        <td><?php 
		if($model->classification){
			echo $model->classification->class_name_bi;
		}
		?></td>
      </tr>
	  <tr>
        <td><b>CREDIT HOUR</b></td>
        <td><?=$model->credit_hour?></td>
      </tr>
	  
	  
	  
	 
	  
	  <tr>
        <td><b>PROGRAM</b></td>
        <td>
		
		<?php 
		
		if($model->program){
			echo $model->program->pro_name 
			.  '<br /> <i>'  .
			$model->program->pro_name_bi . '</i>';
			
		}
		?>

		</td>
      </tr>
	  
	  <tr>
        <td><b>SYNOPSIS</b></td>
        <td>
		
		<?php 
		
		if($version->profile){
			echo $version->profile->synopsis 
			.  '<br /><br /> <i>'  .
			$version->profile->synopsis_bi . '</i>';
			
		}
		?>

		</td>
      </tr>
	  
	   <tr>
        <td><b>NAME(S)  OF ACADEMIC STAFF</b></td>
        <td>
		
		<?php 
		
		$str = '';
		$staff = $version->profile->academicStaff;
			if($staff){
				foreach($staff as $st){
					$str .= $st->staff->niceName . "<br />";
				}
			}
			
		
		
		echo $str;
		?>
		
		</td>
      </tr>
	  
	  <tr>
        <td><b>PREREQUISITE/CO-REQUISITE</b></td>
        <td>
		
		<?php 
		
		if($version->profile){
			$pre = $version->profile->coursePrerequisite;
			echo $pre[1];
			
		}
		?>

		</td>
      </tr>
	  
	  <tr>
        <td><b>SEMESTER OFFERED</b></td>
        <td>
		
		<?php 
		
		if($version->profile){
			
			$offer_sem = $version->profile->offer_sem;
			if($offer_sem == 0){
				$offer_sem = '';
			}
			$offer_year = $version->profile->offer_year;
			if($offer_year == 0){
				$offer_year = '';
			}
			
			echo $offer_sem;
			
		}
		?>

		</td>
      </tr>
	  
	  <tr>
        <td><b>YEAR OFFERED</b></td>
        <td>
		
		<?php 
		
		if($version->profile){
			
			echo $offer_year;
			
		}
		?>

		</td>
      </tr>
	  
	  <tr>
        <td><b>OFFER REMARK</b></td>
        <td>
		
		<?php 
		
		if($version->profile){
			
			$version->profile->offer_remark;
			
		}
		?>

		</td>
      </tr>
	  
	  
	   <tr>
        <td><b>OBJECTIVE</b></td>
        <td>
		
		<?php 
		
		if($version->profile){
			echo $version->profile->objective
			.  '<br /><i>'  .
			$version->profile->objective_bi . '</i>';
			
		}
		?>

		</td>
      </tr>
	  
	   <tr>
        <td><b>RATIONAL</b></td>
        <td>
		
		<?php 
		
		if($version->profile){
			echo $version->profile->rational
			.  '<br /><i>'  .
			$version->profile->rational_bi . '</i>';
			
		}
		?>

		</td>
      </tr>
	  
	   <tr>
        <td><b>FEEDBACK</b></td>
        <td>
		
		<?php 
		
		if($version->profile){
			echo $version->profile->feedback
			.  '<br /> <i>'  .
			$version->profile->feedback_bi . '</i>';
			
		}
		?>

		</td>
      </tr>
	  
	  
	  <tr>
        <td><b>TRANSFERABLE SKILLS</b></td>
        <td>
		
		<?php 
		
		if($version->profile->transferables){
			foreach($version->profile->transferables as $trans){
				echo $trans->transferable->transferable_text . ' / ' . $trans->transferable->transferable_text_bi . '<br />' ;
			}
		}
		
	
		?>
		
		</td>
      </tr>
	  
	  <tr>
        <td><b>TRANSFERABLE SKILLS <br />(open-ended)</b></td>
        <td>
		
		<?php 
		
		if($version->profile){
			echo $version->profile->transfer_skill . '<br />' . 
			$version->profile->transfer_skill_bi
			;
		}
		
	
		?>
		
		</td>
      </tr>
	  
	  <tr>
        <td><b>SPECIAL REQUIREMENT</b></td>
        <td>
		
		<?php 
		
		if($version->profile){
			echo $version->profile->requirement
			.  '<br /> <i>'  .
			$version->profile->requirement_bi . '</i>';
			
		}
		?>

		</td>
      </tr>
	  
	  <tr>
        <td><b>ADDITIONAL INFORMATION </b></td>
        <td>
		
		<?php 
		
		if($version->profile){
			echo $version->profile->additional
			.  '<br /> <i>'  .
			$version->profile->additional_bi . '</i>';
			
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
	  <th>#</th>
        <th>COURSE LEARNING OUTCOMES</th>
        <th>PLO</th>
        <th>TAXONOMY</th>
		<th>TEACHING METHODS</th>
		<th>ASSESSMENT</th>
		<th>SOFTSKILLS</th>
      </tr>
    </thead>
    <tbody>
	  
	  <?php 
	  
	  if($version->clos){
		  $i = 1;
			foreach($version->clos as $clo){
				echo '<tr>';
				echo '<td>'.$i.'. </td>';
				echo '<td>' . $clo->clo_text . '<br /> <i>' . $clo->clo_text_bi . '</i> </td>';
				
				$plo = '';
				$plo_num = $version->ploNumber;
				$x=1;
				for($c=1;$c<=$plo_num;$c++){
					$prop = 'PLO'.$c;
					if($clo->$prop == 1){
						
						$comma = $x == 1 ? '' : '<br />';
						$plo .= $comma.$prop;
						$x++;
					}
				}
				
				echo '<td>'.$plo.'</td>';
				echo '<td>'.$clo->taxonomyStr.'</td>';
				
				$method = '';
				$assess = '';
				$s=1;
				if($clo->cloDeliveries){
				foreach($clo->cloDeliveries as $r){
					$comma = $s == 1 ? '' : '<br />' ;
					$method .= $comma. $r->delivery->delivery_name . '<br /><i>' . $r->delivery->delivery_name_bi . '</i>' ;
				$s++;
				}
				}
				if($clo->cloAssessments){
					$s = 1;
				foreach($clo->cloAssessments as $r){
					$comma = $s == 1 ? '' : '<br />' ;
					if($r->assessment){
						$assess  .= $comma.$r->assessment->assess_name . '<br /><i>' .$r->assessment->assess_name_bi . '</i>' ;
					}
					$s++;
				}
				}

				
				echo '<td>'.$method.'</td>';
				echo '<td>'.$assess.'</td>';
				echo '<td>'.$clo->softskillStr.'</td>';
				echo '</tr>';
			$i++;	
			}
		
		}
	  
	  
	  
	  
	  ?>
     
    </tbody>
  </table>
</div>

<div class="table-responsive"><table class='table table-hover table-striped'>
	<thead>
	<tr>
	<th width='1%' rowspan='3'>WEEK</th>
	<th rowspan='3' width="25%">TOPICS</th>
	
	<th colspan="8" style="text-align:center">FACE-TO-FACE (F2F)</th>
	
	<th rowspan="3"  style="vertical-align:bottom;text-align:center">
	NF2F<br />
	INDEPENDENT LEARNING<br />
	(ASYNCHRONOUS)
	
	</th>
	<th rowspan="3" style="vertical-align:bottom;text-align:center">TOTAL<br />SLT</th>
	
	</tr>
	
	<tr>
	
	<th style='text-align:center' colspan='4' >PHYSICAL
	
	</th>
	
	<th style="vertical-align:top;text-align:center;" colspan="4">
	ONLINE /<br /> TECHONOLY-MEDIATED <br />
	(SYNCHRONOUS)


	</th>
	
	
	</tr>
	
	<tr>
	
	<th style='text-align:center'>L</th><th style='text-align:center'>T</th><th style='text-align:center'>P</th><th style='text-align:center'>O</th>
	
	<th style='text-align:center;'>L</th><th style='text-align:center;'>T</th><th style='text-align:center;'>P</th><th style='text-align:center;'>O</th>
	
	
	</tr>
	</thead>
<?php 
$syll = $version->syllabus;
$arr_syll = "";
$i=1;
$week_num = 1;
$total = 0;
foreach($syll as $row){ ?>
	<tr>
	<td>
	<b><?php 
	$show_week = '';
	if($row->duration > 1){
		$end = $week_num + $row->duration - 1;
		$show_week = $week_num . '-' . $end;
	}else{
		$show_week = $week_num;
	}
	$arr_week[$week_num] = 'WEEK ' . $show_week;
	
	echo $show_week;
	
	$week_num = $week_num + $row->duration;
	
	
	
	
	?>
	
	</b>
	</td>
	<td>
	
		<?php 
		$arr_syll .= $i == 1 ? $row->id : ", " . $row->id ;
		$arr_all = json_decode($row->topics);
		if($arr_all){
		foreach($arr_all as $rt){
		echo "<strong>".$rt->top_bm ." / <i>". $rt->top_bi . "</i></strong>";
		if($rt->sub_topic){
		echo "<ul>";
			foreach($rt->sub_topic as $rst){
			echo "<li>".$rst->sub_bm . " / <i>" . $rst->sub_bi . "</i></li>";
			}
		echo "</ul>";
		}
		} 
		} 
		?>
		
	</td>
	<td style="vertical-align:middle;text-align:center"><!-- LECTURE -->
	<?php echo $row->pnp_lecture ; ?>
	</td>
	<td style="vertical-align:middle;text-align:center"><!-- TUT -->
	<?php echo $row->pnp_tutorial ; ?>
	</td>
	<td style="vertical-align:middle;text-align:center"><!-- PRACTICAL -->
	<?php echo $row->pnp_practical ; ?>
	</td>
	
	<td style="vertical-align:middle;text-align:center">
	<?php echo $row->pnp_others ; ?>
	</td>
	

	
	<td style="vertical-align:middle;text-align:center">
	<?php echo $row->tech_lecture ; ?>
	</td>
	
	<td style="vertical-align:middle;text-align:center">
	<?php echo $row->tech_tutorial ; ?>
	</td>
	<td style="vertical-align:middle;text-align:center">
	<?php echo $row->tech_practical ; ?>
	</td>
	<td style="vertical-align:middle;text-align:center">
	<?php echo $row->tech_others ; ?>
	</td>
	
	
	
	<td style="vertical-align:middle;text-align:center">
	<?php echo $row->independent ; ?>
	</td>
	<td style="vertical-align:middle;text-align:center">
	
	<?php 
	$subtotal = $row->independent + $row->pnp_others + $row->pnp_practical + $row->pnp_tutorial + $row->pnp_lecture 
	+ $row->tech_others + $row->tech_practical + $row->tech_tutorial + $row->tech_lecture
	;
	$total += $subtotal;
 
	?>
	<strong id="subsyll_<?php echo $row->id;?>"><?=$subtotal?></strong>
</td>
	</tr>
<?php 
$i++;
}
?>

<tr style="text-align:center;font-weight:bold">
<td colspan="11"><b></b></td>

<td id="subsyll_total"><?=$total?></td>
</tr>
</table></div>


<div class="table-responsive"><table class="table table-striped table-hover">
<thead>
	<tr>
		<th rowspan="2" width="30%" style="vertical-align:bottom"><b>
		CONTINUOUS ASSESSMENT
		</b></th>
		<th rowspan="2" style="vertical-align:bottom"><b>
		PERCENTAGE
		</b></th>
		<th width="40%" colspan="2" style="text-align:center"><b>FACE-TO-FACE(F2F)</b></th>
		<th width="20%" style="text-align:center" rowspan="2"><b>NF2F <br />
INDEPENDENT LEARNING FOR ASSESSMENT<br />
 (ASYNCHRONOUS)</b></th>
 
 <th style="text-align:center;vertical-align:bottom" rowspan="2"><b>TOTAL</b></th>
 
 
	</tr>
	
	<tr>
		
		<th style="text-align:center"><b>PHYSICAL</b></th>
		<th style="text-align:center"><b>ONLINE/<br /> TECHONOLY-MEDIATED <br />(SYNCHRONOUS)

		</b></th>
		
		
		
	</tr>
	
	
</thead>
	
	<?php 
	
	$assdirect = $version->courseAssessmentFormative;
	$assindirect= $version->courseAssessmentSummative;
	$slt = $version->slt;
	
	$arrFormAss = "";
	$i=1;
	$fom = 0;
	if($assdirect){
		
		foreach($assdirect as $rhead){
			$id = $rhead->id;

			$arrFormAss .= $i == 1 ? $id : "," . $id ;
			echo "<tr><td>".$rhead->assess_name ." / <i>".$rhead->assess_name_bi ."</i></td>
			<td align='center'>" . $rhead->as_percentage . "%</td>
			<td align='center'>
			" . $rhead->assess_f2f . "</td>
			
			<td align='center'>
			" . $rhead->assess_f2f_tech . "
			</td>
			
			<td align='center'>
			" . $rhead->assess_nf2f . "</td>";
			$sub = $rhead->assess_f2f + $rhead->assess_f2f_tech + $rhead->assess_nf2f;
			$fom += $sub;
			echo "<td align='center'><b>".$sub."</b></td>
			</tr>
			";
		$i++;
		}
	}
	
	
	
	?>
	

	
	<tr>
	<td> <strong>TOTAL CONTINUOUS</strong>
	</td>
		<td style="text-align:center" colspan="4"><strong id="form-total-ass"></strong></td>
		<td style="text-align:center"><strong id="form-total"><?=$fom?></strong></td>
	</tr>
	

	
</table></div>

<div class="table-responsive"><table class="table table-striped table-hover">
	

	
	<thead>
	<tr>
		<th rowspan="2" width="30%" style="vertical-align:bottom"><b>
		FINAL ASSESSMENT
		</b></th>
		<th rowspan="2" style="vertical-align:bottom"><b>
		PERCENTAGE
		</b></th>
		<th width="40%" colspan="2" style="text-align:center"><b>FACE-TO-FACE (F2F)</b></th>
		<th width="20%" style="text-align:center" rowspan="2"><b>NF2F <br />
		INDEPENDENT LEARNING FOR ASSESSMENT<br />
 (ASYNCHRONOUS)</b></th>
 
 <th style="text-align:center;vertical-align:bottom" rowspan="2"><b>TOTAL</b></th>
 
	</tr>
	
	<tr>
		
		<th style="text-align:center"><b>PHYSICAL</b></th>
		<th style="text-align:center"><b>ONLINE/<br /> TECHONOLY-MEDIATED <br />(SYNCHRONOUS)

		</b></th>
</thead>

	<?php 
	$arrSumAss = "";
	$sum = 0;
	if($assindirect){
		foreach($assindirect as $rhead){
			$id = $rhead->id;
			$arrSumAss .= $i == 1 ? $id : "," . $id ;
			echo "<tr><td>".$rhead->assess_name_bi ." / <i>".$rhead->assess_name_bi ."</i></td>
			<td align='center'>" . $rhead->as_percentage . "%</td>
			<td align='center'>".$rhead->assess_f2f ."</td>
			
			<td align='center'>".$rhead->assess_f2f_tech ."</td>
			
			
			<td align='center'>
			
			".$rhead->assess_nf2f ."
			
			</td>";
			$sub = $rhead->assess_f2f + $rhead->assess_f2f_tech + $rhead->assess_nf2f;
			$sum += $sub;
			
			echo "<td align='center'><b>".$sub."</b></td>
			</tr>
			";
			$i++;
		}
	}
	
	
	
	?>
	<tr>
	<td> <strong>TOTAL FINAL</strong>
	</td>
	
		<td style="text-align:center" colspan="4"><strong id="sum-total-ass"></strong></td>
		

		<td style="text-align:center"><strong id="sum-total"><?=$sum?></strong></td>
	</tr>
	
	
	<tr>
	<td colspan="5" align="right"><strong>SLT FOR ASSESSMENT</strong>
	</td>
		<td style="text-align:center"><strong id="jum-assess"><?php echo $fom + $sum ;?></strong></td>
	</tr>
	
	<tr><td colspan="5" align="right"><strong>GRAND TOTAL FOR SLT</strong>
	</td>
		<td style="text-align:center"><strong id="total-slt"><?php 
		$hours = $fom + $sum + $total;
		echo $hours ?></strong></td>
	</tr>
	

	
	<tr>
	<?php 
if($slt->is_practical == 1){
	$notation = 80;
}else{
	$notation = 40;
}

?>
	<td colspan="5" align="right"><strong>CREDIT HOUR BY SLT</strong><br /><i><?='['.$hours.' / '.$notation.']'?></i>
	<div id="slt-formula"></div>

	</td>
		<td style="text-align:center"><strong><span id="hour-slt"><?php 
		echo floor($hours / $notation);
		
		?></span></strong>
		
		
		</td>
	</tr>
	
	
	
	
</table></div>
<br /><br />

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tbody>
      <tr>
        <td width="20%"><b>REFERENCES</b></td>
        <td>
		
		<?php 
		
		
if($version->references){
	$i = 1;
	foreach($version->references as $row){
		echo  $i.'. ' . $row->formatedReference.'<br />';
	$i++;
	}
}
		
		
		
		?>
		
		</td>
      </tr>
	    
</tbody>
</table>
</div>



</div>
</div>


