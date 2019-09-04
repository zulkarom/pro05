<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_program_category".
 *
 * @property int $id
 * @property string $cat_name
 */
class ProgramCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_program_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'required'],
            [['cat_name'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_name' => 'Cat Name',
        ];
    }
}
