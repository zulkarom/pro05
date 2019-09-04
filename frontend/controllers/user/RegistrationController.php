<?php

namespace frontend\controllers\user;

use dektrium\user\models\RegistrationForm;
use dektrium\user\controllers\RegistrationController as BaseRegistrationController;

class RegistrationController extends BaseRegistrationController
{
    /**
     * Displays the registration page.
     * After successful registration if enableConfirmation is enabled shows info message otherwise
     * redirects to home page.
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionRegister()
    {
		$this->layout = "//main-login";
		return parent::actionRegister();
	}
	
	public function actionResend(){
		$this->layout = "//main-login";
		return parent::actionResend();
	}
	
	public function actionConfirm($id, $code){
		$this->layout = "//main-login";
		return parent::actionConfirm($id, $code);
	}

    
}
