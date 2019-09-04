<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "education_level".
 *
 * @property int $id
 * @property string $edu_name
 * @property int $level
 */
class EducationLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'education_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['edu_name', 'level'], 'required'],
            [['level'], 'integer'],
            [['edu_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'edu_name' => 'Edu Name',
            'level' => 'Level',
        ];
    }
}
