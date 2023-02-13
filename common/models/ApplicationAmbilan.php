<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "application_ambilan".
 *
 * @property int $id
 * @property string $ambilan_name
 */
class ApplicationAmbilan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application_ambilan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ambilan_name'], 'required'],
            [['ambilan_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ambilan_name' => 'Ambilan Name',
        ];
    }
}
