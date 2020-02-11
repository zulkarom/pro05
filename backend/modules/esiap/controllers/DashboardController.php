<?php

namespace backend\modules\esiap\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class DashboardController extends Controller
{
    /**
     * @inheritdoc
     */
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

    public function actionIndex()
    {
        return $this->render('index', [

        ]);
    }

}
