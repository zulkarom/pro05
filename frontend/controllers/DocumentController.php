<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\Expression;
use yii\filters\AccessControl;

use common\models\Fasi;
use common\models\Upload;


class DocumentController extends \yii\web\Controller
{
	
    public function actionIndex()
    {
		$id = Yii::$app->user->identity->id;
        $model = $this->findFasi($id);
		
		if ($model->load(Yii::$app->request->post())) {
			$model->document_updated_at = new Expression('NOW()');
           if($model->save()){
			   $model->document_updated_at = date('Y-m-d H:m:s');
			   Yii::$app->session->addFlash('success', "Maklumat dokumen berjaya disimpan.");
		   }
        }
		
		return $this->render('index', [
		'model' => $model
		]);

    }
	
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
	

	
	public function actionUpload($attr, $id){
		$attr = $this->clean($attr);
		
		$id = Yii::$app->user->identity->id;
        $model = $this->findFasi($id);
		$model->file_controller = 'document';

		return Upload::upload($model, $attr, 'document_updated_at');

	}
	
	
	public function actionDelete($attr, $id)
	{
		$attr = $this->clean($attr);
		$id = Yii::$app->user->identity->id;
        $model = $this->findFasi($id);
		$attr_db = $attr . '_file';
		
		$file = Yii::getAlias('@upload/' . $model->{$attr_db});
		
		$model->scenario = $attr . '_delete';
		$model->{$attr_db} = '';
		$model->updated_at = new Expression('NOW()');
		if($model->save()){
			if (is_file($file)) {
				unlink($file);
				
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
		if($identity){
			$id = Yii::$app->user->identity->id;
		}
        $model = $this->findFasi($id);
		$filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
		
		
		
		Upload::download($model, $attr, $filename);
	}
	
	public function actionAddCert(){
		$id = Yii::$app->user->identity->id;
        $model = $this->findFasi($id);
		
		
	}
	

	
	protected function findFasi($id)
    {
        if (($model = Fasi::findOne(['user_id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function clean($string){
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	}
	
	
	

}
