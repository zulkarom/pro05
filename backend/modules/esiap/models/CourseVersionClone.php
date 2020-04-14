<?php 

namespace backend\modules\esiap\models;

use Yii;
use yii\db\Expression;


class CourseVersionClone
{
	public $ori_version;
	public $copy_version;
	
	public function cloneVersion(){
		$components = ['profile', 'assessment', 'clo', 'syllabus', 'slt', 'reference', 'transferable', 'staff'];
		$flag = true;
		foreach($components as $component){
			if ($flag === false) {
				break;
			}
			if(!($flag = $this->$component())){
				break;
			}
		}
		
		return $flag;
	}
	
	public function profile(){
		$original = CourseProfile::findOne(
		['crs_version_id' => $this->ori_version]);
		if($original){
			$copy = new CourseProfile();
			$copy->attributes = $original->attributes;
			$copy->crs_version_id = $this->copy_version;
			$copy->created_at = new Expression('NOW()');
			$copy->updated_at = new Expression('NOW()');
			if($copy->save()){
			  return true;
			}else{
				$copy->flashError();
				return false;
			}
		}else{
			return true;
		}
		

	}
	
	public function slt(){
		$original = CourseSlt::findOne(
		['crs_version_id' => $this->ori_version]);
		if($original){
			$copy = new CourseSlt();
			$copy->attributes = $original->attributes;
			$copy->crs_version_id = $this->copy_version;
			if($copy->save()){
			  return true;
			}else{
				$copy->flashError();
				return false;
			}
		}else{
			return true;
		}
		

	}
	
	public function syllabus(){
		
		$originals = CourseSyllabus::find()->where(['crs_version_id' => $this->ori_version])->orderBy('syl_order ASC, id ASC')->all();
		$flag = true;
		if($originals){
			$i = 0;
			foreach($originals as $original){
				if ($flag === false) {
					break;
				}
				$copy = new CourseSyllabus();
				$copy->attributes = $original->attributes;
				$copy->crs_version_id = $this->copy_version;
				$copy->created_at = new Expression('NOW()');
				$copy->updated_at = new Expression('NOW()');
				$copy->syl_order = $i;
				if(!($flag = $copy->save())){
					$copy->flashError();
					break;
				}else{

				}
			$i++;
			}
		}
		
		return $flag;
		
	}
	
	public function reference(){
		$originals = CourseReference::find()->where(['crs_version_id' => $this->ori_version])->all();
		$flag = true;
		if($originals){
			foreach($originals as $original){
				if ($flag === false) {
					break;
				}
				$copy = new CourseReference();
				$copy->attributes = $original->attributes;
				$copy->crs_version_id = $this->copy_version;
				if(!($flag = $copy->save())){
					$copy->flashError();
					break;
				}else{

				}
			}
		}
		
		return $flag;
		
	}
	
	public function assessment(){
		$originals = CourseAssessment::find()->where(['crs_version_id' => $this->ori_version])->all();
		$flag = true;
		if($originals){
			foreach($originals as $original){
				if ($flag === false) {
					break;
				}
				$copy = new CourseAssessment();
				$copy->attributes = $original->attributes;
				$copy->crs_version_id = $this->copy_version;
				$copy->created_at = new Expression('NOW()');
				$copy->updated_at = new Expression('NOW()');
				if(!($flag = $copy->save())){
					$copy->flashError();
					break;
				}else{

				}
			}
		}
		
		return $flag;
		
	}
	
	public function clo(){
		$originals = CourseClo::find()->where(['crs_version_id' => $this->ori_version])->all();
		$flag = true;
		if($originals){
			foreach($originals as $original){
				if ($flag === false) {
					break;
				}
				$copy = new CourseClo();
				$copy->attributes = $original->attributes;
				$copy->crs_version_id = $this->copy_version;
				$copy->created_at = new Expression('NOW()');
				$copy->updated_at = new Expression('NOW()');
				if(!($flag = $copy->save())){
					$copy->flashError();
					break;
				}else{
					if(!($flag = $this->cloAssessment($original->id, $copy->id))){
						break;
					}
					
					if(!($flag = $this->cloDelivery($original->id, $copy->id))){
						break;
					}
				}
			}
		}
		
		return $flag;
	}
	
	
	
	public function cloAssessment($clo_id_old, $clo_id_new){
		$originals = CourseCloAssessment::find()->where(['clo_id' => $clo_id_old])->all();
		$flag = true;
		if($originals){
			foreach($originals as $original){
				if ($flag === false) {
					break;
				}
				$copy = new CourseCloAssessment();
				$copy->attributes = $original->attributes;
				$copy->clo_id = $clo_id_new;
				
				//kena update assess_id lama ke baru
				$old_assess = $original->assess_id;
				if($old_name = CourseAssessment::findOne($old_assess)){
					$old_name = CourseAssessment::findOne($old_assess)->assess_name;
					//Yii::$app->session->addFlash('success', $old_name .'---'. $this->copy_version);
					$new_assess = CourseAssessment::findOne(['assess_name' => $old_name, 'crs_version_id' => $this->copy_version]);
					if($new_assess){
						
						$copy->assess_id = $new_assess->id;
					}
				}
				
				
				
				
				if(!($flag = $copy->save())){
					$copy->flashError();
					break;
				}
				
				
			}
			
			
		}
		
		return $flag;
		
		
	}
	
	public function cloDelivery($clo_id_old, $clo_id_new){
		$originals = CourseCloDelivery::find()->where(['clo_id' => $clo_id_old])->all();
		$flag = true;
		if($originals){
			foreach($originals as $original){
				if ($flag === false) {
					break;
				}
				$copy = new CourseCloDelivery();
				$copy->attributes = $original->attributes;
				$copy->clo_id = $clo_id_new;
				if(!($flag = $copy->save())){
					$copy->flashError();
					break;
				}
			}
		}
		
		return $flag;
		
		
	}
	
	public function transferable(){
		$originals = CourseTransferable::find()->where(['crs_version_id' => $this->ori_version])->all();
		$flag = true;
		if($originals){
			foreach($originals as $original){
				if ($flag === false) {
					break;
				}
				$copy = new CourseTransferable();
				$copy->attributes = $original->attributes;
				$copy->crs_version_id = $this->copy_version;
				if(!($flag = $copy->save())){
					$copy->flashError();
					break;
				}else{

				}
			}
		}
		
		return $flag;
		
	}
	
	public function staff(){
		$originals = CourseStaff::find()->where(['crs_version_id' => $this->ori_version])->all();
		$flag = true;
		if($originals){
			foreach($originals as $original){
				if ($flag === false) {
					break;
				}
				$copy = new CourseStaff();
				$copy->attributes = $original->attributes;
				$copy->crs_version_id = $this->copy_version;
				if(!($flag = $copy->save())){
					$copy->flashError();
					break;
				}else{

				}
			}
		}
		
		return $flag;
		
	}
	
}



