<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property string $dep_name
 * @property string $dep_name_bi
 * @property int $faculty
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dep_name', 'dep_name_bi', 'faculty'], 'required'],
            [['faculty'], 'integer'],
            [['dep_name', 'dep_name_bi'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dep_name' => 'Dep Name',
            'dep_name_bi' => 'Dep Name Bi',
            'faculty' => 'Faculty',
        ];
    }
}
