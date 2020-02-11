<?php

namespace backend\modules\esiap\controllers;

use Yii;
use backend\modules\esiap\models\Program;
use backend\modules\esiap\models\ProgramVersion;
use backend\modules\esiap\models\ProgramVersionSearch;
use backend\modules\esiap\models\ProgramSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use backend\modules\esiap\models\ProgramPic;
use backend\modules\esiap\models\ProgramAccess;
use common\models\Model;
use yii\helpers\ArrayHelper;

/**
 * ProgramController implements the CRUD actions for Program model.
 */
class ProgramAdminController extends Controller
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
	
	public function actionProgramVersion($program)
    {
        $searchModel = new ProgramVersionSearch();
        $dataProvider = $searchModel->search($program, Yii::$app->request->queryParams);
		
		$programModel = $this->findModel($program);

        return $this->render('../program-version/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'program' => $programModel
        ]);
    }
	
	public function actionProgramVersionCreate($program)
    {
        $model = new ProgramVersion();
		$model->scenario = 'create';
		$program_model = $this->findModel($program);

        if ($model->load(Yii::$app->request->post())) {
			$model->program_id = $program;
			$model->created_at = new Expression('NOW()');
			$model->created_by = Yii::$app->user->identity->id;
			if($model->save()){
				Yii::$app->session->addFlash('success', "Version Added");
				return $this->redirect(['program-version', 'program' => $program]);
			}else{
				$model->flashError();
			}
			
            
        }

        return $this->render('../program-version/create', [
            'model' => $model,
			'program' => $program_model
        ]);
    }
	
	public function actionProgramVersionUpdate($id)
    {
		$model = $this->findVersionModel($id);
		$model->scenario = 'update';

        if ($model->load(Yii::$app->request->post())) {
			
			$model->updated_at = new Expression('NOW()');
			
			if($model->is_developed == 1){
				ProgramVersion::updateAll(['is_developed' => 0], ['program_id' => $model->program_id]);
			}
			
			if($model->is_published == 1){
				if($model->status == 20){
					if($model->is_developed ==1){
						Yii::$app->session->addFlash('error', "You can not publish and develop at the same time");
						return $this->redirect(['course-version-update', 'id' => $id]);
					}
					ProgramVersion::updateAll(['is_published' => 0], ['program_id' => $model->program_id]);
				}else{
					Yii::$app->session->addFlash('error', "The status must be verified before publishing");
					return $this->redirect(['program-version-update', 'id' => $id]);
				}
			}
			
			if($model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['program-version', 'program' => $model->program->id]);
			}
            
        }

        return $this->render('../program-version/update', [
            'model' => $model,
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model->scenario = 'update';
		$pics = $model->programPics;
		
		$accesses = $model->programAccesses;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
            
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($pics, 'id', 'id');
            $pics = Model::createMultiple(ProgramPic::classname(), $pics);
            Model::loadMultiple($pics, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($pics, 'id', 'id')));
            foreach ($pics as $i => $pic) {
                $pic->pic_order = $i;
            }
			
			$oldAcIDs = ArrayHelper::map($accesses, 'id', 'id');
            $accesses = Model::createMultiple(ProgramAccess::classname(), $accesses);
            Model::loadMultiple($accesses, Yii::$app->request->post());
            $deletedAcIDs = array_diff($oldAcIDs, array_filter(ArrayHelper::map($accesses, 'id', 'id')));
            foreach ($accesses as $i => $access) {
                $access->acc_order = $i;
            }
            
            $valid = $model->validate();
            $valid = Model::validateMultiple($pics) && $valid;
			$valid = Model::validateMultiple($accesses) && $valid;

			
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            ProgramPic::deleteAll(['id' => $deletedIDs]);
                        }
						if (! empty($deletedAcIDs)) {
                            ProgramAccess::deleteAll(['id' => $deletedAcIDs]);
                        }
                        foreach ($pics as $i => $pic) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $pic->program_id = $model->id;
							$pic->updated_at = new Expression('NOW()');

                            if (!($flag = $pic->save(false))) {
                                break;
                            }
                        }
						
						foreach ($accesses as $i => $access) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $access->program_id = $model->id;
							$access->updated_at = new Expression('NOW()');

                            if (!($flag = $access->save(false))) {
                                break;
                            }
                        }

                    }else{
						$model->flashError();
					}

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Program updated");
                            return $this->redirect(['update','id' => $model->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        }

        return $this->render('update', [
            'model' => $model,
			'pics' => (empty($pics)) ? [new ProgramPic] : $pics,
			'accesses' => (empty($accesses)) ? [new ProgramAccess] : $accesses
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
	
	protected function findVersionModel($id)
    {
        if (($model = ProgramVersion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
