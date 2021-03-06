<?php

namespace backend\modules\project\models;

use Yii;
use backend\models\Student;

/**
 * This is the model class for table "pro_committee_main".
 *
 * @property int $id
 * @property int $pro_id
 * @property string $position
 * @property int $student_id
 * @property int $com_order
 *
 * @property Project $pro
 */
class CommitteeMain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pro_com_main';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['position', 'student_id'], 'required'],
            [['pro_id', 'student_id', 'com_order'], 'integer'],
            [['position'], 'string', 'max' => 200],
            [['pro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['pro_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pro_id' => 'Pro ID',
            'position' => 'Jawatankuasa',
            'student_id' => 'Pelajar',
            'com_order' => 'Com Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'pro_id']);
    }
	
	public function getStudent()
    {
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }
}
