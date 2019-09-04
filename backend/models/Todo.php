<?php

/**
 *  this class specifically create to temporarily handle Yii::$app->user->can() problem
 * since Yii::$app->authManager->getRolesByUser($id) is ok, we make use of this function to copy the function of Yii::$app->user->can()
 */

namespace backend\models;

use Yii;

class Todo
{
	public static function can($access){
		$id = Yii::$app->user->identity->id;
		$roles = Yii::$app->authManager->getRolesByUser($id);
		foreach($roles as $r){
			if($r->name == $access){
				return true;
			}
		}
		return false;
	}

}