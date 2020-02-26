<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "claim_file".
 *
 * @property int $id
 * @property int $claim_id
 * @property int $claim_file
 * @property string $updated_at
 */
class ClaimFile extends \yii\db\ActiveRecord
{
	public $file_controller;
	public $claim_instance;
	
	                                               
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'claim_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		
			//claim upload///
			
			[['claim_file'], 'required', 'on' => 'claim_upload'],
			
			[['claim_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, png, jpg, gif', 'maxSize' => 5000000],
			[['updated_at'], 'required', 'on' => 'claim_delete'],
			
			
			[['claim_id', 'updated_at'], 'required', 'on' => 'add_file'],
			//add_cert

            [['claim_id'], 'integer'],

            [['claim_file'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'claim_id' => 'Claim ID',
            'claim_file' => 'Muat Naik Kehadiran',
            'updated_at' => 'Updated At',
        ];
    }
}
