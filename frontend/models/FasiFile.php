<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "fasi_file".
 *
 * @property int $id
 * @property int $fasi_id
 * @property string $file_path
 * @property int $type
 */
class FasiFile extends \yii\db\ActiveRecord
{
	public $file_controller;
	public $path_instance;
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fasi_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

			
			//path upload///
			[['path_file'], 'required', 'on' => 'path_upload'],
			[['path_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf, png, jpg, gif', 'maxSize' => 2000000],
			[['updated_at'], 'required', 'on' => 'path_delete'],
			
			
			[['fasi_id', 'updated_at'], 'required', 'on' => 'add_cert'],
			//add_cert
			
			[['fasi_id', 'type'], 'integer'],
            [['path_file'], 'string', 'max' => 255],
			
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fasi_id' => 'Fasi ID',
            'path_file' => 'Muat Naik Sijil',
            'type' => 'Type',
        ];
    }
}
