<?php

namespace backend\modules\esiap\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sp_course_profile".
 *
 * @property int $id
 * @property int $crs_version_id
 * @property int $prerequisite
 * @property string $synopsis
 * @property string $synopsis_bi
 * @property string $transfer_skill
 * @property string $transfer_skill_bi
 * @property string $feedback
 * @property string $feedback_bi
 * @property string $staff_academic
 * @property string $requirement
 * @property string $additional
 * @property string $offer_at
 */
class CourseProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			
			[['crs_version_id'], 'required', 'on' => 'fresh'],
			
            [['synopsis', 'synopsis_bi', 'feedback', 'feedback_bi', 'objective', 'objective_bi', 'rational', 'rational_bi', 'offer_sem', 'offer_year'], 'required', 'on' => 'update'],
			
			
            [['crs_version_id', 'prerequisite', 'offer_sem', 'offer_year'], 'integer'],
			
            [['synopsis', 'synopsis_bi', 'transfer_skill', 'transfer_skill_bi', 'feedback', 'feedback_bi', 'staff_academic', 'requirement', 'additional','requirement_bi', 'additional_bi', 'objective', 'objective_bi', 'rational', 'rational_bi', 'offer_remark'], 'string'],
			
            [['offer_at'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'crs_version_id' => 'Crs Version ID',
            'prerequisite' => 'Prerequisite/co-requisite',
            'synopsis' => 'Synopsis (BM)',
            'synopsis_bi' => 'Synopsis (EN)',
			'objective' => 'Objective (BM)',
            'objective_bi' => 'Objective (EN)',
			'rational' => 'Rational (BM)',
            'rational_bi' => 'Rational (EN)',
            'transfer_skill' => 'Transferable Skill (BM) Open Ended',
            'transfer_skill_bi' => 'Transferable Skill (EN) Open Ended',
            'feedback' => 'Feedback (BM)',
            'feedback_bi' => 'Feedback (EN)',
            'staff_academic' => 'Staff Academic',
            'requirement' => 'Special Requirement (BM)',
            'additional' => 'Additional Information (BM)',
			'requirement_bi' => 'Special Requirement (EN)',
            'additional_bi' => 'Additional Information (EN)',
            'offer_at' => 'Offer At',
			'offer_sem' => 'Semester Offered',
			'offer_year' => 'Year Offered',
        ];
    }
	
	public function getCourseVersion(){
        return $this->hasOne(CourseVersion::className(), ['id' => 'crs_version_id' ]);
    }
	
	public function getCourse(){
		return Course::findOne($this->courseVersion->course_id);
	}
	
	public function getCoursePrerequisite(){
		$result = Course::findOne($this->prerequisite);
		
		if($result){
			$bm = $result->course_code . ' ' . $result->course_name;
		$bi = $result->course_code . ' ' . $result->course_name_bi;
			return [$bm, $bi];
		}else{
			return ['Tiada','Nil'];
		}
	}
	
	public static function checkProfile($version){
		$slt = self::findOne(['crs_version_id' => $version]);
		if(!$slt){
			$slt = new self();
			$slt->scenario = 'fresh';
			$slt->crs_version_id = $version;
			$slt->save();
		}
		
	}
	
	public function getTransferables()
    {
		return $this->hasMany(CourseTransferable::className(), ['crs_version_id' => 'crs_version_id'])->orderBy('transfer_order ASC');
    }
	
	public function getAcademicStaff()
    {
		return $this->hasMany(CourseStaff::className(), ['crs_version_id' => 'crs_version_id'])->orderBy('staff_order ASC');
    }
	
	public function getTransferableList(){
		return ArrayHelper::map(Transferable::find()->all(), 'id','transferableText');
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


}
