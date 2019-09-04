<?php

namespace backend\controllers;

use Yii;
use common\models\Fasi;
use common\models\User;
use backend\models\FasiSearch;
use backend\models\UserToken;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * FasiController implements the CRUD actions for Fasi model.
 */
class FasiController extends Controller
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


    /**
     * Lists all Fasi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FasiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Fasi model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
	/**
     * Displays a single Fasi model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionLoginFasi($id)
    {
		$token = new UserToken;
		$token->user_id = $id;
		$token->token = Yii::$app->security->generateRandomString();
		$token->created_at = time();
		if($token->save()){
			return $this->redirect(Yii::$app->urlManager->createUrl('./../site/fasi-login?id='.$id.'&token='.$token->token));
		}
    }
	
	
    /**
     * Finds the Fasi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Fasi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fasi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
