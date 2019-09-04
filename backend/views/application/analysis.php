<?php 

use yii\helpers\Url;
use backend\models\Campus;
use backend\models\Course;
use backend\models\Semester;
use common\models\Application;
use common\models\ApplicationGroup;
use common\models\ApplicationCourse;

$this->title = 'ANALISIS PERMOHONAN';
$this->params['breadcrumbs'][] = $this->title;
$curr_sem = Semester::getCurrentSemester();
echo $curr_sem->id;
?>
<h4>Semester <?=$curr_sem->niceFormat()?></h4>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><?php
$campus = Campus::find()->all();
if($campus ){
	foreach($campus  as $cam){
		echo '<br /><h3>' . $cam->campus_name . '</h3>';
		$courses = Course::find()->where(['campus_' . $cam->id => 1])->all();
		if($courses){
			echo '<table class="table table-striped">
			<thead>
			<tr>
				<th width="20%">Courses</th>
				<th>Application</th>
			
			
			</tr>
			</thead>
			';
			foreach($courses as $c){
				$app = Application::find()
				->select(['application.*'])
				->innerJoin('application_course', 'application_course.application_id = application.id')
				->where(['semester_id' => $curr_sem->id, 'campus_id' => $cam->id, 'course_id' => $c->id])
				->all();
				$fasi = '';
				
				if($app){
					$fasi = '<table class="table table-striped">';
					foreach($app as $f){
						$fasi .='<tr>';
							$fasi .= '<td width="50%">' . strtoupper($f->fasi->user->fullname) . '</td>';
							
							$fasi .= '<td width="20%">' . $f->fasiType->type_name . '</td>';
							
							$group = '';
							$status = '';
						
						if($f->applicationCourses){
							foreach($f->applicationCourses as $k){
								if($k->course_id == $c->id && $k->is_accepted == 1){
									$group = $f->applicationGroup->group_name;
									$status = $f->getWfLabel();
								}
							}
						}
						$fasi .= '<td width="20%">'.$group.'</td>';
						$fasi .= '<td width="20%">'.$status.'</td>';
						$fasi .= '<td><a href="'.Url::to(['application/view', 'id' => $f->id]).'" class="btn btn-default btn-sm">VIEW</a></td>';
					$fasi .= '</tr>';
					}
					$fasi .='</table>';
					
				}
				echo '<tr>';
				echo '<td style="text-align:center;vertical-align:middle"><b>' . $c->course_code .'<br />'. strtoupper($c->course_name) . '</b></td><td>'.$fasi.'</td>
				';
				echo '</tr>';
			}
			echo '</table>';
		}
	}
}

?></div>
</div>