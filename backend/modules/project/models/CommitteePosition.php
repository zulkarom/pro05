<?php

namespace backend\modules\project\models;

use Yii;

/**
 * This is the model class for table "pro_com_post".
 *
 * @property int $id
 * @property int $pro_id
 * @property string $position
 * @property int $pro_com
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
            [['pro_id', 'position', 'pro_com'], 'required'],
            [['pro_id', 'pro_com'], 'integer'],
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
            'pro_com' => 'Pro Com',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'pro_id']);
    }
}
