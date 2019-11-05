<?php

namespace backend\modules\project\controllers;

use Yii;
use backend\modules\project\models\Project;
use backend\modules\project\models\ApproveLetterForm;
use backend\modules\project\models\ApproveLetterPrint;
use backend\modules\project\models\ProjectSearch;
use backend\modules\project\models\ProjectApproveSearch;
use backend\modules\project\models\ProjectAllocationSearch;
use backend\modules\project\models\ProjectLetterSearch;
use backend\modules\project\models\ProjectPrint;
use backend\modules\project\models\BatchPrint;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Expression;
use common\models\Model;
use backend\models\Semester;

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
	
	public function actionUpdate($id){
		$model = $this->findModel($id);
		$model->scenario = 'project-admin-edit';
		$days = $model->tentativeDays;
		
		if ($model->load(Yii::$app->request->post())) {
			$model->updated_at = new Expression('NOW()');    
			Model::loadMultiple($days, Yii::$app->request->post());
			
			if($flag = $model->save()){
				
				foreach ($days as $i => $day) {
					if ($flag === false) {
						break;
					}

					if (!($flag = $day->save(false))) {
						break;
					}
				}

				
			}
			Yii::$app->session->addFlash('success', "Data Updated");
			return $this->redirect(['index']);
		}
		
		
		return $this->render('update', [
            'model' => $model,
			'days' => $days
        ]);
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
			$searchModel->default_status = 1;	
		}
        $dataProvider = $searchModel->search($params);
		
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
					$action = $post['btn-action'];
					if($action =='approve'){
						$project->status = 30;
					}else{
						$project->status = 20;
					}
					
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
	
	public function actionLetterPrint($id){
		$model = $this->findModel($id);
		if($model->status == 30){
			$pdf = new ApproveLetterPrint;
		$pdf->model = $model;
		$pdf->generatePdf();
		}else{
			echo 'not yet approved';
		}
		
	}
	
	public function actionLetter()
    {
        $searchModel = new ProjectLetterSearch();
		$params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);
		$model = new ApproveLetterForm;
		if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            if(isset($post['selection'])){
				$selection = $post['selection'];
				$form = $post['ApproveLetterForm'];
				$start = $form['start_number'] + 0;
				foreach($selection as $select){
					$pro = Project::findOne($select);
					$ref = $form['ref_letter'];
					$pro->letter_ref = $ref . '('.$start.')';
					$pro->save();
					
				$start++;
					
				}
			}
		}
		

        return $this->render('letter', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'model' => $model
        ]);
    }
	
	public function actionBatchPdf($batch){
		
		$semester = Semester::getCurrentSemester();
		
		$model = Project::find()
		->where([
			'semester_id' => $semester->id, 
			'status' => 30,
			'batch_no' => $batch])
		->all();
		
		$pdf = new BatchPrint;
		$pdf->model = $model;
		$pdf->batchno = $batch;
		$pdf->semester = $semester;
		$pdf->generatePdf();
	}
	
	public function actionAllocation()
    {
        $searchModel = new ProjectAllocationSearch();
		$post = Yii::$app->request->post();
		if(isset($post['batch_name'])){
			$searchModel->batchno = Yii::$app->request->post('batch_name');
			if(empty(Yii::$app->request->post('batch_name'))){
				 Yii::$app->session->addFlash('error', "Batch No. cannot be empty!");
				return $this->redirect(['allocation']);
			}
		}
		$params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);
		 $model = new ApproveLetterForm;
		if (Yii::$app->request->post()&& isset($post['selection'])) {
				$selection = $post['selection'];
				$batch = $post['batch_name'];
				foreach($selection as $select){
					$pro = Project::findOne($select);
					$pro->batch_no =$batch;
					$pro->save();
				}
			return $this->redirect(['allocation']);
		} 
		

        return $this->render('allocation', [
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
