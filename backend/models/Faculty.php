<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "faculty".
 *
 * @property int $id
 * @property string $faculty_name
 * @property string $faculty_name_bi
 */
class Faculty extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faculty';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['faculty_name', 'faculty_name_bi'], 'required'],
            [['faculty_name', 'faculty_name_bi'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'faculty_name' => 'Faculty Name',
            'faculty_name_bi' => 'Faculty Name Bi',
        ];
    }
}
