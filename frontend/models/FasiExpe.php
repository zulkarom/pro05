<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "fasi_expe".
 *
 * @property int $id
 * @property int $fasi_id
 * @property string $place
 * @property int $expe_date
 * @property string $field
 */
class FasiExpe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fasi_expe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'place', 'date_start', 'date_end', 'field'], 'required'],
			
            [['fasi_id'], 'integer'],
			
            [['place', 'field'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fasi_id' => 'Fasi ID',
            'place' => 'Place',
            'date_start' => 'Tarikh Mula',
			'date_end' => 'Tarikh Akhir',
            'field' => 'Field',
        ];
    }
}
