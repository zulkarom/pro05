<?php

namespace backend\modules\project\models;

use Yii;

/**
 * This is the model class for table "room".
 *
 * @property int $id
 * @property int $house_id
 * @property string $description
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['house_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'house_id' => 'Hourse ID',
            'description' => 'Description',
        ];
    }
}
