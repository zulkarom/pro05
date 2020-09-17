<?php

namespace backend\controllers;

use Yii;
use backend\models\TmplOfferFasi;
use backend\models\TmplOfferFasiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Expression;
use yii\helpers\Json;
use common\models\Upload;


/**
 * TmplOfferFasiController implements the CRUD actions for TmplOfferFasi model.
 */
class TmplOfferFasiController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all TmplOfferFasi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TmplOfferFasiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TmplOfferFasi model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TmplOfferFasi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $new = new TmplOfferFasi();
		$model = $this->findModel($id);
		
		$new->template_name = 'Copy of ' . $model->template_name;
		$new->pengarah = $model->pengarah;
		$new->yg_benar = $model->yg_benar;
		$new->tema = $model->tema;
		$new->nota_elaun = $model->nota_elaun;
		$new->yg_benar = $model->yg_benar;
		$new->per3 = $model->per3;
		$new->per4 = $model->per4;
		$new->signiture_file = $model->signiture_file;
		$new->created_at = new Expression('NOW()');
		
		
			if($new->save()){
				Yii::$app->session->addFlash('success', "A new template has been copied.");
				return $this->redirect(['update', 'id' => $new->id]);
			}


        
    }

    /**
     * Updates an existing TmplOfferFasi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			$model->updated_at = new Expression('NOW()');
			
			if($model->is_active == 1){
				TmplOfferFasi::updateAll(['is_active' => 0], ['<>', 'id', $id]);
			}
			
			if($model->save()){
				Yii::$app->session->addFlash('success', "Template Updated");
				return $this->redirect(['view', 'id' => $model->id]);
			}
			
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TmplOfferFasi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeletex($id)
    {
       /*  $this->findModel($id)->delete();

        return $this->redirect(['index']); */
    }

    /**
     * Finds the TmplOfferFasi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TmplOfferFasi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TmplOfferFasi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionUpload($attr, $id){
		$attr = $this->clean($attr);
		$model = $this->findModel($id);

		return Upload::upload($model, $attr, 'updated_at');

	}
	
	
	public function actionDelete($attr, $id)
	{
		$attr = $this->clean($attr);
        $model = $this->findModel($id);
		$attr_db = $attr . '_file';
		
		$file = Yii::getAlias('@upload/' . $model->{$attr_db});
		
		$model->scenario = $attr . '_delete';
		$model->{$attr_db} = '';
		$model->updated_at = new Expression('NOW()');
		if($model->save()){
			if (is_file($file)) {
				//unlink($file);
				
			}
			
			return Json::encode([
						'good' => 1,
					]);
		}else{
			return Json::encode([
						'errors' => $model->getErrors(),
					]);
		}
		


	}
	
	
	
	public function actionDownload($attr, $id, $identity = true){
		$attr = $this->clean($attr);
		$model = $this->findModel($id);
		$filename = strtoupper($attr) ;
		Upload::download($model, $attr, $filename);
	}
	
	protected function clean($string){
		if(in_array($string, ['signiture'])){
			return $string;
		}
		return false;
	}
}
