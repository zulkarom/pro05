<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "general_setting".
 *
 * @property int $id
 * @property string $faculty
 * @property string $faculty_bi
 * @property string $department
 * @property string $department_bi
 * @property string $program
 * @property string $program_bi
 */
class GeneralSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'general_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['faculty', 'faculty_bi', 'department', 'department_bi', 'program', 'program_bi'], 'required'],
            [['faculty', 'faculty_bi', 'department', 'department_bi', 'program', 'program_bi'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'faculty' => 'Faculty (BM)',
            'faculty_bi' => 'Faculty (EN)',
            'department' => 'Department (BM)',
            'department_bi' => 'Department (EN)',
            'program' => 'Program (BM)',
            'program_bi' => 'Program (EN)',
        ];
    }
}
