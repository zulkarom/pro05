<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_study_mode".
 *
 * @property int $id
 * @property string $mode_name
 * @property string $mode_name_bi
 */
class StudyMode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_study_mode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mode_name', 'mode_name_bi'], 'required'],
            [['mode_name'], 'string', 'max' => 50],
            [['mode_name_bi'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mode_name' => 'Mode Name',
            'mode_name_bi' => 'Mode Name Bi',
        ];
    }
}
