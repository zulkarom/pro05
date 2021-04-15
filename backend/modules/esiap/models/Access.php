<?php

namespace backend\modules\esiap\models;

use Yii;
use yii\base\Model;
use backend\modules\staff\models\StaffMainPosition;
use backend\models\Department;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class Access extends Model
{
	public static function ICanVerify(){
		$staff = Yii::$app->user->identity->staff->id;
		if(StaffMainPosition::findOne(['staff_id' => $staff])){
			return true;
		}
		if(Department::findOne(['head_dep' => $staff])){
			return true;
		}
		return false;
	}
	
	public static function IAmProgramCoordinator(){
		$staff = Yii::$app->user->identity->staff->id;
		if(Program::findOne(['head_program' => $staff])){
			return true;
		}
		return false;
	}

}
