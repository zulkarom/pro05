<?php

namespace backend\modules\project\models;

use Yii;

/**
 * This is the model class for table "pro_exp_rent".
 *
 * @property int $id
 * @property int $pro_id
 * @property string $rent_name
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
            [['pro_id', 'rent_name', 'quantity', 'amount'], 'required'],
            [['pro_id', 'quantity'], 'integer'],
            [['amount'], 'number'],
            [['rent_name'], 'string', 'max' => 200],
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
            'rent_name' => 'Rent Name',
            'quantity' => 'Quantity',
            'amount' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPro()
    {
        return $this->hasOne(Project::className(), ['id' => 'pro_id']);
    }
}
