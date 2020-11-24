<?php

namespace backend\modules\esiap\models;

use Yii;
use common\models\User;
use backend\models\GeneralSetting;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sp_course_version".
 *
 * @property int $id
 * @property int $course_id
 * @property string $version_name
 * @property int $trash
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_developed
 */
class CourseVersion extends \yii\db\ActiveRecord
{
	public $as_percentage;
	public $assess_f2f;
	public $assess_f2f_tech;
	public $assess_nf2f;
	public $assess_name;
	public $assess_name_bi;
	public $delivery_name;
	public $delivery_name_bi;
	public $as_hour;
	public $duplicate = 0;
	public $dup_course;
	public $dup_version;
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course_version';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'version_name', 'version_type_id', 'created_by', 'created_at', 'is_developed'], 'required', 'on' => 'create'],
			
			[['course_id', 'version_name', 'updated_at', 'is_developed', 'is_published'], 'required', 'on' => 'update'],
			
			[['status', 'verified_by', 'verified_at'], 'required', 'on' => 'verify'],
			
			[['status'], 'required', 'on' => 'status'],
			
			[['senate_approve_at', 'faculty_approve_at', 'senate_approve_show'], 'required', 'on' => 'save_date'],
			
			[['pgrs_info'], 'required', 'on' => 'pgrs_info'],
			[['pgrs_clo'], 'required', 'on' => 'pgrs_clo'],
			[['pgrs_plo'], 'required', 'on' => 'pgrs_plo'],
			[['pgrs_tax'], 'required', 'on' => 'pgrs_tax'],
			[['pgrs_soft'], 'required', 'on' => 'pgrs_soft'],
			[['pgrs_delivery'], 'required', 'on' => 'pgrs_delivery'],
			[['pgrs_syll'], 'required', 'on' => 'pgrs_syll'],
			[['pgrs_slt'], 'required', 'on' => 'pgrs_slt'],
			[['pgrs_assess'], 'required', 'on' => 'pgrs_assess'],
			[['pgrs_assess_per'], 'required', 'on' => 'pgrs_assess_per'],
			[['pgrs_ref'], 'required', 'on' => 'pgrs_ref'],
			
            [['course_id', 'created_by', 'is_developed', 'is_published', 'status', 'prepared_by', 'verified_by', 'dup_course', 'dup_version', 'version_type_id', 'duplicate'], 'integer'],
            [['created_at', 'updated_at', 'senate_approve_at', 'faculty_approve_at', 'senate_approve_show', 'prepared_at', 'verified_at'], 'safe'],
			
            [['version_name'], 'string', 'max' => 200],
			
			[['syllabus_break'], 'string'],
			
			
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Course ID',
            'version_name' => 'Version Name',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
			'version_type_id' => 'Version Type',
            'updated_at' => 'Updated At',
            'is_developed' => 'Under Development',
			'is_published' => 'Published',
        ];
    }
	
	public function getVersionType(){
        return $this->hasOne(VersionType::className(), ['id' => 'version_type_id']);
    }
	
	public function getPloNumber(){
		return $this->versionType->plo_num;
	}
	
	public function getClos()
    {
        return $this->hasMany(CourseClo::className(), ['crs_version_id' => 'id'])->orderBy('id ASC');
    }
	
