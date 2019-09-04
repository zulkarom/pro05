<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_course_clo_assess".
 *
 * @property int $id
 * @property int $clo_id
 * @property int $assess_id
 * @property string $percentage
 */
class CourseCloAssessment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course_clo_assess';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clo_id'], 'required', 'on' => 'fresh'],
			
            [['clo_id', 'assess_id'], 'integer'],
            [['percentage'], 'number'],
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
            'assess_id' => 'Assess ID',
            'percentage' => 'Percentage',
        ];
    }
	
	public function getAssessment(){
        return $this->hasOne(CourseAssessment::className(), ['id' => 'assess_id']);
    }

}
