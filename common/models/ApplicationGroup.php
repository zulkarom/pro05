<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "application_group".
 *
 * @property int $id
 * @property int $campus_id
 * @property string $group_name
 */
class ApplicationGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'application_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campus_id', 'group_name'], 'required'],
            [['campus_id'], 'integer'],
            [['group_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'campus_id' => 'Campus ID',
            'group_name' => 'Nama Kumpulan',
        ];
    }
}
