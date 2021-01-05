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
use backend\models\pdf\AttendancePortal;
use backend\models\pdf\AttendanceSummary;
use backend\models\excel\MarkExcel;
use backend\modules\esiap\models\Course;
use backend\models\Semester;


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
	
	public function actionUjianApi($a)
    {
		
		/* $model = $this->findApplication($a);
		$api = new Api;
		$api->semester = $model->semester->id;
		$api->subject = $model->acceptedCourse->course->course_code;
		$api->group = $model->applicationGroup->group_name;
		$api->test(); */
		
	
		exit();
    }
	
	public function actionAttendancePortalPdf($a, $id){
		$model = $this->findApplication($a);
		$api = new Api;
		$api->semester = $model->semester->id;
		$api->subject = $model->acceptedCourse->course->course_code;
		$api->group = $model->applicationGroup->group_name;
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
		$api->group = $model->applicationGroup->group_name;
		$response = $api->summary();
		
		/* echo '<pre>';
		print_r($response);
		die();
		exit(); */
		
		$pdf = new AttendanceSummary;
		$pdf->model = $model;
		$pdf->course = $model->acceptedCourse->course;
		$pdf->semester = $model->semester;
		$pdf->group = $model->applicationGroup->group_name;
		$pdf->response = $response;
		$pdf->generatePdf();
	}
	
	public function actionAttendanceSummaryAdminPdf($course, $semester, $group){
		//mgkin validate dulu
		$api = new Api;
		$api->semester = $semester;
		$api->subject = $course;
		$api->group = $group;
		$response = $api->summary();
		
		$pdf = new AttendanceSummary;
		$pdf->course = Course::findOne(['course_code' => $course]);
		$pdf->semester = Semester::findOne($semester);
		$pdf->group = $group;
		$pdf->response = $response;
		$pdf->generatePdf();
	}
	
	public function actionAttendanceSheetPdf($a){
		$model = $this->findApplication($a);
		$api = new Api;
		$api->semester = $model->semester->id;
		$api->subject = $model->acceptedCourse->course->course_code;
		$api->group = $model->applicationGroup->group_name;
		$response = $api->student();
		
		$pdf = new Attendance;
		$pdf->course = $model->acceptedCourse->course;
		$pdf->semester = $model->semester;
		$pdf->group = $model->applicationGroup->group_name;
		$pdf->response = $response;
		$pdf->generatePdf();
	}
	
	public function actionAttendanceSheetAdminPdf($course, $semester, $group){
		$api = new Api;
		$api->semester = $semester;
		$api->subject = $course;
		$api->group = $group;
		$response = $api->student();
	
		$pdf = new Attendance;
		$pdf->course = Course::findOne(['course_code' => $course]);
		$pdf->semester = Semester::findOne($semester);
		$pdf->group = $group;
		$pdf->response = $response;
		$pdf->generatePdf();
	}
	
	public function actionMarkTemplateExcel($a){
		$model = $this->findApplication($a);
		$api = new Api;
		$api->semester = $model->semester->id;
		$code = $model->acceptedCourse->course->course_code;
		$api->subject = $code;
		$api->group = $model->applicationGroup->group_name;
		$response = $api->student();
		
		$xls = new MarkExcel;
		$xls->model = $model;
		$xls->courseName = $model->acceptedCourse->course->course_name;
		$xls->courseCode = $model->acceptedCourse->course->course_code;
		$xls->group = $model->applicationGroup->group_name;
		$xls->fasi = $model->fasi->user->fullname;
		$xls->semester = $model->semester;
		$xls->response = $response;
		$xls->generateExcel();
	}
	
	public function actionMarkTemplateAdminExcel($course, $semester, $group){
		
		$fasi = Application::findFasiNameByCourseCodeAndSemester($course, $semester, $group);
		$course = Course::findOne(['course_code' => $course]);
		$api = new Api;
		$api->subject = $course->course_code;
		$api->group = $group;
		$api->semester = $semester;

		$response = $api->student();
		
		//$mcourse = $course->course_code . ' ' . $course->course_name;
		
		$xls = new MarkExcel;
		//$xls->model = $model;
		$xls->courseName = $course->course_name;
		$xls->courseCode = $course->course_code;
		$xls->group = $group;
		$xls->fasi = $fasi['fasiname'];
		$xls->semester = Semester::findOne($semester);
		$xls->response = $response;
		$xls->generateExcel();
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
