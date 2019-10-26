<?php

namespace frontend\modules\project\controllers;

use Yii;
use backend\modules\project\models\Coordinator;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use common\models\Token;
use backend\modules\project\models\Project;
use yii\filters\AccessControl;
use common\models\Application;
use backend\models\Semester;

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
	
	public function actionCoordinator(){
		$semester = Semester::getCurrentSemester();
		$fasi = Yii::$app->user->identity->fasi->id;
		$dataProvider = new ActiveDataProvider([
            'query' => Coordinator::find()
			->where(['fasi_id' => $fasi, 'semester_id' => $semester->id]
			),
        ]);

        return $this->render('coordinator', [
            'dataProvider' => $dataProvider,
        ]);
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
					return $this->redirect(['change-key']);
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
					$model->checked_at = new Expression('NOW()');
					$model->status = 20;
				}
				
				
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
	
	public function actionCoorKey($id)
    {
		$fasi = Yii::$app->user->identity->fasi->id;
		$model = Project::find()
		->joinWith('coordinator')
		->where(['project.id' => $id ,'fasi_id' => $fasi])
		->one();
		if($model){
			if ($model->load(Yii::$app->request->post())) {
				$model->updated_at = new Expression('NOW()');
				$model->pro_token = Token::projectKey();
				if($model->save()){
					Yii::$app->session->addFlash('success', "Data Updated");
					return $this->redirect(['coor-key', 'id' => $id]);
				}
				
			}

			return $this->render('update', [
				'model' => $model,
			]);
		}else{
			Yii::$app->session->addFlash('error', "Access Denied");
			return $this->redirect('coordinator');
		}
        
    }
	
	public function actionCoorView($id)
    {
		$fasi = Yii::$app->user->identity->fasi->id;
		$model = Project::find()
		->joinWith('coordinator')
		->where(['project.id' => $id ,'fasi_id' => $fasi])
		->one();
		if($model){
			if ($model->load(Yii::$app->request->post())) {
				$action = Yii::$app->request->post('wfaction');
				if($action == 'return'){
					$model->status = 0;
				}else if($action == 'submit'){
					$model->status = 20;
				}

				$model->updated_at = new Expression('NOW()');
				if($model->save()){
					Yii::$app->session->addFlash('success', "Data Updated");
					return $this->redirect(['coor-view', 'id' => $id]);
				}
				
			}

			return $this->render('preview', [
				'model' => $model,
			]);
		}else{
			Yii::$app->session->addFlash('error', "Access Denied.");
			return $this->redirect('coordinator');
		}
        
    }
	
	public function actionPage(){
		return $this->render('page');
	}

   
}
