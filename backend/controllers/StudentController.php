<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use common\models\Application;
use backend\models\Api;
use backend\models\pdf\Attendance;
use backend\models\pdf\AttendancePortal;
use backend\models\pdf\AttendanceSummary;

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
		$api->group = $model->groupName;
		$response = $api->student();
		
	
		return $this->render('index', [
            'model' => $model,
			'response' => $response,
        ]);
    }
	
	public function actionAttendancePortalPdf($a, $id){
		$model = $this->findApplication($a);
		$api = new Api;
		$api->semester = $model->semester->id;
		$api->subject = $model->acceptedCourse->course->course_code;
		$api->group = $model->groupName;
		$api->id = $id;
		$response = $api->attend();
		
		$pdf = new AttendancePortal;
		$pdf->model = $model;
		$obj = $api->getClassDate($id);
		$pdf->date = $obj->date;
		$pdf->venue = $obj->venue;
		$pdf->venue_code = $obj->venue_code;
		$pdf->start_time = $obj->start_time;
		$pdf->duration = $obj->duration;
		$pdf->response = $response;
		$pdf->generatePdf();
	}
	
	public function actionAttendanceSummaryPdf($a){
		$model = $this->findApplication($a);
		$api = new Api;
		$api->semester = $model->semester->id;
		$api->subject = $model->acceptedCourse->course->course_code;
		$api->group = $model->groupName;
		$response = $api->summary();
		
		/* echo '<pre>';
		print_r($response);
		exit(); */
		
		$pdf = new AttendanceSummary;
		$pdf->model = $model;
		$pdf->response = $response;
		$pdf->generatePdf();
	}
	
	public function actionAttendanceSheetPdf($a){
		$model = $this->findApplication($a);
		$api = new Api;
		$api->semester = $model->semester->id;
		$api->subject = $model->acceptedCourse->course->course_code;
		$api->group = $model->groupName;
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
