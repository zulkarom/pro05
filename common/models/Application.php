<?php

namespace common\models;

use Yii;
use common\models\Fasi;
use backend\models\Component;
use backend\models\Course;
use backend\models\Campus;
use backend\models\Location;
use backend\models\Group;
use backend\models\FasiType;
use common\models\SessionTime;
use common\models\ApplicationCourse;
use common\models\ApplicationGroup;
use common\models\Common;
use backend\models\Semester;
use raoul2000\workflow\validation\WorkflowValidator;
use raoul2000\workflow\validation\WorkflowScenario;
use common\models\Token;
use backend\modules\project\models\Project;
use yii\db\Expression;


/**
 * This is the model class for table "application".
 *
 * @property int $id
 * @property int $fasi_id
 * @property int $semester_id
 * @property int $location_id
 * @property string $status
 * @property string $submit_at
 * @property string $verified_at
 * @property string $approved_at
 * @property string $approve_note
 * @property string $reject_note
 */
class Application extends \yii\db\ActiveRecord
{
	public $selected_course;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'application';
    }
	
	public function behaviors()
    {
    	return [
			\raoul2000\workflow\base\SimpleWorkflowBehavior::className()
    	];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		
			[['status'], WorkflowValidator::className()],
			
			[['fasi_id', 'semester_id', 'status', 'draft_at'], 'required', 'on' => WorkflowScenario::enterStatus('a-draft')],
			
			[['fasi_id', 'semester_id', 'status', 'draft_at', 'campus_id', 'fasi_type_id'], 'required', 'on' => 'savedraft'],
			
			[['campus_id', 'rate_amount', 'group_id'], 'required', 'on' => 'editadmin'],
			
            [['submit_at'], 'required', 'on' => WorkflowScenario::enterStatus('b-submit')],
			
			[['verified_at',  'verified_by'], 'required', 'on' =>'save-verify'],
			
			[['group_id', 'rate_amount', 'verified_at', 'selected_course',  'verified_by'], 'required', 'on' => WorkflowScenario::enterStatus('c-verified')],
			
			[['approved_at', 'approved_by'], 'required', 'on' => WorkflowScenario::enterStatus('d-approved')],
			
			[['released_at', 'released_by', 'status'], 'required', 'on' => WorkflowScenario::enterStatus('e-release')],
			
			[['accept_at'], 'required', 'on' => WorkflowScenario::enterStatus('f-accept')],
			
			[['returned_at', 'returned_by'], 'required', 'on' => WorkflowScenario::enterStatus('g-returned')],
			
			[['release_email'], 'required', 'on' => 'release_email'],
			
            [['fasi_id', 'group_id', 'semester_id', 'location_id', 'verified_by', 'returned_by'], 'integer'],
			
			
			[['rate_amount'], 'number'],
			
            [['submit_at', 'verified_at', 'approved_at'], 'safe'],
			
            [['approve_note', 'reject_note', 'verify_note'], 'string'],
			
			
            [['status'], 'string', 'max' => 50],
			
			
			
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
			'fasi_type_id' => 'Jenis Permohonan',
			'fasiType.type_name' => 'Jenis Permohonan',
            'fasi_id' => 'Fasi ID',
			'fasi.user.fullname' => 'Nama Fasilitator',
            'semester_id' => 'Semester',
            'campus_id' => 'Kampus',
            'status' => 'Status',
            'submit_at' => 'Dihantar pada',
            'verified_at' => 'Disokong pada',
			'accepted_at' => 'Diterima pada',
			'verified_by' => 'Disokong oleh',
			'ref_letter' => 'Rujukan Surat',
            'approved_at' => 'Dilulus pada',
			'approver.fullname' => 'Dilulus oleh',
            'approve_note' => 'Ulasan Kelulusan',
            'reject_note' => 'Reject Note',
			'group_id' => 'Kumpulan',
			'rate_amount' => 'Kadar Bayaran',
			'verify_note' => 'Ulasan Sokongan',
			'applicationCourses' => 'Kursus'
        ];
    }
	
	public function getFasi(){
		return $this->hasOne(Fasi::className(), ['id' => 'fasi_id']);
	}
	
	
	public function getFasiType(){
		return $this->hasOne(FasiType::className(), ['id' => 'fasi_type_id']);
	}
	
	public function getLocation(){
		return $this->hasOne(Location::className(), ['id' => 'location_id']);
	}
	
	
	public function getVerifier(){
		return $this->hasOne(User::className(), ['id' => 'verified_by']);
	}
	
	public function getApprover(){
		return $this->hasOne(User::className(), ['id' => 'approved_by']);
	}
	
	public function getApplicationCourses()
    {
        return $this->hasMany(ApplicationCourse::className(), ['application_id' => 'id']);
    }
	
	public function getClaims()
    {
        return $this->hasMany(Claim::className(), ['application_id' => 'id']);
    }
	
	public function getSubmittedClaims()
    {
        return $this->hasMany(Claim::className(), ['application_id' => 'id'])->where(['status' => 'ClaimWorkflow/bb-submit']);
    }
	
	public function getAcceptedCourse(){
		$course = ApplicationCourse::findOne(['application_id' => $this->id, 'is_accepted' => 1]);
		return $course;
	}
	
	public static function getMyAcceptApplication(){
		return Application::find()
		->innerJoin('fasi', 'fasi.id = application.fasi_id')
		->innerJoin('semester', 'semester.id = application.semester_id')
		->where(['application.status' => 'ApplicationWorkflow/f-accept', 'fasi.user_id' => Yii::$app->user->identity->id, 'semester.is_current' => 1])
		->one()
		;
	}
	
	public function listAppliedCourses(){
		$array = array();
		foreach($this->applicationCourses as $c){
			$array[$c->course_id] = $c->course->course_code . ' - ' . $c->course->course_name;
		}
		return $array;
	}
	
	public function listAppliedCoursesString($break = "<br />"){
		$string = '';
		$i = 1;
		foreach($this->applicationCourses as $c){
			$br = $i == 1 ? '' : $break;
			if($c->course){
				$string .= $br.$c->course->course_code . ' ' . $c->course->course_name;
			}
			
		$i++;
		}
		return $string;
		
	}

	public function getDayName(){
		$days = [1 => "Ahad", 2 => "Isnin", 3 => "Selasa", 4 => "Rabu", 5 =>"Khamis", 6 => "Jumaat", 7 => "Sabtu", 0 => ''];
		return $days[$this->day];
	}
	
	public function getSession(){
		return $this->hasOne(SessionTime::className(), ['id' => 'session_id']);
	}
	
	public function getSemester(){
		return $this->hasOne(Semester::className(), ['id' => 'semester_id']);
	}
	
	public function getCampus(){
		return $this->hasOne(Campus::className(), ['id' => 'campus_id']);
	}
	
	public function getApplicationGroup(){
		return $this->hasOne(ApplicationGroup::className(), ['id' => 'group_id']);
	}
	
	public function getGroupName(){
		return $this->applicationGroup->group_name;
	}
	
	public function getAllStatusesArray(){
		$cl = new ApplicationWorkflow;
		$status = $cl->getDefinition();
		$array = array();
		foreach($status['status'] as $key=>$s){
			$array['ApplicationWorkflow/' . $key] = $s['label'];
		}
		return $array;
	}
	
	public function getWfStatus(){
		$status = $this->getWorkflowStatus()->getId();
		$status = str_replace("ApplicationWorkflow/","",$status);
		$status = explode('-', $status);
		$status = $status[1];
		return $status;
	}
	public function getWfLabel(){
		$label = $this->getWorkflowStatus()->getLabel();
		$color = $this->getWorkflowStatus()->getMetadata('color');
		$format = '<span class="label label-'.$color.'">'.strtoupper($label).'</span>';
		return $format;
	}
	
	public function showingVerified(){
		
		switch($this->getWfStatus()){
			case "verified":
			case "approved":
			case "release":
			case "accept":
			return true;
			break;
			
			default:
			return false;
		}
		
	}
	
	public function showingApproved(){
		switch($this->getWfStatus()){
			case "approved":
			case "release":
			case "accept":
			return true;
			break;
			
			default:
			return false;
		}
		
	}
	
	public function showingRelease(){
		switch($this->getWfStatus()){
			case "release":
			case "accept":
			return true;
			break;
			
			default:
			return false;
		}
		
	}
	
	public function showingAccept(){
		switch($this->getWfStatus()){
			case "accept":
			return true;
			break;
			
			default:
			return false;
		}
		
	}
	
	public static function applicationCurrentSemester($fasi){
		return self::find()
		->innerJoin('semester', 'semester.id = application.semester_id')
		 ->where(['fasi_id'=> $fasi, 'semester.is_current' => 1])
		->one();
	}
	
	public function getListGroup(){
		return ApplicationGroup::find()->where(['campus_id'=> $this->campus_id] )->all();
	}
	
	public function getListGroupAll(){
		return ApplicationGroup::find()->all();
	}
	
	public function getHourMonth($month_str){
		$month = Common::getMonth($month_str);
		$claim = Claim::findOne(['application_id' => $this->id, 'month' => $month, 'status' => 'ClaimWorkflow/bb-submit']);
		if($claim){
			$hour = $claim->total_hour;
		}else{
			$hour = 0;
		}
		return $hour;
	}
	
	public function getAmountMonth($month_str){
		$month = Common::getMonth($month_str);
		$claim = Claim::findOne(['application_id' => $this->id, 'month' => $month, 'status' => 'ClaimWorkflow/bb-submit']);
		if($claim){
			$amt = $claim->total_hour * $claim->rate_amount;
		}else{
			$amt = 0;
		}
		return $amt;
	}
	
	public function getHourTotal(){
		return Claim::find()->where(['application_id' => $this->id, 'status' => 'ClaimWorkflow/bb-submit'])->sum('total_hour');

	}
	
	public function getAmountTotal(){
		return Claim::find()->where(['application_id' => $this->id, 'status' => 'ClaimWorkflow/bb-submit'])->sum('total_hour * rate_amount');

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



    public function getProject()
    {
		$model = Project::findOne(['application_id' => $this->id]);
		if($model){
			return $model;
		}else{
			return $this->createProject();
		}
		
    }
	
	public function createProject()
    {
        $model = new Project();
		$semester = Semester::getCurrentSemester();
		$model->scenario = 'fasi-create';
		$model->semester_id = $semester->id;
		$model->created_at = new Expression('NOW()');
		$model->date_start = date('Y-m-d');
		$model->date_end = date('Y-m-d');
		$model->application_id = $this->id;
		$model->pro_token = Token::projectKey();
		if($model->save()){
			return $model;
		}
            
    }
	
	public static function findFasiNameByCourseCodeAndSemester($course_code, $semester, $group){		
		return (new \yii\db\Query())
		->select('g.group_name , u.fullname as fasiname')
		->from('application a')
		->innerJoin('application_course ac','ac.application_id = a.id')
		->innerJoin('sp_course c', 'c.id = ac.course_id')
		->innerJoin('application_group g','g.id = a.group_id')
		->innerJoin('fasi f', 'f.id = a.fasi_id')
		->innerJoin('user u', 'u.id = f.user_id')
		->where([
			'c.course_code' => $course_code, 
			'g.group_name' => $group,
			'ac.is_accepted' => 1, 
			'a.semester_id' => $semester, 
			'a.status' => 'ApplicationWorkflow/f-accept', 
			])
		->one();
	}
	


}
