<?php

namespace backend\modules\project\models;

use Yii;

/**
 * This is the model class for table "pro_objective".
 *
 * @property int $id
 * @property int $pro_id
 * @property string $obj_text
 * @property int $obj_order
 *
 * @property Project $pro
 */
class Objective extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pro_objective';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['obj_text'], 'required'],
			
            [['pro_id', 'obj_order'], 'integer'],
			
            [['obj_text'], 'string'],
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
            'obj_text' => 'Objektif',
            'obj_order' => 'Obj Order',
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
