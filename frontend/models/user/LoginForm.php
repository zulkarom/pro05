<?php
namespace frontend\models\user;

use dektrium\user\models\LoginForm as BaseLoginForm;

/**
 * Login form
 */
class LoginForm extends BaseLoginForm
{
	
	public function rules()
    {
        $rules = parent::rules();
		
		$rules['loginLength']  = ['login', 'number', 'message' => '{attribute} mestilah dalam bentuk nombor tanpa "-"'];

        return $rules;
    }
	
	public function attributeLabels()
    {
		$labels = parent::attributeLabels();
		$labels['login'] = 'No. Kad Pengenalan';
        return $labels;
    }
	
	
}
