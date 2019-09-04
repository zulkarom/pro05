<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\filters\AccessControl;


class CourseController extends \yii\web\Controller
{
	
    public function actionIndex()
    {
		$this->layout = 'website';
        return $this->render('index', [
            
        ]);

    }
	

}
