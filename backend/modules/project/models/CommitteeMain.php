<?php

namespace backend\modules\project\models;

use Yii;

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
            'position' => 'Position',
            'student_id' => 'Student ID',
            'com_order' => 'Com Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPro()
    {
        return $this->hasOne(Project::className(), ['id' => 'pro_id']);
    }
}
