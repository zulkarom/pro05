<?php 
use common\models\ApplicationGroup;
use backend\modules\esiap\models\CoursePic;
use backend\models\Stats;
use yii\helpers\Url;

$coor = CoursePic::find()->where(['staff_id' => Yii::$app->user->identity->staff->id])->all();
		
if($coor){
?>
<div class="box box-primary">
<div class="box-header">
	<div class="box-title">KETUA TERAS: SEMESTER <?=strtoupper($semester->niceFormat())?></div>
</div>
<div class="box-body ">


<div class="table-responsive">
  <table class="table table-striped table-hover">
  <thead>
  <tr>
  <th>#</th>
  <th>Kod Kursus</th>
  <th>Nama Kursus</th>
  <th>Fasilitator</th>
  <th>Helaian Kehadiran</th>
  <th>Kehadiran (QR Code)</th>
  <th>Template Markah</th>
  <th></th>
  <tr>
  </thead>
    <tbody>
	
	<?php 
	$i = 1;
	$arr_groups = ApplicationGroup::find()->all();
foreach($coor as $c){
	
	$groups = Stats::getMyCoorGroups($c->course_id, $semester->id);
	$str_fasi ='';
	$str_kehadiran = '';
	$str_qr = '';
	$str_mark = '';
	if($groups){
		$x = 1;
		foreach($groups as $g){
			$br = $x == 1 ? '':'<br />';
			$str_fasi .= $br.strtoupper($g['fasiname']) . ' ('.$g['group'].')';
			
			$str_kehadiran .= '<li><a target="_blank" href="'. Url::to(['/student/attendance-sheet-admin-pdf/', 'course' => $c->course->course_code, 'semester' => $semester->id, 'group' => $g['group']]) . '">'.$g['group'].'</a> </li>';
			
			$str_qr .= '<li><a target="_blank" href="'. Url::to(['/student/attendance-summary-admin-pdf/', 'course' => $c->course->course_code, 'semester' => $semester->id, 'group' => $g['group']]) . '">'.$g['group'].'</a> </li>';
			
			$str_mark .= '<li><a target="_blank" href="'. Url::to(['/student/mark-template-admin-excel/', 'course' => $c->course->course_code, 'semester' => $semester->id, 'group' => $g['group']]) . '">'.$g['group'].'</a> </li>';
			
			
		$x++;
		}
		
	}else{
		foreach($arr_groups as $ag){
			  $str_kehadiran .= '<li><a href="'. Url::to(['/student/attendance-sheet-admin-pdf/', 'course' => $c->course->course_code, 'semester' => $semester->id, 'group' => $g['group']]) . '" target="_blank">'.$ag->group_name.'</a></li>';
			  $str_qr .= '<li><a target="_blank" href="'. Url::to(['/student/attendance-summary-admin-pdf/', 'course' => $c->course->course_code, 'semester' => $semester->id, 'group' => $g['group']]) . '">'.$g['group'].'</a> </li>';
			  $str_mark .= '<li><a target="_blank" href="'. Url::to(['/student/mark-template-admin-excel/', 'course' => $c->course->course_code, 'semester' => $semester->id, 'group' => $g['group']]) . '">'.$g['group'].'</a> </li>';
		  }
	}
	
	?>
<tr>
  <td><?=$i?></td>
  <td><?=$c->course->course_code?></td>
  <td><?=$c->course->course_name?></td>
  <td><?=$str_fasi?></td>
  <td>

  <div class="dropdown">
  <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Select Group
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
   <?=$str_kehadiran?>
  </ul>
</div>
  
  </td>
  <td>
  
  
  <div class="dropdown">
  <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Select Group
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
  <?=$str_qr ?>
  </ul>
</div>

  
  </td>
  <td>
  
<div class="dropdown">
  <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Select Group
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
  <?=$str_mark ?>
  </ul>
</div>
  
  
  </td>
  
  
  <td><a href="<?=Url::to(['/esiap/course/update/', 'course' => $c->course_id])?>" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-pencil"></span> Kemaskini</a>
  
  
</td>
  <tr>
	<?php
	$i++;
}
	
	?>
      
	  
    </tbody>
  </table>
  <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>

</div>
</div>
<?php
}
?>