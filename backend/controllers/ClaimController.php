<?php

namespace backend\controllers;

use Yii;
use common\models\Claim;
use backend\models\ClaimSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\ClaimFile;
use common\models\Upload;
use raoul2000\workflow\validation\WorkflowScenario;
use yii\db\Expression;
use backend\models\Todo;
use backend\models\ClaimPrint;
use backend\models\ClaimAnalysisSearch;
use common\models\Application;
use yii\data\ActiveDataProvider;
use backend\models\SemesterForm;
use backend\models\Semester;

/**
 * ClaimController implements the CRUD actions for Claim model.
 */
class ClaimController extends Controller
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
     * Lists all Claim models.
     * @return mixed
     */
    public function actionIndex()
    {
		$semester = new SemesterForm;
		$semester->action = ['claim/index'];
		
		if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
			$sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
			$semester->semester_id = $sem['semester_id'];
		}else{
			$semester->semester_id = Semester::getCurrentSemester()->id;
		}
		
		
        $searchModel = new ClaimSearch();
		$searchModel->selected_sem = $semester->semester_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'semester' => $semester
        ]);
    }
	
	/**
     * Lists all Fasilitors with their claims information.
     * @return mixed
     */
    public function actionAnalysis()
    {
		$semester = new SemesterForm;
		$semester->action = ['claim/analysis'];
		
		if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
			$sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
			$semester->semester_id = $sem['semester_id'];
		}else{
			$semester->semester_id = Semester::getCurrentSemester()->id;
		}

		$searchModel = new ClaimAnalysisSearch();
		$searchModel->selected_sem = $semester->semester_id;
        $dataProvider = $searchModel->search(Yii::$app->request->post());
		
		/* print_r(Yii::$app->request->post());
		
		print_r(Yii::$app->request->queryParams); */

        return $this->render('analysis', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'semester' => $semester
        ]);
    }

    /**
     * Displays a single Claim model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		$items = $model->claimItems;
		
		if ($model->load(Yii::$app->request->post())) {
			if(Yii::$app->request->post('wfaction') == 'btn-return'){
				if(Todo::can('return-claim')){
					$model->scenario = WorkflowScenario::enterStatus('cc-returned');
					$model->returned_at = new Expression('NOW()');
					$model->returned_by = Yii::$app->user->identity->id;
					$model->sendToStatus('cc-returned');
					if($model->save()){
						$this->redirect(['claim/index']);
					}
				}else{
					Yii::$app->session->addFlash('error', "No access to verify claim");
				}
			}else{
				Yii::$app->session->addFlash('error', "no action");
			}
		}else{
			//Yii::$app->session->addFlash('error', "no post");
		}
		
		
        return $this->render('view', [
            'model' => $model,
			'items' => $items
        ]);
    }
	
	public function actionDownload($attr, $id){
		$attr = $this->clean($attr);
        $model = $this->findClaimFile($id);
		$filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
		
		
		
		Upload::download($model, $attr, $filename);
	}
	
	protected function clean($string){
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	}
	
	protected function findClaimFile($id)
    {
        if (($model = ClaimFile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	

    /**
     * Creates a new Claim model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Claim();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Claim model.
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
     * Deletes an existing Claim model.
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
	
	public function actionClaimPrint($id){
		$model = $this->findModel($id);
		if($model->wfStatus <> 'draft'){
			$pdf = new ClaimPrint;
			$pdf->model = $model;
			$pdf->generatePdf();
		}
		
	}

    /**
     * Finds the Claim model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Claim the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Claim::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
