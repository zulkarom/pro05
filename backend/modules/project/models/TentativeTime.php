<?php

namespace backend\modules\project\models;

use Yii;

/**
 * This is the model class for table "pro_ttf_time".
 *
 * @property int $id
 * @property int $day_id
 * @property string $ttf_time
 * @property string $ttf_item
 * @property string $ttf_location
 * @property int $ttf_order
 *
 * @property ProTtfDay $day
 */
class TentativeTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pro_ttf_time';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day_id', 'ttf_time', 'ttf_item', 'ttf_location', 'ttf_order'], 'required'],
            [['day_id', 'ttf_order'], 'integer'],
            [['ttf_time'], 'safe'],
            [['ttf_item', 'ttf_location'], 'string', 'max' => 200],
            [['day_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProTtfDay::className(), 'targetAttribute' => ['day_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day_id' => 'Day ID',
            'ttf_time' => 'Ttf Time',
            'ttf_item' => 'Ttf Item',
            'ttf_location' => 'Ttf Location',
            'ttf_order' => 'Ttf Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDay()
    {
        return $this->hasOne(ProTtfDay::className(), ['id' => 'day_id']);
    }
}
