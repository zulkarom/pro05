<?php

namespace backend\modules\project\models;

use Yii;

/**
 * This is the model class for table "pro_ttf_day".
 *
 * @property int $id
 * @property int $pro_id
 * @property string $pro_date
 * @property int $day_order
 *
 * @property Project $pro
 * @property ProTtfTime[] $proTtfTimes
 */
class TentativeDay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pro_ttf_day';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pro_date'], 'required'],
			
            [['pro_id', 'day_order'], 'integer'],
			
            [['pro_date'], 'safe'],
			
            [['pro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['pro_id' => 'id']],
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
            'proj_date' => 'Tarikh',
            'day_order' => 'Day Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'pro_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTentativeTimes()
    {
        return $this->hasMany(TentativeTime::className(), ['day_id' => 'id']);
    }
}
