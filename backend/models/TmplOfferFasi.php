<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tmpl_offer_fasi".
 *
 * @property int $id
 * @property string $template_name
 * @property string $pengarah
 * @property string $yg_benar
 * @property string $tema
 * @property string $nota_elaun
 * @property string $per3
 * @property string $per4
 * @property string $is_active
 * @property string $created_at
 * @property string $updated_at
 */
class TmplOfferFasi extends \yii\db\ActiveRecord
{
	public $signiture_instance;
	public $file_controller = 'tmpl-offer-fasi';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tmpl_offer_fasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['template_name', 'pengarah', 'yg_benar', 'tema', 'nota_elaun', 'per3', 'per4', 'is_active', 'created_at', 'updated_at'], 'required'],
            [['nota_elaun', 'per3', 'per4'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['template_name', 'yg_benar'], 'string', 'max' => 200],
            [['pengarah', 'tema'], 'string', 'max' => 300],
			
            [['is_active', 'background_file'], 'integer'],
			
			[['adj_x'], 'number'],
			[['adj_y'], 'number'],
			
			[['signiture_file'], 'required', 'on' => 'signiture_upload'],
            [['signiture_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'signiture_delete'],
			
			
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_name' => 'Nama Template',
            'pengarah' => 'Name Pengarah',
            'yg_benar' => 'Yang menjalanakan tugas',
            'tema' => 'Daulat Raja',
            'nota_elaun' => 'Nota Elaun',
            'per3' => 'Perkara 3',
            'per4' => 'Perkara 4',
            'is_active' => 'Default',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'background_file' => 'Letterhead',
            'signiture' => 'Signature',
        ];
    }
}
