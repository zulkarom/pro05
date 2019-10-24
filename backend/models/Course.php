<?php

namespace backend\models;

use Yii;
use backend\models\Component;

/**
 * This is the model class for table "course".
 *
 * @property int $id
 * @property int $component_id
 * @property string $course_name
 * @property string $course_code
 * @property int $is_active
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['component_id', 'course_name', 'course_name_bi', 'course_code', 'credit_hour'], 'required'],
            [['component_id', 'is_active'], 'integer'],
            [['course_name'], 'string', 'max' => 100],
			
            [['course_code'], 'string', 'max' => 50],
			
			['course_code', 'unique', 'targetClass' => '\backend\models\Course', 'message' => 'This course code has already been taken'],
			
			[['campus_1', 'campus_2', 'campus_3'],'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'component_id' => 'Component ID',
            'course_name' => 'Course Name (BM)',
			'course_name' => 'Course Name (EN)',
            'course_code' => 'Course Code',
			'is_active' => 'Is Active',
			'campus_1' => 'Kampus Bachok',
			'campus_2' => 'Kampus Kota',
			'campus_3' => 'Kampus Jeli',
        ];
    }
	
	public function getComponent(){
		return $this->hasOne(Component::className(), ['id' => 'component_id']);
	}
	
	public function getCodeAndCourse(){
		return $this->course_code . ' - ' . $this->course_name;
	}
	
	public function getCodeBrCourse(){
		return $this->course_code . '<br />' . $this->course_name;
	}
	
	public static function listCourseArray(){
		$array = [];
		$list = self::find()->orderBy('course_name ASC')->all();
		if($list){
			foreach($list as $row){
				$array[$row->id] = $row->course_code . ' ' . strtoupper($row->course_name);
			}
		}
		return $array;
	}
	
	

}
