<?php
namespace backend\modules\esiap\models;

use Yii;
use backend\modules\staff\models\Staff;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class VerificationForm extends Staff
{
    public $verified_at;
	public $signiture_instance;
    /**
     * @inheritdoc
     */
    public function rules()
    {
		$rules =  parent::rules();
		$rules[] = [['tbl4_verify_y', 'tbl4_verify_size'], 'number'];
		$rules[] = [['verified_at'], 'required'];
		
		return $rules;
    }

	
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tbl4_verify_y' => 'Table 4 Adj Y', 
			'tbl4_verify_size' =>  'Table 4 Img Size Adj'
        ];
    }
	

}
