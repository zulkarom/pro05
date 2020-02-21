<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use common\models\Application;
use backend\models\Api;
use backend\models\pdf\Attendance;

/**
 * Site controller
 */
class StudentController extends Controller
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
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($a)
    {
		$model = $this->findApplication($a);
		$api = new Api;
		$api->semester = $model->semester->id;
		$api->subject = $model->acceptedCourse->course->course_code;
		$api->group = $model->applicationGroup->group_name;
		$response = $api->student();
		
	
		return $this->render('index', [
            'model' => $model,
			'response' => $response,
        ]);
    }
	
	public function actionAttendanceSheetPdf($a){
		$model = $this->findApplication($a);
		$api = new Api;
		$api->semester = $model->semester->id;
		$api->subject = $model->acceptedCourse->course->course_code;
		$api->group = $model->applicationGroup->group_name;
		$response = $api->student();
		
		
		$pdf = new Attendance;
		$pdf->model = $model;
		$pdf->response = $response;
		$pdf->generatePdf();
	}
	
	protected function findApplication($id)
	{
		if (($model = Application::findOne($id)) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
	
	/**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   
	
	
}
