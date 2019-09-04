<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hour".
 *
 * @property int $id
 * @property string $hour_format
 */
class Hour extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hour';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['hour_format'], 'string', 'max' => 4],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hour_format' => 'Hour Format',
        ];
    }
}
