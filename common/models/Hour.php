<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hour".
 *
 * @property int $id
 * @property string $hour_format
 */
class Hour extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hour';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
			[['hour_val'], 'number'],
            [['hour_format'], 'string', 'max' => 6],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hour_format' => 'Hour Format',
        ];
    }
	
	public static function listHoursArray(){
		$list = self::find()->orderBy('hour_val')->all();
		$array = array();
		foreach($list as $item){
			$array[''.$item->hour_val.''] = $item->hour_format;
		}
		return $array;
	}
}
