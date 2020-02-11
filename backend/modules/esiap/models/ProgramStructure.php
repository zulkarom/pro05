<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_program_structure".
 *
 * @property int $id
 * @property int $prg_version_id
 * @property int $crs_version_id
 * @property int $course_type_id
 * @property int $sem_num e.g. 1 or 2 = semester 1, semester dua
 * @property int $year
 * @property int $sem_num_part
 * @property int $year_part
 */
class ProgramStructure extends \yii\db\ActiveRecord
{
	public $course_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sp_program_structure';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prg_version_id', 'course_id', 'crs_version_id', 'course_type_id', 'sem_num', 'year'], 'required', 'on' => 'add-course'],
			
			
			
            [['prg_version_id', 'crs_version_id', 'course_type_id', 'sem_num', 'year', 'sem_num_part', 'year_part', 'course_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prg_version_id' => 'Prg Version',
			'course_id' => 'Course',
            'crs_version_id' => 'Course Version',
            'course_type_id' => 'Course Type',
            'sem_num' => 'Semester',
            'year' => 'Year',
            'sem_num_part' => 'Sem Num Part',
            'year_part' => 'Year Part',
        ];
    }
	
	public function getCourseVersion()
    {
        return $this->hasOne(CourseVersion::className(), ['id' => 'crs_version_id']);
    }
	
	public function getProgramVersion()
    {
        return $this->hasOne(ProgramVersion::className(), ['id' => 'prg_version_id']);
    }
	
	public function getCourseType()
    {
        return $this->hasOne(CourseType::className(), ['id' => 'course_type_id']);
    }

}
