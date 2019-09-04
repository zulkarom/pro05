<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "claim_setting".
 *
 * @property int $id
 * @property double $hour_max_month
 * @property double $hour_max_sem
 */
class ClaimSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'claim_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hour_max_month', 'hour_max_sem', 'claim_due_at', 'block_due'], 'required'],
            [['hour_max_month', 'hour_max_sem', 'claim_due_at', 'block_due'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hour_max_month' => 'Hour Max Month',
            'hour_max_sem' => 'Hour Max Sem',
			'claim_due_at' => 'Next Month Day Due', 
			'block_due' => 'Block After Due'
        ];
    }
	
	public function getSetting(){
		return self::findOne(1);
	}
}
