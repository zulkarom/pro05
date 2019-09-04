<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "component".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class Component extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'component';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Component',
            'description' => 'Description',
        ];
    }
}
