<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "session_time".
 *
 * @property int $id
 * @property string $session_info
 */
class SessionTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'session_time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['session_info'], 'required'],
            [['session_info'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'session_info' => 'Session Info',
        ];
    }
}
