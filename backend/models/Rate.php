<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "rate".
 *
 * @property int $id
 * @property double $rate_amount
 * @property int $is_active
 */
class Rate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rate_amount'], 'required'],
            [['rate_amount'], 'number'],
            [['is_active'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rate_amount' => 'Rate Amount',
            'is_active' => 'Is Active',
        ];
    }
}
