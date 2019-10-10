<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property string $student_matric
 * @property string $student_name
 * @property string $program
 * @property string $email
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['student_matric'], 'required', 'on' => 'check'],
			
            [['student_matric', 'student_name', 'program', 'email'], 'required', 'on' => 'update'],
			
            [['student_matric'], 'string', 'max' => 50],
			
            [['student_name'], 'string', 'max' => 200],
			
			 [['email'], 'email'],
			
            [['program'], 'string', 'max' => 100],
            [['student_matric'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_matric' => 'No. Matrik',
            'student_name' => 'Nama Pelajar',
            'program' => 'Program',
            'email' => 'Email',
        ];
    }
}
