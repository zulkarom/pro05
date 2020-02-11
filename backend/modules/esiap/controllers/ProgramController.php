<?php

namespace backend\modules\esiap\controllers;

use Yii;
use backend\modules\esiap\models\Program;
use backend\modules\esiap\models\ProgramSearch;
use backend\modules\esiap\models\ProgramStructure;
use backend\modules\esiap\models\ProgramVersion;
use backend\modules\esiap\models\CourseVersion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * ProgramController implements the CRUD actions for Program model.
 */
class ProgramController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Program models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProgramSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new Program model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Program();
		$model->scenario = 'update';

        if ($model->load(Yii::$app->request->post())) {
			$model->faculty_id = Yii::$app->params['faculty_id'];
			if($model->save()){
				return $this->redirect(['index']);
			}
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Program model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($program)
    {
        $model = $this->findModel($program);
		$model->scenario = 'update';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->addFlash('success', "Data Updated");
            return $this->redirect(['update', 'program' => $program]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Program model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
	public function actionDelete($id)
    {
        $model = $this->findModel($id);
		$model->trash = 1;
		$model->save();

        return $this->redirect(['index']);
    }
	
	public function actionPeo(){
		
	}
	
	public function actionStructure($program)
    {
		$model = $this->findDevelopmentVersion($program);
        $dataProvider = new ActiveDataProvider([
            'query' => ProgramStructure::find(),
			'sort'=> ['defaultOrder' => ['year'=>SORT_ASC, 'sem_num'=>SORT_ASC,]],
			'pagination' => [
                'pageSize' => 100,
            ],

        ]);

        return $this->render('../program-structure/index', [
            'dataProvider' => $dataProvider,
			'model' => $model,
        ]);
    }
	
	public function actionStructureCreate($program)
    {
		$model = new ProgramStructure();
		$model->scenario = 'add-course';
		$program = $this->findModel($program);
		$pversion = $this->findDevelopmentVersion($program->id);
		

        if ($model->load(Yii::$app->request->post())) {
			$model->prg_version_id = $pversion->id;
			if($model->save()){
				Yii::$app->session->addFlash('success', "The course has been successfully included.");
				return $this->redirect(['structure', 'program' => $program->id]);
			}
            
        }

        return $this->renderAjax('../program-structure/create', [
            'model' => $model,
			'program' => $program 
        ]);
    }
	
	public function actionStructureUpdate($id)
    {
		$model = $this->findProgramStructure($id);
		$model->scenario = 'add-course';
		$program = $model->programVersion->program_id;
        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				Yii::$app->session->addFlash('success', "Structure Updated");
				return $this->redirect(['structure', 'program' => $program]);
			}
            
        }

        return $this->renderAjax('../program-structure/update', [
            'model' => $model
        ]);
    }
	
	public function actionStructureDelete($id)
    {
		$model = $this->findProgramStructure($id);
		$program = $model->programVersion->program_id;
		$model->delete();
		Yii::$app->session->addFlash('success', "Course Removed");
		return $this->redirect(['structure', 'program' => $program]);
    }
	
	public function actionCourseVersionList($id){
		$list = CourseVersion::find()->where(['course_id' => $id])->orderBy('created_at DESC')->all();
		if($list){
			foreach($list as $ver){
				echo '<option value="'.$ver->id .'">'.$ver->version_name .'</option>';
			}
		}
		
	}
	
	protected function findDevelopmentVersion($id){
		$default = ProgramVersion::findOne(['program_id' => $id, 'is_developed' => 1]);
		if($default){
			return $default;
		}else{
			throw new NotFoundHttpException('Please create development version for this program!');
		}
	}

    /**
     * Finds the Program model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Program the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Program::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findProgramStructure($id)
    {
        if (($model = ProgramStructure::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
