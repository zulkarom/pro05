<?php

namespace frontend\modules\project\controllers;

use yii\web\Controller;

/**
 * Default controller for the `project` module
 */
class DefaultController extends Controller
{
	public $layout = '//website';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
