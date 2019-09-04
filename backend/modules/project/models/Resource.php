<?php

namespace backend\modules\project\models;

use Yii;

/**
 * This is the model class for table "pro_resource".
 *
 * @property int $id
 * @property int $pro_id
 * @property string $rs_name
 * @property double $rs_quantity
 * @property string $amount
 *
 * @property Project $pro
 */
class Resource extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pro_resource';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pro_id', 'rs_name', 'rs_quantity', 'amount'], 'required'],
            [['pro_id'], 'integer'],
            [['rs_quantity', 'amount'], 'number'],
            [['rs_name'], 'string', 'max' => 200],
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
            'rs_name' => 'Rs Name',
            'rs_quantity' => 'Rs Quantity',
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
