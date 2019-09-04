<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\db\Expression;
use yii\filters\AccessControl;

use frontend\models\FasiFile;
use common\models\Upload;
use common\models\Fasi;


class CertificateController extends \yii\web\Controller
{
	
    public function actionIndex()
    {
		/* $id = Yii::$app->user->identity->id;
        $model = $this->findCert($id);
		
		return $this->render('index', [
		'model' => $model
		]); */

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
	
	public function actionDeleteRow($id){
		$model = $this->findCert($id);
		if($model->delete()){
			$this->redirect(['document/index']);
		}
	}
	
	public function actionUpload($attr, $id){
		$attr = $this->clean($attr);
        $model = $this->findCert($id);
		$model->file_controller = 'certificate';
		
		return Upload::upload($model, $attr, 'updated_at');

	}
	
	
	public function actionDelete($attr, $id)
	{
		$attr = $this->clean($attr);
        $model = $this->findCert($id);
		$attr_db = $attr . '_file';
		
		$file = Yii::getAlias('@upload/' . $model->{$attr_db});

		if($model->delete()){
			if (is_file($file)) {
				unlink($file);
				
			}
			
			return Json::encode([
						'good' => 2,
					]);
			
		}else{
			return Json::encode([
						'errors' => $model->getErrors(),
					]);
		}
		


	}
	
	
	
	public function actionDownload($attr, $id){
		$attr = $this->clean($attr);
        $model = $this->findCert($id);
		$filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
		
		
		
		Upload::download($model, $attr, $filename);
	}
	
	public function actionAdd(){
		$model = new FasiFile;
		$model->scenario = 'add_cert';
		
		$model->fasi_id = Fasi::findOne(['user_id' => Yii::$app->user->identity->id])->id;
		$model->updated_at = new Expression('NOW()');
		
		if(!$model->save()){
			Yii::$app->session->addFlash('error', "Add Cert failed!");
		}
		return $this->redirect(['document/index']);
	}
	
	
	protected function findCert($id)
    {
        if (($model = FasiFile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function clean($string){
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	}
	
	
	

}
