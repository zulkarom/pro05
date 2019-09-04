<?php

namespace common\models;

use Yii;
use frontend\models\FasiExpe;
use frontend\models\FasiEdu;
use frontend\models\FasiFile;
use common\models\Common;

/**
 * This is the model class for table "fasi".
 *
 * @property int $id
 * @property int $user_id
 * @property int $gender
 * @property string $address_postal
 * @property string $address_home
 * @property string $birth_date
 * @property string $birth_place
 * @property string $nric
 * @property string $citizen
 * @property int $marital_status
 * @property string $handphone
 * @property string $distance_umk
 * @property string $position_work
 * @property string $position_grade
 * @property string $department
 * @property string $salary_grade
 * @property string $salary_basic
 * @property string $address_office
 * @property string $office_phone
 * @property string $office_fax
 * @property int $in_study
 * @property int $umk_staff
 */
class Fasi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $fullname;
	public $profile_instance;
	public $nric_instance;
	public $salary_instance;
	public $path_instance;
	public $file_controller;
	
    public static function tableName()
    {
        return 'fasi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			
			[['user_id', 'nric'], 'required', 'on' => 'signup'],
			
			[['gender', 'address_postal', 'address_home', 'birth_date', 'birth_place', 'nric', 'citizen', 'marital_status', 'handphone', 'distance_umk', 'personal_updated_at'], 'required', 'on' => 'profile_personal'],
			
			[['umk_staff' ,'position_work','position_grade','department', 'salary_basic', 'address_office', 'office_phone','office_fax','in_study', 'job_updated_at', 'staff_no'], 'required', 'on' => 'profile_job'],
			
			[['expe_updated_at'], 'required', 'on' => 'profile_expe'],
			
			[['edu_updated_at'], 'required', 'on' => 'profile_edu'],
			
			//profile upload///
			[['profile_file', 'document_updated_at'], 'required', 'on' => 'profile_upload'],
			[['profile_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif', 'maxSize' => 2000000],
			[['updated_at'], 'required', 'on' => 'profile_delete'],
			
			//nric upload///
			[['nric_file'], 'required', 'on' => 'nric_upload'],
			[['nric_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, png, jpg, gif', 'maxSize' => 2000000],
			[['updated_at'], 'required', 'on' => 'nric_delete'],
			
			//nric upload///
			[['salary_file'], 'required', 'on' => 'salary_upload'],
			[['salary_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, png, jpg, gif', 'maxSize' => 2000000],
			[['updated_at'], 'required', 'on' => 'salary_delete'],
			
			//path upload///
			[['path_file'], 'required', 'on' => 'path_upload'],
			[['path_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif', 'maxSize' => 2000000],
			[['updated_at'], 'required', 'on' => 'path_delete'],
			

			
			//[['salary_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, png, jpg, gif'],
			
			
            [['user_id', 'in_study', 'umk_staff'], 'integer'],
			
			[['marital_status'], 'integer', 'min' => 1],
			
            [['birth_date'], 'safe'],
			
            [['salary_basic'], 'number'],
			
            [['address_postal', 'address_home', 'address_office'], 'string', 'max' => 200],
			
            [['birth_place', 'citizen', 'position_work'], 'string', 'max' => 100],
			
            [['handphone', 'office_phone', 'office_fax'], 'string', 'max' => 20],
			
            [['position_grade', 'department', 'salary_grade'], 'string', 'max' => 50],
			
			[['distance_umk'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
			'fullname' => 'Nama Penuh',
			'gender' => 'Jantina',
			'genderName' => 'Jantina',
            'address_postal' => 'Alamat Surat Menyurat',
            'address_home' => 'Alamat Rumah',
            'birth_date' => 'Tarikh Lahir',
            'birth_place' => 'Tempat Lahir',
            'nric' => 'No.Kad Pengenalan',
            'citizen' => 'Warganegara',
			'citizenName' => 'Warganegara',
            'marital_status' => 'Status Perkahwinan',
			'marital' => 'Status Perkahwinan',
            'handphone' => 'Handphone',
            'distance_umk' => 'Jarak Dari Umk',
            'position_work' => 'Nama Jawatan',
            'position_grade' => 'Gred Jawatan',
            'department' => 'Jabatan',
            'salary_grade' => 'Gred Gaji',
            'salary_basic' => 'Gaji Pokok',
            'address_office' => 'Alamat Pejabat',
            'office_phone' => 'Office Phone',
            'office_fax' => 'Office Fax',
            'in_study' => 'Adakah anda sedang dalam pengajian diploma atau ijazah/sarjana muda?',
			'inStudy' => 'Adakah anda sedang dalam pengajian diploma atau ijazah/sarjana muda?',
            'umk_staff' => 'Adakah anda staff UMK?',
			'umkStaff' => 'Adakah anda staff UMK?',
			'nric_file' => 'Muat Naik Salinan Kad Pengenalan',
			'salary_file' => 'Muat Naik Slip Gaji',
			'profile_file' => 'Muat Naik Gambar',
			'staff_no' => 'No. Pekerja',
			
        ];
    }
	
	public function getUser(){
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}

	
	public function getFasiExpes()
    {
        return $this->hasMany(FasiExpe::className(), ['fasi_id' => 'id']);
    }
	
	public function getFasiEdus()
    {
        return $this->hasMany(FasiEdu::className(), ['fasi_id' => 'id']);
    }
	
	public function getFasiFiles()
    {
        return $this->hasMany(FasiFile::className(), ['fasi_id' => 'id']);
    }
	
	public function getGenderName(){
		return Common::gender()[$this->gender];
	}
	
	public function getMarital(){
		if($this->marital_status > 0){
			return Common::marital()[$this->marital_status];
		}else{
			return '';
		}
		
	}
	
	public function getHighestEdu(){
		return FasiEdu::find()
		->select('fasi_edu.*')
		->where(['fasi_id' => $this->id])
		->innerJoin('education_level', 'education_level.id = fasi_edu.level')
		->orderBy('education_level.level DESC')
		->limit(1)
		->one();
	}
	
	public function getCitizenName(){
		if($this->citizen > 0){
			return Common::citizen()[$this->citizen];
		}else{
			return '';
		}
		
	}
	
	public function getInStudy(){
		return Common::yesNo()[$this->in_study];
	}
	
	public function getUmkStaff(){
		return Common::yesNo()[$this->umk_staff];
	}
	
	public function dateTimeZero($field){
		if($this->{$field} == '0000-00-00 00:00:00'){
			return true;
		}else{
			return false;
		}
	}
	
	public function moreOneDay($field){
		$day = 60 * 60 * 24;
		if(time() - strtotime($this->{$field}) > $day){
			return true;
		}else{
			return false;
		}
	}
	
	
	public function updatedProfile($field){

		if($this->dateTimeZero($field)){
				return 'not-complete';
			}
		
		if($this->moreOneDay($field)){
			return 'not-updated';
		}
		return 'updated';
	}
	
	public function updatedDocument(){
		//check gambar & nric
		if(!($this->profile_file && $this->nric_file)){
			return 'not-complete';;
		}
		
		if($this->fasiFiles){
			foreach($this->fasiFiles as $f){
				if(!$f->path_file){
					return 'not-complete';
				}
			}
		}else{
			return 'not-complete';
		}
		//ada sijil
		
		return $this->updatedProfile('document_updated_at');
		
	}
	
	public function updatedList($field, $list){
		if(!$this->{$list}){
			return 'not-complete';
		}
		return $this->updatedProfile($field);
	}
	
	public function profileStatus($field){
		$status = $this->updatedProfile($field);
		return $this->labelStatus($status);

	}
	
	
	
	
	public function documentStatus(){
		$status = $this->updatedDocument();
		return $this->labelStatus($status);
	}
	
	public function listStatus($field, $list){
		$status = $this->updatedList($field, $list);
		return $this->labelStatus($status);
	}
	
	public function labelStatus($status){
		switch($status){
			case 'updated':
				return '<span class="label label-success">Telah Kemaskini</span>';
			break;
			case 'not-updated':
				return '<span class="label label-warning">Tidak Kemaskini</span>';
			break;
			case 'not-complete':
				return '<span class="label label-danger">Tidak Lengkap</span>';
			break;
		}
	}
	
	public function checkCompleted(){
		$profile = $this->updatedProfile('personal_updated_at');
		if($profile == 'not-complete'){
			return false;
		}
		$job = $this->updatedProfile('job_updated_at');
		if($profile == 'not-complete'){
			return false;
		}
		$edu = $this->updatedList('edu_updated_at', 'fasiEdus');
		if($edu == 'not-complete'){
			return false;
		}
		$expe = $this->updatedList('expe_updated_at', 'fasiExpes');
		if($expe == 'not-complete'){
			return false;
		}
		$doc = $this->updatedDocument();
		if($doc == 'not-complete'){
			return false;
		}
		
		return true;
	}
	
	public function checkUpdated(){
		$profile = $this->updatedProfile('personal_updated_at');
		if($profile != 'updated'){
			return false;
		}
		$job = $this->updatedProfile('job_updated_at');
		if($profile != 'updated'){
			return false;
		}
		$edu = $this->updatedList('edu_updated_at', 'fasiEdus');
		if($edu != 'updated'){
			return false;
		}
		$expe = $this->updatedList('expe_updated_at', 'fasiExpes');
		
		if($expe != 'updated'){
			return false;
		}
		$doc = $this->updatedDocument();
		if($doc != 'updated'){
			return false;
		}
		
		return true;
	}
	


}
