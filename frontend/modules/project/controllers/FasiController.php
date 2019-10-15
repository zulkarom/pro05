<?php

namespace frontend\modules\project\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use common\models\Token;
use backend\modules\project\models\Project;
use yii\filters\AccessControl;
use common\models\Application;

/**
 * FasiController implements the CRUD actions for Project model.
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
     * Lists all Project models.
     * @return mixed
     */
    public function actionChangeKey()
    {
		//kena cari application
		$application = Application::getMyAcceptApplication();
		if($application){
			$model = $application->project;
			if ($model->load(Yii::$app->request->post())) {
				$model->updated_at = new Expression('NOW()');
				$model->pro_token = Token::projectKey();
				if($model->save()){
					Yii::$app->session->addFlash('success', "Data Updated");
					return $this->redirect(['index']);
				}
				
			}

			return $this->render('update', [
				'model' => $model,
			]);
		}else{
			Yii::$app->session->addFlash('error', "Sila pastikan terdapat permohonan fasilitator yang dilulus dan diterima pada semester ini.");
			return $this->redirect('page');
		}
        
    }
	
	 /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
		//kena cari application
		$application = Application::getMyAcceptApplication();
		if($application){
			$model = $application->project;
			if ($model->load(Yii::$app->request->post())) {
				$action = Yii::$app->request->post('wfaction');
				if($action == 'return'){
					$model->status = 0;
				}else if($action == 'submit'){
					$model->status = 20;
				}
				Yii::$app->session->addFlash('success', $action);
				$model->updated_at = new Expression('NOW()');
				if($model->save()){
					Yii::$app->session->addFlash('success', "Data Updated");
					return $this->redirect(['index']);
				}
				
			}

			return $this->render('preview', [
				'model' => $model,
			]);
		}else{
			Yii::$app->session->addFlash('error', "Sila pastikan terdapat permohonan fasilitator yang dilulus dan diterima pada semester ini.");
			return $this->redirect('page');
		}
        
    }
	
	public function actionPage(){
		return $this->render('page');
	}

   
}
