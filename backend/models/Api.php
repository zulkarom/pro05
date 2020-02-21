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
		
	}
	
	public function attendance(){
		
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
