<?php

namespace backend\models;

use Yii;
use common\models\Application;
use common\models\Claim;

class Stats
{
	public $sum_all;
	
	public static function countAllCurrentFasilitator(){
		$sem = Semester::getCurrentSemester()->id;
		return Application::find()->where(['status' => 'ApplicationWorkflow/f-accept', 'semester_id' => $sem])->count();
	}
	
	public static function countAllFasilitator($sem){
		return Application::find()->where(['status' => 'ApplicationWorkflow/f-accept', 'semester_id' => $sem])->count();
	}
	
	public static function countCurrentFasilitatorByCampus($campus){
		$sem = Semester::getCurrentSemester()->id;
		return Application::find()->where(['status' => 'ApplicationWorkflow/f-accept', 'semester_id' => $sem, 'campus_id' => $campus])->count();
	}
	
	public static function countFasilitatorByCampus($sem, $campus){
		return Application::find()->where(['status' => 'ApplicationWorkflow/f-accept', 'semester_id' => $sem, 'campus_id' => $campus])->count();
	}
	
	public static function sumClaimCurrentSemester(){
		$sem = Semester::getCurrentSemester()->id;
		return Claim::find()
        ->select('SUM(claim.total_hour * claim.rate_amount) as sum_all')
		->innerJoin('application', 'application.id = claim.application_id')
        ->where(['application.semester_id' => $sem, 'claim.status' => 'ClaimWorkflow/bb-submit'])
        ->one();

	}
	public static function sumClaimSemester($sem){
		return Claim::find()
        ->select('SUM(claim.total_hour * claim.rate_amount) as sum_all')
		->innerJoin('application', 'application.id = claim.application_id')
        ->where(['application.semester_id' => $sem, 'claim.status' => 'ClaimWorkflow/bb-submit'])
        ->one();

	}
	public static function sumClaimSemesterByCampus($sem, $campus){
		$claim = Claim::find()
        ->select('SUM(claim.total_hour * claim.rate_amount) as sum_all')
		->innerJoin('application', 'application.id = claim.application_id')
        ->where(['application.semester_id' => $sem,  'claim.status' => 'ClaimWorkflow/bb-submit', 'application.campus_id' => $campus])
        ->one()->sum_all;
		
		if($claim){
			return $claim;
		}else{
			return 0;
		}

	}
	
	public static function getMyCoorGroups($course, $semester){
		return (new \yii\db\Query())
		->select('g.group_name as group, u.fullname as fasiname')
		->from('sp_course_pic pic')
		->innerJoin('application_course ac','ac.course_id = pic.course_id')
		->innerJoin('application a','ac.application_id = a.id')
		->innerJoin('application_group g','g.id = a.group_id')
		->innerJoin('fasi f', 'f.id = a.fasi_id')
		->innerJoin('user u', 'u.id = f.user_id')
		->where([
			'ac.course_id' => $course, 
			'ac.is_accepted' => 1, 
			'a.semester_id' => $semester, 
			'a.status' => 'ApplicationWorkflow/f-accept', 
			'pic.staff_id' => Yii::$app->user->identity->staff->id
			])
		->orderBy('g.group_name ASC')
		->all();
	}
}
