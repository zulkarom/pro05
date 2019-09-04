<?php

namespace backend\modules\esiap\models;


use Yii;
use backend\models\Component;
use common\models\User;

/**
 * This is the model class for table "sp_course".
 *
 * @property int $id
 * @property string $crs_code
 * @property string $course_name
 * @property string $course_name_bi
 * @property int $credit_hour
 * @property int $crs_type
 * @property int $crs_level
 * @property int $faculty
 * @property int $department
 * @property int $program
 * @property int $is_dummy
 * @property int $trash
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
			
			[['component_id', 'course_name', 'course_name_bi', 'course_code', 'credit_hour', 'coordinator'], 'required'],
			
			[['coordinator'], 'required', 'on' => 'coor'],
			
            [['component_id', 'is_active', 'coordinator'], 'integer'],
			
            [['course_name'], 'string', 'max' => 100],
			
            [['course_code'], 'string', 'max' => 50],
			
			['course_code', 'unique', 'targetClass' => '\backend\modules\esiap\models\Course', 'message' => 'This course code has already been taken'],
			
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
			'course_name_bi' => 'Course Name (EN)',
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
	
	public function getCoor(){
		return $this->hasOne(User::className(), ['id' => 'coordinator']);
	}
	
	public function getCodeAndCourse(){
		return $this->course_code . ' - ' . $this->course_name;
	}
	
	public function getCodeBrCourse(){
		return $this->course_code . '<br />' . $this->course_name;
	}
	
	public function allCoursesArray(){
		$result = self::find()->orderBy('course_name ASC')->all();
		$array[0] = 'Tiada / Nil';
		foreach($result as $row){
			$array[$row->id] = $row->course_name .' - '.$row->course_code;
		}
		return $array;
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
	
	public function getDefaultVersion(){
		return CourseVersion::findOne(['course_id' => $this->id, 'is_active' => 1]);

	}

}
