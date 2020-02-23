<?php

namespace backend\models;

use Yii;


class Api
{
	public $semester;
	public $subject;
	public $group;
	public $id;
	public $portal = 'https://portal.umk.edu.my/api/timetable/';
	public $url;
	
	
	public function student(){
		$this->url = $this->portal . 'student?' . $this->getParams();
		$json = $this->getContent();
		return json_decode($json);
	}
	
	public function attendList(){
		$this->url = $this->portal . 'list?' . $this->getParams();
		$json = $this->getContent();
		$obj = json_decode($json);
		return $obj;
	}
	
	public function attend(){
		$this->url = $this->portal . 'attend?' . $this->getParams($this->id);
		$json = $this->getContent();
		$obj = json_decode($json);
		return $obj;
	}
	
	public function summary(){
		$obj = new \stdClass;
		$student_list = $this->student();
		$obj->student = $student_list;
		$list = $this->attendList();
		$obj->colums = $list;
		$attend = new \stdClass;
		
		$attendArray = [];
		if($list){
			if($list->result){
				foreach($list->result as $row){
					$obj_row = new \stdClass;
					$obj_row->date = $row->date;
					//$obj_row->id = $row->id;
					$this->id = $row->id;
					$result_attend = $this->attend();
					$array_students = [];
					if($student_list){
						if($student_list->result){
							foreach($student_list->result as $s){
								$stud = new \stdClass;
								//$stud->student_id = $s->id;
								$attend = '';
								if(strtotime($row->date) <= time()){
									if($result_attend){
										if($result_attend->result){
											foreach($result_attend->result as $r){
												if($r->id == $s->id){
													$attend = $r->status;
													break;
												}
											}
										}
									}
								}
								
								$stud->status = $attend;
								$array_students[$s->id] = $stud;
								
							}
						}
					}
					$obj_row->students = $array_students;
					$attendArray[$row->id] = $obj_row;
				}
			}
		}
		$obj->attend = $attendArray;
		return $obj;
	}
	
	public function getClassDate($id){
		$response = $this->attendList();
		if($response){
			if($response->result){
				foreach($response->result as $row){
					if($row->id == $id){
						return $row->date;
						break;
					}
				}
			}
		}
		
	}
	
	public function getParams($id = null){
		$url = 'semester='. $this->semester .'&subject='.$this->subject.'&group='.$this->group;
		if($id){
			$url .= '&id=' . $id;
		}
		return $url;
	}
	
	public function getContent(){
		return file_get_contents($this->url);
	}
	
	public function getContentX(){
		set_error_handler(
			function ($severity, $message, $file, $line) {
				throw new \ErrorException($message, $severity, $severity, $file, $line);
			}
		);

		try {
			return file_get_contents($this->url);
		}
		catch (\Exception $e) {
			echo $e->getMessage();die();
		}

		restore_error_handler();
	}
	
	public function curlResponse(){
		$curl = curl_init($this->url);
		//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		//'curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
		//curl_setopt($curl, CURLOPT_POST, true);
		//curl_setopt($curl, CURLOPT_POSTFIELDS, 'cari=' . $search . '&ty=' . $this->ty . '&hdnCounter='. $this->counter .'&a=&t=');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($curl, CURLOPT_URL, "http://www.halal.gov.my/v4/index.php");
		/* curl_setopt($curl, CURLOPT_REFERER, "http://www.halal.gov.my/v4/index.php?data=ZGlyZWN0b3J5L2luZGV4X2RpcmVjdG9yeTs7Ozs=");
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201');*/
		$response = curl_exec($curl); 
		curl_close($curl);
		
		return $response;
	}
	
}
