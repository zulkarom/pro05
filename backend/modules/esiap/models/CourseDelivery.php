<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_course_delivery".
 *
 * @property int $id
 * @property string $delivery_name
 * @property string $delivery_name_bi
 * @property int $is_main
 *
 * @property SpCourseCloDelivery[] $spCourseCloDeliveries
 */
class CourseDelivery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course_delivery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_name', 'delivery_name_bi', 'is_main'], 'required'],
            [['is_main'], 'integer'],
            [['delivery_name', 'delivery_name_bi'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery_name' => 'Delivery Name',
            'delivery_name_bi' => 'Delivery Name Bi',
            'is_main' => 'Is Main',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseCloDeliveries()
    {
        return $this->hasMany(CourseCloDelivery::className(), ['delivery_id' => 'id']);
    }
	
	public static function getMainDeliveries(){
		return self::find()->where(['is_main' => 1])->all();
	}
	
	public static function getOtherDeliveries(){
		return self::find()->where(['is_main' => 0])->all();
	}
}
