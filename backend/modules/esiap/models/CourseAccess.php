<?php

namespace backend\modules\esiap\models;

use Yii;
use backend\modules\staff\models\Staff;

/**
 * This is the model class for table "sp_course_access".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $course_id
 * @property int $acc_order
 * @property string $updated_at
 *
 * @property Staff $staff
 * @property SpCourse $course
 */
class CourseAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sp_course_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id'], 'required'],
            [['staff_id', 'course_id', 'acc_order'], 'integer'],
            [['updated_at'], 'safe'],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::className(), 'targetAttribute' => ['staff_id' => 'id']],
            [['course_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::className(), 'targetAttribute' => ['course_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'course_id' => 'Course ID',
            'acc_order' => 'Acc Order',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourse()
    {
        return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }
}
