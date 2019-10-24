<?php

namespace backend\modules\project\controllers;

use Yii;
use backend\modules\project\models\Project;
use backend\modules\project\models\ProjectSearch;
use backend\modules\project\models\ProjectPrint;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DefaultController implements the CRUD actions for Project model.
 */
class DefaultController extends Controller
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
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
		$params = Yii::$app->request->queryParams;
		if(!isset($params['ProjectSearch'])){
			$params['ProjectSearch']['status_num'] = 20;	
		}
        $dataProvider = $searchModel->search($params);
		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionCoordinator(){
		
	}
	
	public function actionReturn($id){
		$model = $this->findModel($id);
		$model->status = 10;
		if($model->save()){
			Yii::$app->session->addFlash('success', "Kertas kerja telah dikembalikan");
			return $this->redirect(['index']);
		}
	}
	
	public function actionPdf($id){
		$model = $this->findModel($id);
		
		$pdf = new ProjectPrint;
		$pdf->model = $model;
		$pdf->generatePdf();
	}
	
	protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
