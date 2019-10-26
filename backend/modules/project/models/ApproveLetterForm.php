<?php
namespace backend\modules\project\models;

use Yii;
use yii\base\Model;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class ApproveLetterForm extends Model
{
    public $ref_letter;
    public $start_number;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ref_letter', 'start_number'], 'required'],
			[['start_number'], 'integer'],
        ];
    }
	
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ref_letter' => 'Rujukan Surat',
			'start_number' => 'Bermula dari',
        ];
    }

}
