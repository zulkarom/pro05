<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\SemesterForm;
use backend\models\Semester;
use TCPDF;

/**
 * Site controller
 */
class SiteController extends Controller
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
                        'actions' => ['login', 'error', 'test-pdf'],
                        'allow' => true,
						'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'test-pdf'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		$semester = new SemesterForm;
		$semester->action = ['site/index'];
		
		if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
			$sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
			$semester->semester_id = $sem['semester_id'];
		}else{
			$semester->semester_id = Semester::getCurrentSemester()->id;
		}
		
		
        return $this->render('index', [
			'semester' => $semester
		
		]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        } else {
			$this->layout = "//main-login";
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
	public function actionTestPdf(){
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);



//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


$pdf->AddPage();

// Set some content to print
$html = <<<EOD
<h1>Berjaya!</h1>
EOD;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->Output('example_001.pdf', 'I');
		/* $model = $this->findModel($id);
		$pdf = new OfferLetter;
		$pdf->model = $model;
		$pdf->generatePdf(); */
		exit();
	}
}
