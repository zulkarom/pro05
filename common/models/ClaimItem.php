<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "claim_item".
 *
 * @property int $id
 * @property int $claim_id
 * @property string $item_date
 * @property int $hour_start
 * @property int $hour_end
 * @property int $session_type
 */
class ClaimItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'claim_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_date', 'hour_start', 'hour_end', 'session_type'], 'required'],
			
            [['claim_id', 'hour_start', 'hour_end', 'session_type'], 'integer'],
			
			
            [['item_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'claim_id' => 'Claim ID',
            'item_date' => 'Item Date',
            'hour_start' => 'Hour Start',
            'hour_end' => 'Hour End',
            'session_type' => 'Session Type',
        ];
    }
	
	public function getHourStart(){
		return $this->hasOne(Hour::className(), ['id' => 'hour_start']);
	}
	
	public function getHourEnd(){
		return $this->hasOne(Hour::className(), ['id' => 'hour_end']);
	}
	
	public function getSessionType(){
		return $this->hasOne(SessionType::className(), ['id' => 'session_type']);
	}
	
	public function getClaim(){
		return $this->hasOne(Claim::className(), ['id' => 'claim_id']);
	}
	
}
