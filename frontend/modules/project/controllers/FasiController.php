<?php

namespace frontend\modules\project\controllers;

use Yii;
use backend\modules\project\models\Project;
use frontend\modules\project\models\ProjectSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use common\models\Token;
use backend\models\Semester;
use yii\filters\AccessControl;

/**
 * FasiController implements the CRUD actions for Project model.
 */
class FasiController extends Controller
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
         $model = $this->findModel($id);

		if ($model->load(Yii::$app->request->post())) {
			$model->updated_at = new Expression('NOW()');
			$model->pro_token = Token::projectKey();
			if($model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['index']);
			}
            
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    protected function createProject()
    {
        $model = new Project();
		$model->scenario = 'fasi-create';

        if ($model->load(Yii::$app->request->post())) {
			$model->created_at = new Expression('NOW()');
			$model->fasi_id = Yii::$app->user->identity->id;
			$model->pro_token = Token::projectKey();
			$model->semester_id = Semester::getCurrentSemester()->id;
			if($model->save()){
				//Yii::$app->session->addFlash('success', "Data Updated");
				//return $this->redirect(['index']);
			}
            
        }
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
