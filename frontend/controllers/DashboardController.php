<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use backend\models\Semester;
use common\models\Application;
use common\models\Token;
use backend\modules\project\models\Project;
/**
 * Site controller
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



    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		$semester = Semester::getCurrentSemester();
		$application = Application::getMyAcceptApplication();
		$prv_application = Application::getMyAcceptPrvApplication();
		
        return $this->render('index', [
			'semester' => $semester,
			'application' => $application,
            'prv_application' => $prv_application
		]);
    }
	
	/**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   
	
	
}
