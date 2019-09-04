<?php

namespace frontend\controllers\user;


use dektrium\user\controllers\SecurityController as BaseSecurityController;
use frontend\models\user\LoginForm;

class SecurityController extends BaseSecurityController
{
   public function actionLogin()
    {
		$this->layout = "//main-login";
		if (!\Yii::$app->user->isGuest) {
            //$this->goHome();
			$this->redirect(['/dashboard/index']);
        }

        /** @var LoginForm $model */
        $model = \Yii::createObject(LoginForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_LOGIN, $event);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            $this->trigger(self::EVENT_AFTER_LOGIN, $event);
			//$this->goHome();
			$this->redirect(['/dashboard/index']);
            //return $this->goBack();
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
		
	}
	
	public function actionLogout()
    {
        $event = $this->getUserEvent(\Yii::$app->user->identity);

        $this->trigger(self::EVENT_BEFORE_LOGOUT, $event);

        \Yii::$app->getUser()->logout();

        $this->trigger(self::EVENT_AFTER_LOGOUT, $event);

        return $this->redirect(['/user/login']);
    }
}
