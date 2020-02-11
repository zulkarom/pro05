<?php

namespace backend\modules\esiap\models;

use Yii;


/**
 * Class Menu
 * Theme menu widget.
 */
class Stats
{
	public static function countOfferedProgram(){
		$kira = Program::find()
		->where(['faculty_id' => Yii::$app->params['faculty_id'], 'status' => 1, 'trash' => 0])
		->count();
		return $kira;
	}
	
	public static function countUDProgram(){
		$kira = Program::find()
		->where(['faculty_id' => Yii::$app->params['faculty_id'], 'status' => 0, 'trash' => 0])
		->count();
		return $kira;
	}
	
	public static function countPublishedCourses(){
		$kira = Course::find()
		->joinWith(['courseVersion'])
		->where(['faculty_id' => Yii::$app->params['faculty_id'], 'is_active' => 1, 'is_published' => 1])
		->count();
		return $kira;
	}
	
	public static function countUDCourses(){
		$kira = Course::find()
		->joinWith(['courseVersion'])
		->where(['faculty_id' => Yii::$app->params['faculty_id'], 'is_active' => 1, 'is_developed' => 1])
		->count();
		return $kira;
	}
	
	public static function countUDStatus($status){
		$kira = Course::find()
		->joinWith(['courseVersion'])
		->where(['faculty_id' => Yii::$app->params['faculty_id'], 'is_active' => 1, 'is_developed' => 1, 'status' => $status])
		->count();
		return $kira;
	}
	
	public static function courseByProgram(){
		return Course::find()
		->select('sp_program.id, sp_program.pro_name as course_label, COUNT(sp_course.program_id) as course_data')
		->joinWith(['program'])
		->where(['sp_course.faculty_id' => Yii::$app->params['faculty_id'], 'is_active' => 1])
		->groupBy('sp_course.program_id')
		->all();
		
	}

}
