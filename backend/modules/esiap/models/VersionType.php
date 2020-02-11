<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_version_type".
 *
 * @property int $id
 * @property string $type_name
 * @property int $plo_num
 * @property string $plo1
 * @property string $plo2
 * @property string $plo3
 * @property string $plo4
 * @property string $plo5
 * @property string $plo6
 * @property string $plo7
 * @property string $plo8
 * @property string $plo9
 * @property string $plo10
 * @property string $plo11
 * @property string $plo12
 */
class VersionType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sp_version_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type_name', 'plo_num', 'plo1', 'plo2', 'plo3', 'plo4', 'plo5', 'plo6', 'plo7', 'plo8', 'plo9', 'plo10', 'plo11', 'plo12'], 'required'],
            [['plo_num'], 'integer'],
            [['plo1', 'plo2', 'plo3', 'plo4', 'plo5', 'plo6', 'plo7', 'plo8', 'plo9', 'plo10', 'plo11', 'plo12'], 'string'],
            [['type_name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_name' => 'Type Name',
            'plo_num' => 'Plo Num',
            'plo1' => 'Plo1',
            'plo2' => 'Plo2',
            'plo3' => 'Plo3',
            'plo4' => 'Plo4',
            'plo5' => 'Plo5',
            'plo6' => 'Plo6',
            'plo7' => 'Plo7',
            'plo8' => 'Plo8',
            'plo9' => 'Plo9',
            'plo10' => 'Plo10',
            'plo11' => 'Plo11',
            'plo12' => 'Plo12',
        ];
    }
}
