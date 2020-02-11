<?php

namespace backend\modules\staff\models;

use Yii;
use common\models\User;
use yii\helpers\ArrayHelper;
use backend\modules\erpd\models\Stats as ErpdStats;
use backend\modules\teachingLoad\models\TaughtCourse;
use backend\modules\teachingLoad\models\TeachCourse;
use backend\modules\teachingLoad\models\OutCourse;
use backend\modules\teachingLoad\models\PastExperience;
use common\models\Country;

/**
 * This is the model class for table "staff".
 *
 * @property int $id
 * @property int $user_id
 * @property string $staff_no
 * @property string $staff_name
 * @property string $staff_title
 * @property string $staff_edu
 * @property int $is_academic
 * @property int $position_id
 * @property int $position_status
 * @property int $working_status
 * @property string $leave_start
 * @property string $leave_end
 * @property string $leave_note
 * @property string $rotation_post
 * @property string $staff_expertise
 * @property string $staff_gscholar
 * @property string $officephone
 * @property string $handphone1
 * @property string $handphone2
 * @property string $staff_ic
 * @property string $staff_dob
 * @property string $date_begin_umk
 * @property string $date_begin_service
 * @property string $staff_note
 * @property string $personal_email
 * @property string $ofis_location
 * @property string $staff_cv
 * @property string $image_file
 * @property string $staff_interest
 * @property int $staff_department
 * @property int $publish
 * @property int $staff_active
 */
class Staff extends \yii\db\ActiveRecord
{
	public $staff_name;
	public $email;
	public $staffid;
	public $fullname;
	public $stitle;
	
	public $image_instance;
	public $file_controller;
	
	public $count_staff;
	public $position_name;
	public $staff_label;

	
    /**
     * @inheritdoc
     */
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
			


        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
         
            'user_token' => 'User Token',
            'user_token_at' => 'User Token At',
			'hq_specialization' => 'Specialization',
			'hq_institution' => 'Awarding Institution',
			'hq_country' => 'Country',
        ];
    }
	
	public function getNiceName(){
		return strtoupper($this->user->fullname);
	}
	
	
	
	public function getUser(){
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}
	
	public function flashError(){
        if($this->getErrors()){
            foreach($this->getErrors() as $error){
                if($error){
                    foreach($error as $e){
                        Yii::$app->session->addFlash('error', $e);
                    }
                }
            }
        }

    }
	
	

	public static function listAcademicStaffArray(){
		$list = self::find()
		->select('fasi.id as staffid, user.fullname as fullname')
		->joinWith('user')
		->orderBy('user.fullname ASC')->all();
		
		$array = [];
		
		foreach($list as $item){
			$array[$item->staffid] = strtoupper($item->fullname);
		}
		
		return $array;
		
	}
	
	public static function activeStaff(){
		return self::find()
		->select('fasi.id, user.fullname as staff_name, user.id as user_id')
		->innerJoin('user', 'user.id = fasi.user_id')
		->orderBy('user.fullname ASC')
		->all();
	}
	
	public static function activeStaffUserArray(){
		return ArrayHelper::map(self::activeStaff(), 'user_id', 'niceName');
	}

}
