<?php

namespace backend\modules\project\models;

use Yii;

/**
 * This is the model class for table "pro_exp_tool".
 *
 * @property int $id
 * @property int $pro_id
 * @property string $tool_name
 * @property int $quantity
 * @property string $amount
 *
 * @property Project $pro
 */
class ExpTool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pro_exp_tool';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pro_id', 'tool_name', 'quantity', 'amount'], 'required'],
            [['pro_id', 'quantity'], 'integer'],
            [['amount'], 'number'],
            [['tool_name'], 'string', 'max' => 200],
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
            'tool_name' => 'Tool Name',
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
