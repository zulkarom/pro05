<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\Course;

/**
 * This is the model class for table "application_course".
 *
 * @property int $id
 * @property int $application_id
 * @property int $course_id
 * @property int $is_accepted 0=no, 1= accept
 */
class ApplicationCourse extends \yii\db\ActiveRecord
{
	public $component_id;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'application_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['component_id', 'course_id'], 'required', 'on' => 'apply'],
			
			[['is_accepted'], 'required', 'on' => 'verify'],
			
			
            [['application_id', 'course_id', 'is_accepted'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'application_id' => 'Application ID',
            'course_id' => 'Course ID',
            'is_accepted' => 'Is Accepted',
        ];
    }
	
	public function getCourse(){
		return $this->hasOne(Course::className(), ['id' => 'course_id']);
	}
	
	public function siblingCourses(){
		if($this->id){
			$courses = Course::find()->where(['component_id' => $this->course->component_id])->asArray()->all();
			
			$array = array();
			if($courses){
				foreach($courses as $c){
					$array[$c['id']] = $c['course_code'] . ' - ' . $c['course_name'];
				}
			}
			
			return $array;
		}else{
			return array();
		}

	}
	
	

	
}