/* 	public function getCloAssessments(){
		return self::find()
        ->select('sp_course_clo.clo_text')
        ->where(['sp_course_version.id' => $this->id, 'is_developed' => 1])
        ->innerJoin('sp_course_clo', 'sp_course_clo.crs_version_id = sp_course_version.id')
		->innerJoin('sp_course_clo_assess', 'sp_course_clo.id = sp_course_clo_assess.clo_id')
        ->all();

	} */
	
	public function putOneCloAssessment(){
		$clos = $this->clos;
		if($clos){
			foreach($clos as $clo){
				$assess = $clo->cloAssessments;
				if(!$assess){
					//put one
					$assess = new CourseCloAssessment;
					$assess->scenario = 'fresh';
					$assess->clo_id = $clo->id;
					if($assess->save()){
						return true;
					}
					
				}
			}
		}
		return false;
	}
	
	public function getAssessments()
    {
		return $this->hasMany(CourseAssessment::className(), ['crs_version_id' => 'id'])->orderBy('id ASC');
        
    }
	
	
	
	public function getAssessmentDirect()
    {
		return $this->hasMany(CourseAssessment::className(), ['crs_version_id' => 'id'])->orderBy('id ASC')
		->innerJoin('sp_assessment_cat', 'sp_assessment_cat.id = sp_course_assessment.assess_cat')->where(['sp_assessment_cat.is_direct' => 1]);
        
    }
	
	public function getAssessmentIndirect()
    {
		return $this->hasMany(CourseAssessment::className(), ['crs_version_id' => 'id'])->orderBy('id ASC')->innerJoin('sp_assessment_cat', 'sp_assessment_cat.id = sp_course_assessment.assess_cat')->where(['sp_assessment_cat.is_direct' => 0]);
    }
	
	public function getAssessmentFormative()
    {
		return $this->hasMany(CourseAssessment::className(), ['crs_version_id' => 'id'])->orderBy('id ASC')->innerJoin('sp_assessment_cat', 'sp_assessment_cat.id = sp_course_assessment.assess_cat')->where(['sp_assessment_cat.form_sum' => 1]);
    }
	
	public function getAssessmentSummative()
    {
		return $this->hasMany(CourseAssessment::className(), ['crs_version_id' => 'id'])->orderBy('id ASC')->innerJoin('sp_assessment_cat', 'sp_assessment_cat.id = sp_course_assessment.assess_cat')->where(['sp_assessment_cat.form_sum' => 2]);
    }
	
	public function getSltAssessmentFormative()
    {
		return self::find()
		->select('sp_course_assessment.*, SUM(sp_course_assessment.assess_f2f) + SUM(sp_course_assessment.assess_nf2f) AS as_hour')
		->innerJoin('sp_course_assessment', 'sp_course_assessment.crs_version_id = sp_course_version.id')
		->innerJoin('sp_assessment_cat', 'sp_assessment_cat.id = sp_course_assessment.assess_cat')
		->groupBy(['sp_assessment_cat.form_sum'])
		->where(['sp_course_assessment.crs_version_id' => $this->id,'sp_assessment_cat.form_sum' => 1])
		->one()
		;
        
    }
	
	public function getSltAssessmentSummative()
    {
		return self::find()
		->select('sp_course_assessment.*, SUM(sp_course_assessment.assess_f2f) + SUM(sp_course_assessment.assess_nf2f) AS as_hour')
		->innerJoin('sp_course_assessment', 'sp_course_assessment.crs_version_id = sp_course_version.id')
		->innerJoin('sp_assessment_cat', 'sp_assessment_cat.id = sp_course_assessment.assess_cat')
		->groupBy(['sp_assessment_cat.form_sum'])
		->where(['sp_course_assessment.crs_version_id' => $this->id,'sp_assessment_cat.form_sum' => 2])
		->one()
		;
        
    }
	
	public function getCourseAssessmentFormative()
    {
		return self::find()
		
		->select('sp_course_assessment.*, SUM(sp_course_clo_assess.percentage) AS as_percentage, 
		sp_course_assessment.assess_f2f, sp_course_assessment.assess_nf2f, sp_course_assessment.assess_f2f_tech')
		
		->innerJoin('sp_course_clo', 'sp_course_clo.crs_version_id = sp_course_version.id')
		->innerJoin('sp_course_clo_assess', 'sp_course_clo_assess.clo_id = sp_course_clo.id')
		->innerJoin('sp_course_assessment', 'sp_course_assessment.id = sp_course_clo_assess.assess_id')
		->innerJoin('sp_assessment_cat', 'sp_assessment_cat.id = sp_course_assessment.assess_cat')
		->groupBy(['sp_course_clo_assess.assess_id'])
		->where(['sp_course_assessment.crs_version_id' => $this->id,'sp_assessment_cat.form_sum' => 1])
		->all();
        
    }
	
	public function getCourseAssessmentSummative()
    {
		return self::find()
		->select('sp_course_assessment.*, SUM(sp_course_clo_assess.percentage) AS as_percentage, 
		sp_course_assessment.assess_f2f, sp_course_assessment.assess_nf2f, sp_course_assessment.assess_f2f_tech')
		->innerJoin('sp_course_clo', 'sp_course_clo.crs_version_id = sp_course_version.id')
		->innerJoin('sp_course_clo_assess', 'sp_course_clo_assess.clo_id = sp_course_clo.id')
		->innerJoin('sp_course_assessment', 'sp_course_assessment.id = sp_course_clo_assess.assess_id')
		->innerJoin('sp_assessment_cat', 'sp_assessment_cat.id = sp_course_assessment.assess_cat')
		->groupBy(['sp_course_clo_assess.assess_id'])
		->where(['sp_course_assessment.crs_version_id' => $this->id,'sp_assessment_cat.form_sum' => 2])
		->all()
		;
    }
	
	public function getCourseDeliveries()
    {
		return self::find()
		->select('sp_course_delivery.delivery_name, sp_course_delivery.delivery_name_bi')
		->innerJoin('sp_course_clo', 'sp_course_clo.crs_version_id = sp_course_version.id')
		->innerJoin('sp_course_clo_delivery', 'sp_course_clo_delivery.clo_id = sp_course_clo.id')
		->innerJoin('sp_course_delivery', 'sp_course_delivery.id = sp_course_clo_delivery.delivery_id')
		->where(['sp_course_clo.crs_version_id' => $this->id])
		->groupBy(['sp_course_delivery.id'])
		->all()
		;
    }
	
	public function getSyllabus()
    {
		CourseSyllabus::checkSyllabus($this->id);
        return $this->hasMany(CourseSyllabus::className(), ['crs_version_id' => 'id'])->orderBy('syl_order ASC, id ASC');
    }
	
	public function getReferences()
    {
        return $this->hasMany(CourseReference::className(), ['crs_version_id' => 'id'])->orderBy('id ASC');
    }

	
	public function getMainReferences()
    {
        return $this->hasMany(CourseReference::className(), ['crs_version_id' => 'id'])->where(['is_main' => 1])->orderBy('id ASC');
    }
	
	public function getAdditionalReferences()
    {
        return $this->hasMany(CourseReference::className(), ['crs_version_id' => 'id'])->where(['is_main' => 0])->orderBy('id ASC');
    }
	
	public function getPreparedBy(){
        return $this->hasOne(User::className(), ['id' => 'prepared_by']);
    }
	public function getPrepareDate(){
		return $this->niceDate($this->prepared_at);
	}
	
	public function getVerifiedBy(){
        return $this->hasOne(User::className(), ['id' => 'verified_by']);
    }
	public function getVerifiedDate(){
		return $this->niceDate($this->verified_at);
	}


	public function getCourse(){
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }
	
	public function getProfile(){
		CourseProfile::checkProfile($this->id);
        return $this->hasOne(CourseProfile::className(), ['crs_version_id' => 'id']);
    }

	public function getSlt(){
		CourseSlt::checkSlt($this->id);
        return $this->hasOne(CourseSlt::className(), ['crs_version_id' => 'id']);
    }
	
	public function getSltAs(){
		CourseSltAs::checkSltAs($this->id);
        return $this->hasOne(CourseSlt::className(), ['crs_version_id' => 'id']);
    }
	
	public function getLabelStatus(){
		$arr = $this->statusArray;
		$status = '';
		switch($this->status){
			case 0:
			$status = 'DRAFT ' . $this->progress. '%';
			$color = 'default';
			break;
			
			case 10:
			$status = 'SUBMITTED';
			$color = 'info';
			break;
			
			case 20:
			$status = 'VERIFIED';
			$color = 'success';
			break;
		}
		return '<span class="label label-'.$color.'">' . $status . '</span>';
	}
	
	public function getStatusArray(){
		return [0=>'DRAFT', 10=>'SUBMITTED', 20 => 'VERIFIED'];
	}
	
	public function getLabelActive(){
		return $this->yesNoLabel($this->is_developed);
	}
	
	public function getLabelPublished(){
		return $this->yesNoLabel($this->is_published);
	}
	
	private function yesNoLabel($field){
		$status = '';
		switch($field){
			case 1:
			$status = 'YES';
			$color = 'success';
			break;
			
			case 0:
			$status = 'NO';
			$color = 'danger';
			break;
		}
		return '<span class="label label-'.$color.'">' . $status . '</span>';
	}
	
	public function niceDate($date){
		if($date == '0000-00-00'){
			return '';
		}else{
			return date('d/m/Y',strtotime($date));
		}
		
	}
	
	public function getSenateDate(){
		return $this->niceDate($this->senate_approve_at);
	}
	
	public function getFacultyDate(){
		return $this->niceDate($this->faculty_approve_at);
	}
	
	public function getPloNumberArray(){
		$array = array();
		for($i=1;$i<=12;$i++){
			$array[$i] = $i;
		}
		return $array;
	}
	
	public function getDefaultPloNumber(){
		return 8;
	}
	
	
	
	
	public function getSetting(){
		return GeneralSetting::findOne(1);
	}
	
	public function getVersionTypeList(){
		return ArrayHelper::map(VersionType::find()->orderBy('id DESC')->all(), 'id', 'type_name');
	}
	
	public function getProgress(){
		$info = $this->pgrs_info;
		$clo = $this->pgrs_clo;
		$plo = $this->pgrs_plo;
		$tax = $this->pgrs_tax;
		$soft = $this->pgrs_soft;
		$delivery = $this->pgrs_delivery;
		$syll = $this->pgrs_syll;
		$slt = $this->pgrs_slt;
		$assess = $this->pgrs_assess;
		$assess_per = $this->pgrs_assess_per;
		$ref = $this->pgrs_ref;
		
		$jum = $info + $clo + $plo + $tax + $soft + $delivery + $syll + $slt + $assess + $assess_per + $ref;
		$per = $jum / 22 * 100;
		return number_format($per,0);
	}
	

}
