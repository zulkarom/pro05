<?php

namespace frontend\modules\project\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\project\models\Project;
use backend\models\Semester;
use yii\db\Expression;

/**
 * Default controller for the `project` module
 */
class UpdateController extends Controller
{
	public $layout = '//website';
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($token)
    {
		$model = $this->findModel($token);
		if($model){
			$model->scenario = 'update-main';
		
			if ($model->load(Yii::$app->request->post())) {
				$model->updated_at = new Expression('NOW()');
				
				if($model->save()){
					Yii::$app->session->addFlash('success', "Data Updated");
					return $this->redirect(['index', 'token' => $token]);
				}
				
			}
			
			
			return $this->render('index', [
				'model' => $model
			
			]);
		}else{
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
		
    }
	
	public function actionCommittee($token)
    {
		$model = $this->findModel($token);
		$model->scenario = 'update-student';
		
		if ($model->load(Yii::$app->request->post())) {
			$model->updated_at = new Expression('NOW()');
			
			if($model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['index', 'token' => $token]);
			}
            
        }
		
		
        return $this->render('committee', [
			'model' => $model
		
		]);
    }
	
	public function actionTentative($token)
    {
		$model = $this->findModel($token);
		$model->scenario = 'update-student';
		
		if ($model->load(Yii::$app->request->post())) {
			$model->updated_at = new Expression('NOW()');
			
			if($model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['index', 'token' => $token]);
			}
            
        }
		
		
        return $this->render('tentative', [
			'model' => $model
		
		]);
    }
	
	
	
	protected function findModel($token)
    {
		$semester = Semester::getCurrentSemester();
		$model = Project::find()
		->innerJoin('application', 'application.id = project.application_id')
		->where([
			'pro_token' => $token, 
			'application.semester_id' => $semester->id])
		->one();
		if($model){
			
			return $model;
		}else{
			return false;
			
		}
		
		
    }
}
