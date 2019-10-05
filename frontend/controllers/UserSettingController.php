<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\ChangePasswordForm;
use common\models\User;
use yii\web\NotFoundHttpException;


class UserSettingController extends \yii\web\Controller
{
	
    public function actionIndex()
    {
		

    }
	
	
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}
	
		/**
	 * Change User password.
	 *
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionChangePassword()
	{
		$id = Yii::$app->user->id;
	 
		try {
			$model = new ChangePasswordForm($id);
		} catch (InvalidParamException $e) {
			throw new \yii\web\BadRequestHttpException($e->getMessage());
		}
	 
		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->changePassword()) {
			Yii::$app->session->setFlash('success', 'Password Changed!');
		}
	 
		return $this->render('change-password', [
			'model' => $model,
		]);
	}
	
	
	

}
