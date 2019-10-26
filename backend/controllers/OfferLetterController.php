<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use backend\models\Semester;
use backend\models\OfferLetterForm;
use backend\models\OfferLetter;
use backend\models\OfferLetterSearch;
use common\models\Application;
use raoul2000\workflow\validation\WorkflowScenario;

/**
 * ApplicationController implements the CRUD actions for Application model.
 */
class OfferLetterController extends Controller
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
     * Lists all Application models.
     * @return mixed
     */
    public function actionIndex()
    {
		
		
		$searchModel = new OfferLetterSearch();
		$params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);
		
		$model = new OfferLetterForm;
		if ($model->load(Yii::$app->request->post())) {
			$post = Yii::$app->request->post();

			if(isset($post['selection'])){
				$selection = $post['selection'];
				$form = $post['OfferLetterForm'];
				$start = $form['start_number'] + 0;
				foreach($selection as $select){
					$app = Application::findOne($select);
					if($post['actiontype'] == 'release'){
						$app->scenario = WorkflowScenario::enterStatus('e-release');
						//$app->release_at = date('Y-m-d H:i:s');
						$app->released_at = new Expression('NOW()');
						$app->released_by = Yii::$app->user->id;
						$app->sendToStatus('e-release');
					}else if($post['actiontype'] == 'generate'){
						
						
						$ref = $form['ref_letter'];
						$app->ref_letter = $ref . '('.$start.')';
					}
					$app->save();
					
				$start++;
					
				}
			}
			

		}


        return $this->render('index', [
            'dataProvider' => $dataProvider,
			'model' => $model
        ]);
    }
	
	public function actionPdf($id){
		$model = $this->findModel($id);
		$pdf = new OfferLetter;
		$pdf->model = $model;
		$pdf->generatePdf();
	}
	
	public function actionRelease(){
		$sem = Semester::getCurrentSemester()->id;
		$query = Application::find();
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['status'=>SORT_ASC]]
        ]);
		$query->andFilterWhere([
            'semester_id' => $sem,
            'status' => ['ApplicationWorkflow/d-approved', 'ApplicationWorkflow/e-release', 'ApplicationWorkflow/f-accept'],
        ]);
		
		$model = new OfferLetterForm;
		if ($model->load(Yii::$app->request->post())) {
			$post = Yii::$app->request->post();

			if(isset($post['selection'])){
				$selection = $post['selection'];
				foreach($selection as $select){
					$app = Application::findOne($select);
					$app->scenario = WorkflowScenario::enterStatus('e-release');
					//$app->release_at = date('Y-m-d H:i:s');
					$app->released_at = new Expression('NOW()');
					$app->released_by = Yii::$app->user->id;
					$app->sendToStatus('e-release');
					if($app->save()){
						$this->sendEmail($app);
					}
	
					
				}
			}
			

		}


        return $this->render('release', [
            'dataProvider' => $dataProvider,
			'model' => $model
        ]);
	}
	
	public function actionTestEmail($token){
		if($token=='1qaz'){
			$user = Yii::$app->user->identity;
			$name = $user->fullname;
			$email = $user->email;
			$send = Yii::$app->mailqueue->compose(
				['html' => 'release-email-html', 
				'text' => 'release-email-text'],
				['name' => $name]
			)
			 ->setFrom('pusatko.efasi@gmail.com')
			 ->setTo($email)
			 ->setSubject('Surat Tawaran Perlantikan Fasilitator')
			 ->queue();
		}
		

	}
	
	private function sendEmail($app){
		$user = $app->fasi->user;
		$name = $user->fullname;
		$email = $user->email;
		if($app->release_email == 0){
			$send = Yii::$app->mailqueue->compose(
				['html' => 'release-email-html', 
				'text' => 'release-email-text'],
				['name' => $name]
			)
			 ->setFrom('pusatko.efasi@gmail.com')
			 ->setTo($email)
			 ->setSubject('Surat Tawaran Perlantikan Fasilitator')
			 ->queue();
			 
			if($send){
				$app->scenario = 'release_email';
				$app->release_email = 1;
				$app->save();
			}
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
        if (($model = Application::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
