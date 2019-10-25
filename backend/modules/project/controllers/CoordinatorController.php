<?php

namespace backend\modules\project\controllers;

use Yii;
use backend\modules\project\models\Coordinator;
use backend\modules\project\models\Project;
use common\models\Token;
use backend\modules\project\models\CoordinatorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\db\Expression;
use backend\models\Semester;

/**
 * CoordinatorController implements the CRUD actions for Coordinator model.
 */
class CoordinatorController extends Controller
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
     * Lists all Coordinator models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CoordinatorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Coordinator model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

    }

    /**
     * Creates a new Coordinator model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Coordinator();

        if ($model->load(Yii::$app->request->post())) {
			$semester = Semester::getCurrentSemester();
			$model->semester_id = $semester->id;
			$model->created_at = new Expression('NOW()');
			if($model->save()){
				//need to create project
				$project = new Project();
				$project->scenario = 'coor-create';
				$semester = Semester::getCurrentSemester();
				$project->semester_id = $semester->id;
				$project->created_at = new Expression('NOW()');
				$project->date_start = date('Y-m-d');
				$project->date_end = date('Y-m-d');
				$project->application_id = 0;
				$project->coor_id = $model->id;
				$project->pro_token = Token::projectKey();
				if($project->save()){
					return $this->redirect(['index']);
				}else{
					$project->flashError();
				}
				
				
			}
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Coordinator model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Coordinator model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$project = Project::findOne(['coor_id' => $id]);
		if($project){
			$project->delete();
		}
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Coordinator model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Coordinator the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Coordinator::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
