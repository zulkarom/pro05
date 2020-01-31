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
}
