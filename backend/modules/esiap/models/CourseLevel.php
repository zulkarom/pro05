<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_course_level".
 *
 * @property int $id
 * @property string $lvl_name
 */
class CourseLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lvl_name'], 'required'],
            [['lvl_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lvl_name' => 'Lvl Name',
        ];
    }
}
