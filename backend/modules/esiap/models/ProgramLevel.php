<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_program_level".
 *
 * @property int $id
 * @property int $code
 * @property string $level_name
 */
class ProgramLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_program_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'level_name'], 'required'],
            [['code'], 'integer'],
            [['level_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'level_name' => 'Level Name',
        ];
    }
}
