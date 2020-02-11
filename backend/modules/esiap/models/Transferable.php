<?php

namespace backend\modules\esiap\models;

use Yii;

/**
 * This is the model class for table "sp_transferable".
 *
 * @property int $id
 * @property string $transferable_text
 * @property string $transferable_text_bi
 */
class Transferable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sp_transferable';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['transferable_text', 'transferable_text_bi'], 'required'],
            [['transferable_text', 'transferable_text_bi'], 'string'],
        ];
    }
	
	public function getTransferableText(){
		return $this->transferable_text . ' / ' .  $this->transferable_text_bi;
	}

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transferable_text' => 'Transferable Text',
            'transferable_text_bi' => 'Transferable Text Bi',
        ];
    }
}
