<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "fasi_edu".
 *
 * @property int $id
 * @property int $fasi_id
 * @property string $institution
 * @property string $year_grad
 * @property int $level
 */
class FasiEdu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fasi_edu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['institution', 'year_grad', 'level', 'edu_name'], 'required'],
            [['fasi_id', 'level'], 'integer'],
            [['year_grad'], 'number'],
            [['institution'], 'string', 'max' => 200],
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
            'institution' => 'Institusi',
            'year_grad' => 'Tahun Graduasi',
			'edu_name' => 'Nama Kelayakan',
            'level' => 'Tahap',
        ];
    }
	
	public function getLevelName()    {
        return $this->hasOne(EducationLevel::className(), ['id' => 'level']);
    }

}
