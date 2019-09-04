<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_assessment_cat".
 *
 * @property int $id
 * @property string $cat_name
 * @property string $cat_name_bi
 * @property int $form_sum
 * @property int $is_direct
 */
class AssessmentCat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_assessment_cat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name', 'cat_name_bi', 'form_sum', 'is_direct'], 'required'],
            [['form_sum', 'is_direct'], 'integer'],
            [['cat_name', 'cat_name_bi'], 'string', 'max' => 100],
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
            'cat_name_bi' => 'Cat Name Bi',
            'form_sum' => 'Form Sum',
            'is_direct' => 'Is Direct',
        ];
    }
}
