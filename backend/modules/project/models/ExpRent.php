<?php

namespace backend\modules\project\models;

use Yii;

/**
 * This is the model class for table "pro_exp_rent".
 *
 * @property int $id
 * @property int $pro_id
 * @property string $exp_name
 * @property int $quantity
 * @property string $amount
 *
 * @property Project $pro
 */
class ExpRent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pro_exp_rent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'exp_name', 'quantity'], 'required'],
			
            [['pro_id', 'quantity', 'exp_order'], 'integer'],
			
			[['amount'], 'number'],
            [['exp_name'], 'string', 'max' => 200],
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
            'exp_name' => 'Sewaan',
            'quantity' => 'Kuantiti',
            'amount' => 'Jumlah',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'pro_id']);
    }
}
