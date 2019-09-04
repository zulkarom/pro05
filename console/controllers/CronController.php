<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

/**
 * Site controller
 */
class CronController extends Controller
{
    /* public function actionIndex()
    {
        $location = \backend\models\Location::findOne(1);
		$location->name = date("Y/m/d H:i:s",time());
		if(!$location->save()){
			print_r($location->getErrors());
		}
    } */
	
	public function actionSend()
	{
		Yii::$app->mailqueue->process();
	}

}
