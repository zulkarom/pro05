<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_course_clo_delivery".
 *
 * @property int $id
 * @property int $clo_id
 * @property int $delivery_id
 *
 * @property SpCourseClo $clo
 * @property SpCourseDelivery $delivery
 */
class CourseCloDelivery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course_clo_delivery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clo_id', 'delivery_id'], 'required'],
            [['clo_id', 'delivery_id'], 'integer'],
            [['clo_id'], 'exist', 'skipOnError' => true, 'targetClass' => CourseClo::className(), 'targetAttribute' => ['clo_id' => 'id']],
            [['delivery_id'], 'exist', 'skipOnError' => true, 'targetClass' => CourseDelivery::className(), 'targetAttribute' => ['delivery_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'clo_id' => 'Clo ID',
            'delivery_id' => 'Delivery ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClo()
    {
        return $this->hasOne(CourseClo::className(), ['id' => 'clo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDelivery()
    {
        return $this->hasOne(CourseDelivery::className(), ['id' => 'delivery_id']);
    }
}
