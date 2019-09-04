<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_course_assessment".
 *
 * @property int $id
 * @property int $crs_version_id
 * @property string $assess_name
 * @property string $assess_name_bi
 * @property int $assess_cat
 * @property int $trash
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 */
class CourseAssessment extends \yii\db\ActiveRecord
{
	public $percentage;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course_assessment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['assess_name', 'assess_name_bi', 'assess_cat'], 'required', 'on' => 'saveall'],
			
			[['crs_version_id'], 'required', 'on' => 'add'],
			
			[['assess_hour'], 'required', 'on' => 'update_slt'],
			
            [['crs_version_id', 'assess_cat', 'trash', 'created_by'], 'integer'],
			
			[['assess_hour'], 'number'],
			
            [['created_at', 'updated_at'], 'safe'],
            [['assess_name', 'assess_name_bi'], 'string', 'max' => 100],
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
            'assess_name' => 'Assess Name',
            'assess_name_bi' => 'Assess Name Bi',
            'assess_cat' => 'Assess Cat',
            'trash' => 'Trash',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
	
	public function getCourseVersion(){
        return $this->hasOne(CourseVersion::className(), ['id' => 'crs_version_id']);
    }
	
	public function getAssessmentPercentage(){
		$per = CourseCloAssessment::find()
		->select('SUM(percentage) as percentage')
		->where(['assess_id' => $this->id])
		->groupBy('assess_id')
		->one();
		if($per){
			return $per->percentage;
		}else{
			return 0;
		}
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
