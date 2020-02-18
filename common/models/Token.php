<?php 

namespace common\models;

use backend\models\Semester;
use backend\modules\project\models\Project;

class Token {
	
	public function generateKey($length = 6) {
		$characters = '01DF234SDGSDF56789ABCDEFG489HIJKLMN3OPQR433STUVWXKDFGYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	public static function projectKey(){
		$semester = Semester::getCurrentSemester();
		$characters = '01DF234SDGSDF56789ABCDEFG489HIJKLMN3OPQR433STUVWXKDFGYZ';
		$charactersLength = strlen($characters);
		$key = '';
		for ($i = 0; $i < 6; $i++) {
			$key .= $characters[rand(0, $charactersLength - 1)];
		}
		$project = Project::findOne(['pro_token' => $key, 'semester_id' => $semester->id]);
		if($project){
			return $this->projectKey();
		}else{
			return $key;
		}
	}
	
	
}