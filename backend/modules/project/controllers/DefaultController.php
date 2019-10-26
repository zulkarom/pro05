<?php

namespace backend\modules\project\controllers;

use Yii;
use backend\modules\project\models\Project;
use backend\modules\project\models\ApproveLetterForm;
use backend\modules\project\models\ProjectSearch;
use backend\modules\project\models\ProjectApproveSearch;
use backend\modules\project\models\ProjectPrint;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Expression;

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
		
		if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            if(isset($post['selection'])){
                $selection = $post['selection'];
                foreach($selection as $select){
                    $project = Project::findOne($select);
					$project->approved_at = new Expression('NOW()');
					$project->status = 30;
					$project->save();


				}
			}
		}
		

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionApprove()
    {
        $searchModel = new ProjectApproveSearch();
		$params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);
		
		if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            if(isset($post['selection'])){
                $selection = $post['selection'];
                foreach($selection as $select){
                    $project = Project::findOne($select);
					$project->approved_at = new Expression('NOW()');
					$project->status = 30;
					$project->save();
				}
				Yii::$app->session->addFlash('success', "Data Updated");
			}
		}
		

        return $this->render('approve', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionLetter()
    {
        $searchModel = new ProjectApproveSearch();
		$params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);
		$model = new ApproveLetterForm;
		if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            if(isset($post['selection'])){
                $selection = $post['selection'];
                foreach($selection as $select){
                    $project = Project::findOne($select);
					$project->approved_at = new Expression('NOW()');
					$project->status = 30;
					$project->save();
				}
				Yii::$app->session->addFlash('success', "Data Updated");
			}
		}
		

        return $this->render('letter', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'model' => $model
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
