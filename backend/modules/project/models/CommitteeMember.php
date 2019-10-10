<?php

namespace backend\modules\project\models;

use Yii;
use backend\models\Student;

/**
 * This is the model class for table "pro_com_member".
 *
 * @property int $id
 * @property int $position_id
 * @property int $student_id
 * @property int $mem_order
 *
 * @property ProComPost $position
 * @property Student $student
 */
class CommitteeMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pro_com_member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id'], 'required'],
            [['position_id', 'student_id', 'mem_order'], 'integer'],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => CommitteePosition::className(), 'targetAttribute' => ['position_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::className(), 'targetAttribute' => ['student_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position_id' => 'Position ID',
            'student_id' => 'Student ID',
            'mem_order' => 'Mem Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(CommitteePosition::className(), ['id' => 'position_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }
}
