<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "fasi_type".
 *
 * @property int $id
 * @property string $type_name
 * @property string $rate_perhour
 */
class FasiType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fasi_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_name', 'rate_perhour'], 'required'],
            [['rate_perhour'], 'number'],
            [['type_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_name' => 'Type Name',
            'rate_perhour' => 'Rate Perhour',
        ];
    }
}
