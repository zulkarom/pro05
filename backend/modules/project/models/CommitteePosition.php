<?php

namespace backend\modules\project\models;

use Yii;

/**
 * This is the model class for table "post_order_post".
 *
 * @property int $id
 * @property int $pro_id
 * @property string $position
 * @property int $post_order
 *
 * @property Project $pro
 */
class CommitteePosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pro_com_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'position'], 'required'],
            [['pro_id', 'post_order'], 'integer'],
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
            'position' => 'Jawantankuasa',
            'post_order' => 'Pro Com',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'pro_id']);
    }
	
	public function getCommitteeMembers()
    {
        return $this->hasMany(CommitteeMember::className(), ['position_id' => 'id']);
    }
}
