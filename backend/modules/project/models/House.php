<?php

namespace backend\modules\project\models;

use Yii;

/**
 * This is the model class for table "house".
 *
 * @property int $id
 * @property int $person_id
 * @property string $description
 *
 * @property Person $person
 */
class House extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
			
            [['person_id'], 'integer'],
            [['description'], 'string', 'max' => 255],
			
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['person_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'person_id' => 'Person ID',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }
	
	public function getRooms()
    {
        return $this->hasMany(Room::className(), ['house_id' => 'id']);
    }
}
