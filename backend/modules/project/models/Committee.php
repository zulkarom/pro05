<?php

namespace backend\modules\project\models;

use Yii;

/**
 * This is the model class for table "pro_committee".
 *
 * @property int $id
 * @property int $pro_id
 * @property string $position
 * @property int $student_id
 * @property int $is_main
 */
class Committee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pro_committee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pro_id', 'position', 'student_id', 'is_main'], 'required'],
            [['pro_id', 'student_id', 'is_main'], 'integer'],
            [['position'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pro_id' => 'Pro ID',
            'position' => 'Position',
            'student_id' => 'Student ID',
            'is_main' => 'Is Main',
        ];
    }
}
