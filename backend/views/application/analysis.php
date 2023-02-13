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
?>
<?= $this->render('../semester/_semester_select', [
        'model' => $semester,
    ]) ?>
<?php
$campus = Campus::find()->all();
if($campus ){
	foreach($campus  as $cam){
		echo '
		<h3>' . $cam->campus_name . '</h3>
		
		<div class="box box-primary">
<div class="box-body">

';
		$courses = Course::find()->where(['campus_' . $cam->id => 1])->all();
		if($courses){
			echo '<table class="table table-striped">
			<thead>
			<tr>
				<th width="25%">Courses</th>
				<th>Application</th>
			
			
			</tr>
			</thead>
			';
			foreach($courses as $c){
				$app = Application::find()
				->select(['application.*'])
				->innerJoin('application_course', 'application_course.application_id = application.id')
				->where(['semester_id' => $semester->semester_id, 'campus_id' => $cam->id, 'course_id' => $c->id])
				->all();
				$fasi = '';
				
				if($app){
					$fasi = '<table>';
					foreach($app as $f){
						$fasi .='<tr>';
							$fasi .= '<td width="50%">' . strtoupper($f->fasi->user->fullname) . '</td>';
							
							$fasi .= '<td width="20%">' . $f->fasiType->type_name . '</td>';
							
							$group = '';
							$status = '';
						
						if($f->applicationCourses){
							foreach($f->applicationCourses as $k){
								if($k->course_id == $c->id && $k->is_accepted == 1){
									$group = $f->groupName;
									$status = $f->getWfLabel();
								}
							}
						}
						$fasi .= '<td width="20%">'.$group.'</td>';
						$fasi .= '<td width="20%">'.$status.'</td>';
						$fasi .= '<td><a href="'.Url::to(['application/view', 'id' => $f->id]).'" class="btn btn-primary btn-sm" style="margin-bottom:5px"><span class="glyphicon glyphicon-search"></span> VIEW</a></td>';
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
		
		echo '</div>
</div>';
	}
}

?>