<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_course_type".
 *
 * @property int $id
 * @property string $type_name
 * @property int $main_type
 * @property int $type_order
 */
class CourseType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_name', 'main_type', 'type_order'], 'required'],
            [['main_type', 'type_order'], 'integer'],
            [['type_name'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_name' => 'Type Name',
            'main_type' => 'Main Type',
            'type_order' => 'Type Order',
        ];
    }
}
