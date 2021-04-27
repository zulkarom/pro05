<?php

namespace frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\db\Expression;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Application;
use common\models\ApplicationCourse;
use common\models\Fasi;
use common\models\Model;
use backend\models\Semester;
use backend\models\Course;
use backend\models\OfferLetter;
use backend\models\AcceptLetter;

use raoul2000\workflow\validation\WorkflowScenario;

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
     * Get deserved actions - create , view or note page
     * @return mixed
     */
    public function actionIndex()
    {
		
		//check wheter application exist in above sem condition
		$fasi = Fasi::findOne(['user_id' => Yii::$app->user->identity->id])->id;

		$app = Application::applicationCurrentSemester($fasi);
		
		if($app){
			//klu dah ada go to view
			$status = $app->getWfStatus();
			if($status == 'draft'){
				if(Semester::getOpenDateSemester()){
					$this->redirect(['update', 'id' => $app->id]);
				}else{
					$sem = Semester::getOpenSemester();
					Yii::$app->session->addFlash('info', "Tempoh pendaftaran bagi semester " . $sem->niceFormat() . " adalah dari " . date('d M Y', strtotime($sem->open_at)) . " hingga " . date('d M Y', strtotime($sem->close_at)) . ".");
				}
				
			}else if($status == 'returned'){
				$this->redirect(['update', 'id' => $app->id]);
			}else{
				$this->redirect(['view', 'id' => $app->id]);
			}
			
		}else{
			//go to create
			if($this->validateCreate()){
				$this->redirect(['create']);
			}
		}
		return $this->render('index');
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
		if($status == 'return'){
			return $this->redirect(['application/update', 'id' => $model->id]);
		}else{
			$model->scenario = WorkflowScenario::enterStatus('f-accept');
			if ($model->load(Yii::$app->request->post())) {
				$model->accept_at = new Expression('NOW()');
				$model->sendToStatus('f-accept');
				if($model->save()){
					return $this->redirect(['application/index']);
				}
			}
		
		}
		
		
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Application model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$fasi = Fasi::findOne(['user_id' => Yii::$app->user->identity->id])->id;
		$app = Application::applicationCurrentSemester($fasi);
		if($app){
			$this->redirect(['update', 'id' => $app->id]);
		}else{
			if($this->validateCreate()){
				$this->createEmptyApplication();
			}else{
				$this->redirect(['index']);
			}

			
		}

    }
	
	protected function createEmptyApplication(){
		$fasi = Fasi::findOne(['user_id' => Yii::$app->user->identity->id]);
			$status = 'a-draft';
			
			$model = new Application;

			$model->scenario = WorkflowScenario::enterStatus($status);
			$model->fasi_type_id = 1;
			$model->fasi_id = $fasi->id;
			$model->semester_id = Semester::getOpenDateSemester()->id;
			$model->draft_at = new Expression('NOW()');
			$model->sendToStatus($status);
			if($model->save()){
				$this->redirect(['update', 'id' => $model->id ]);
			}
	}
	
	/* public function actionPreview($id){ //cancelled
		$model = $this->findModel($id);
		$courses = $model->applicationCourses;
		
		 if ($model->load(Yii::$app->request->post())) {
			$status = 'b-submit';
			$model->scenario = WorkflowScenario::enterStatus($status);
			$model->submit_at = new Expression('NOW()');
			$model->sendToStatus($status);
			if($model->save()){
				$this->redirect(['view', 'id' => $model->id ]);
			}
		 }
		
		
		
		return $this->render('preview', [
            'model' => $model,
			'courses' => $courses
        ]);
	} */
	
	
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
		$status = $model->getWfStatus();
		if(Semester::getOpenDateSemester() == false){
			if($status == 'draft'){
				$this->redirect(['index']);
			}else{
				$this->redirect(['view', 'id' => $id]);
			}
			
		}
        
		
		$courses = $model->applicationCourses;

		$model->scenario = 'savedraft';
		

        if ($model->load(Yii::$app->request->post())) {
			$model->draft_at = new Expression('NOW()');
	
            $oldCourseIDs = ArrayHelper::map($courses, 'id', 'id');
			
			$courses = Model::createMultiple(ApplicationCourse::classname());
			
			Model::loadMultiple($courses, Yii::$app->request->post());
			
			$deletedCourseIDs = array_diff($oldCourseIDs, array_filter(ArrayHelper::map($courses, 'id', 'id')));
			
			$valid = $model->validate();
			
			$valid = Model::validateMultiple($courses) && $valid;
			
			if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
						
						if (! empty($deletedCourseIDs)) {
                            ApplicationCourse::deleteAll(['id' => $deletedCourseIDs]);
                        }
						
						foreach ($courses as $indexCourse => $course) {
							
                            if ($flag === false) {
                                break;
                            }
							$course->application_id = $model->id;
							
							
                            if (!($flag = $course->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
						if(Yii::$app->request->post('progress') == 'draft'){
							 Yii::$app->session->addFlash('success', "Maklumat permohonan telah berjaya disimpan sebagai deraf.");
						}
                       
						
						//exit();
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
					
                }
            }
			
			if(Yii::$app->request->post('progress') == 'submit'){
				$status = 'b-submit';
				$model->scenario = WorkflowScenario::enterStatus($status);
				$model->submit_at = new Expression('NOW()');
				$model->sendToStatus($status);
				if($model->save()){
					$this->redirect(['view', 'id' => $model->id ]);
				}
			}
			
        }

        return $this->render('update', [
            'model' => $model,
			'courses' => (empty($courses)) ? [new ApplicationCourse] : $courses
        ]);
    }
	
	public function actionListCourse($component, $campus){
		switch($campus){
			case 1:
				$field = 'campus_1';
			break;
			case 2:
				$field = 'campus_2';
			break;
			case 3:
				$field = 'campus_3';
			break;
		}
		
		$course = Course::find()->where(['component_id' => $component, $field => 1])->all();

		
		if($course){
			return Json::encode($course);
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
		$identity = Yii::$app->user->identity->id;
		$fasi = Fasi::findOne(['user_id' => $identity]);
        if (($model = Application::findOne(['id' => $id, 'fasi_id'=> $fasi->id] )) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function validateCreate(){
		//semester condition open sem
		$sem = Semester::getOpenSemester();
		$user = Yii::$app->user->identity;
		$profile = Fasi::findOne(['user_id' => $user->id]);
		if(!$profile){
			$fasi = new Fasi;
			$fasi->scenario = "signup";
			$fasi->user_id = $user->id;
			$fasi->nric = $user->username;
			if($fasi->save()){
				$profile = $fasi;
			}else{
				return false;
				//
			}
			
			
		}
		if(!$sem){
			Yii::$app->session->addFlash('info', "Tiada sesi semester dibuka untuk pendaftaran.");
			return false;
		}else if(!Semester::getOpenDateSemester()){
			Yii::$app->session->addFlash('info', "Tempoh pendaftaran bagi semester " . $sem->niceFormat() . " adalah dari " . date('d M Y', strtotime($sem->open_at)) . " hingga " . date('d M Y', strtotime($sem->close_at)) . ".");
			return false;
		}else if(!$profile->checkUpdated()){
			Yii::$app->session->addFlash('info', "Maklumat Fasilitator tidak lengkap / atau tidak dikemaskini. Sila pergi ke <a href='".Url::to(['profile/preview']) ."'>Preview Profile</a> untuk kemaskini.");
			return false;
		}else{

			return true;
		}
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
