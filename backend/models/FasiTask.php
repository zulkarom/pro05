<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "fasi_task".
 *
 * @property int $id
 * @property string $task_text
 */
class FasiTask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fasi_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_text'], 'required'],
            [['task_text'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_text' => 'Task Text',
        ];
    }
}
