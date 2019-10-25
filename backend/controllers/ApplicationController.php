<?php

namespace backend\controllers;

use Yii;
use common\models\Application;
use common\models\ApplicationCourse;
use backend\models\ApplicationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use raoul2000\workflow\validation\WorkflowScenario;
use backend\models\OfferLetter;
use backend\models\AcceptLetter;
use backend\models\Todo;

/**
 * ApplicationController implements the CRUD actions for Application model.
 */
class ApplicationController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Application models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Application model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		$status = $model->getWfStatus();
		
		switch($status ){
			case 'submit':
				$model->scenario = 'save-verify';
			break;
			
			case 'verified':
				$model->scenario = WorkflowScenario::enterStatus('d-approved');
			break;
		}
		//echo Yii::$app->request->post('form-choice');
			
		switch(Yii::$app->request->post('form-choice')){
			case 'btn-approve':
				return $this->approveApplication($model);
			break;
			
			case 'verify':
				return $this->verifyApplication($model);
			break;
			
			case 'save-verify':
				$this->saveVerify($model);
			break;
		}

		
		
        return $this->render('view', [
            'model' => $model,
        ]);
    }
	
	public function actionAnalysis(){
		return $this->render('analysis', [

        ]);
	}
	
	private function approveApplication($model){
		
		if(Todo::can('approve-application')){
			$model->approved_at = date('Y-m-d H:i:s');
			$model->approved_by = Yii::$app->user->id;
			$model->sendToStatus('d-approved');
			if($model->save()){
				Yii::$app->session->addFlash('success', "Permohonan telah berjaya diluluskan");
				return $this->redirect(['application/index']);
			}
		}else{
			Yii::$app->session->addFlash('error', "Permission Denied!");
		}
		
		return $this->render('view', [
            'model' => $model,
        ]);
	}
	
	private function verifyApplication($model){
		
		if(Todo::can('verify-application')){
			$model->scenario = WorkflowScenario::enterStatus('c-verified');
			
			if ($model->load(Yii::$app->request->post())) {
				$model->verified_at = date('Y-m-d H:i:s');
				$model->verified_by = Yii::$app->user->id;
				
				
				
				ApplicationCourse::updateAll(['is_accepted' => 0], ['application_id' => $model->id]);
				$model->selected_course = Yii::$app->request->post('Application')['selected_course'];
				if($model->selected_course){
					$course = ApplicationCourse::findOne(['application_id' => $model->id, 'course_id'=> $model->selected_course] );
					$course->is_accepted = 1;
					$course->scenario = 'verify';
					if($course->save()){
						$model->sendToStatus('c-verified');
						if($model->save()){
							Yii::$app->session->addFlash('success', "Permohonan telah berjaya disokong");
							return $this->redirect(['application/index']);
						}else{
							$model->flashError();
						}
					}else{
						$course->flashError();
					}
				}else{
					Yii::$app->session->addFlash('error', "No selected course!");
				}
			}
			
			
			
		}else{
			Yii::$app->session->addFlash('error', "Permission Denied!");
		}
		
		return $this->render('view', [
            'model' => $model,
        ]);
	}
	
	private function saveVerify($model){
		
		if(Todo::can('verify-application')){
			if ($model->load(Yii::$app->request->post())) {
				if($model->save()){
					
					ApplicationCourse::updateAll(['is_accepted' => 0], ['application_id' => $model->id]);
					
					$model->selected_course = Yii::$app->request->post('Application')['selected_course'];
					
					if($model->selected_course){
						$course = ApplicationCourse::findOne(['application_id' => $model->id, 'course_id'=> $model->selected_course] );
						$course->is_accepted = 1;
						$course->scenario = 'verify';
						$course->save();
					}
					
					Yii::$app->session->addFlash('success', "Maklumat permohonan telah berjaya disimpan.");	
				}
			}
			
		}else{
			Yii::$app->session->addFlash('error', "Permission Denied!");
		}
	}

    /**
     * Creates a new Application model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Application();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Application model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Application model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionReturnBack($id){
		$model = $this->findModel($id);
		$status = 'g-returned';
		$model->scenario = WorkflowScenario::enterStatus($status);
		$model->returned_at = date('Y-m-d H:i:s');
		$model->returned_by = Yii::$app->user->identity->id;
		$model->sendToStatus($status);
		if($model->save()){
			$this->redirect(['index']);
		}else{
			$this->redirect(['view', 'id' => $model->id]);
		}
		
	}
	
	public function actionReturnVerify($id){
		$model = $this->findModel($id);
		$status = 'b-submit';
		$model->scenario = WorkflowScenario::enterStatus($status);
		$model->sendToStatus($status);
		if($model->save()){
			$this->redirect(['index']);
		}else{
			$this->redirect(['view', 'id' => $model->id]);
		}
		
	}


    /**
     * Finds the Application model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Application the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Application::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionOfferLetter($id){
		$model = $this->findModel($id);
		if($model->wfStatus == 'release' or $model->wfStatus == 'accept'){
			$pdf = new OfferLetter;
			$pdf->model = $model;
			$pdf->generatePdf();
		}
		
	}
	
	public function actionAcceptLetter($id){
		$model = $this->findModel($id);
		if($model->wfStatus == 'accept'){
			$pdf = new AcceptLetter;
			$pdf->model = $model;
			$pdf->generatePdf();
		}
		
	}
}
