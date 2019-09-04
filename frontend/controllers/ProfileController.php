<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\filters\AccessControl;

use common\models\User;
use common\models\Fasi;
use common\models\Model;
use frontend\models\FasiEdu;
use frontend\models\FasiExpe;
use common\models\Upload;

class ProfileController extends \yii\web\Controller
{
	
    public function actionIndex()
    {
		$id = Yii::$app->user->identity->id;
        $model = $this->findFasi($id);
		//$user = User::findOne(['id' => $model->user_id]);
		$model->scenario = 'profile_personal';
		if($model->birth_date =='0000-00-00'){
			$nric = $model->nric;
			$y =  substr($nric, 0, 2); //91
			$curr_year = date('Y') + 0 ;
			$yc = substr($curr_year, 0, 2);
			$yp = $yc - 1; //19
			$year_t1 = ($yc.$y) + 0; // 2091
			if($year_t1 > $curr_year){
				$birth_year = $yp.$y; 
			}else{
				$birth_year = $year_t1;
			}
			
			$month = substr($nric, 2, 2);
			$day = substr($nric, 4, 2);
			$complete =  $birth_year . '-' . $month . '-' . $day;
			
			$model->birth_date = $complete;
			
		}

        if ($model->load(Yii::$app->request->post())) {
			$model->personal_updated_at = new Expression('NOW()');
           if($model->save()){
			   $model->personal_updated_at = date('Y-m-d H:m:s');
			   Yii::$app->session->addFlash('success', "Maklumat peribadi berjaya disimpan.");
		   }
        }

        return $this->render('index', [
            'model' => $model
        ]);

    }
	
	public function actionPreview()
    {
		$id = Yii::$app->user->identity->id;
        $model = $this->findFasi($id);
		
		if ($model->load(Yii::$app->request->post())) {
			if($model->checkCompleted()){
				
				$model->personal_updated_at = new Expression('NOW()');
				$model->job_updated_at = new Expression('NOW()');
				$model->edu_updated_at = new Expression('NOW()');
				$model->expe_updated_at = new Expression('NOW()');
				$model->document_updated_at = new Expression('NOW()');
				$model->updated_at = new Expression('NOW()');
				
				if($model->save()){
					Yii::$app->session->addFlash('success', "Semua maklumat telah dikemaskini");
					$this->redirect(['profile/preview']);
				}
				
			}else{
				Yii::$app->session->addFlash('error', "Terdapat maklumat yang masih belum lengkap.");
			}
			
		}

        return $this->render('preview', [
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
	
	public function actionJob()
    {
        $id = Yii::$app->user->identity->id;
        $model = $this->findFasi($id);
		$model->scenario = 'profile_job';
		//$user = new User;

        if ($model->load(Yii::$app->request->post())) {
			$model->job_updated_at = new Expression('NOW()');
           if($model->save()){
			   $model->job_updated_at = date('Y-m-d H:m:s');
			   Yii::$app->session->addFlash('success', "Maklumat pekerjaan berjaya disimpan.");
		   }
        }

        return $this->render('job', [
            'model' => $model
        ]);
    }
	
	
	public function actionEducation()
    {
		$id = Yii::$app->user->identity->id;
        $model = $this->findFasi($id);
		
		$edus = $model->fasiEdus;
		
		$model->scenario = "profile_edu";
		
		if ($model->load(Yii::$app->request->post())) {
			
			$oldEduIDs = ArrayHelper::map($edus, 'id', 'id');
			
			$edus = Model::createMultiple(FasiEdu::classname());
			
			Model::loadMultiple($edus, Yii::$app->request->post());
			
			$deletedEduIDs = array_diff($oldEduIDs, array_filter(ArrayHelper::map($edus, 'id', 'id')));
			
			$model->edu_updated_at = new Expression('NOW()');
			
			$valid = $model->validate();
			
			$valid = Model::validateMultiple($edus) && $valid;
			
			if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
						
						
						if (! empty($deletedEduIDs)) {
                            FasiEdu::deleteAll(['id' => $deletedEduIDs]);
                        }
						
						foreach ($edus as $indexEdu => $edu) {
							
                            if ($flag === false) {
                                break;
                            }

                            $edu->fasi_id = $model->id;

                            if (!($flag = $edu->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->addFlash('success', "Data pendidikan telah berjaya disimpan.");
						$this->redirect(['profile/education']);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
					
                }
            }
		}
		
		
		return $this->render('education', [
            'model' => $model,
			'education' => (empty($edus)) ? [new FasiEdu] : $edus
        ]);
    }
	
	public function actionExperience()
    {
		$id = Yii::$app->user->identity->id;
        $model = $this->findFasi($id);
		
		//$certs = $model->fasiFiles;
		
		$expes = $model->fasiExpes;
		
		$model->scenario = "profile_expe";
		
		if ($model->load(Yii::$app->request->post())) {
			
			$oldExpeIDs = ArrayHelper::map($expes, 'id', 'id');
			
			$expes = Model::createMultiple(FasiExpe::classname());
			
			Model::loadMultiple($expes, Yii::$app->request->post());
			
			$deletedExpeIDs = array_diff($oldExpeIDs, array_filter(ArrayHelper::map($expes, 'id', 'id')));
			
			$model->expe_updated_at = new Expression('NOW()');
			
			$valid = $model->validate();
			
			$valid = Model::validateMultiple($expes) && $valid;
			
			if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
	
						if (! empty($deletedExpeIDs)) {
                            FasiExpe::deleteAll(['id' => $deletedExpeIDs]);
                        }
						
						foreach ($expes as $indexExpe => $expe) {
							
                            if ($flag === false) {
                                break;
                            }

                            $expe->fasi_id = $model->id;

                            if (!($flag = $expe->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->addFlash('success', "Data pengalaman telah berjaya disimpan.");
						$this->redirect(['profile/experience']);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
					
                }
            }
		}
		
		
		return $this->render('experience', [
            'model' => $model,
			'experience' => (empty($expes)) ? [new FasiExpe] : $expes
        ]);

    }
	
	public function actionImage(){
		
		$attr = 'profile';
		$id = Yii::$app->user->identity->id;
        $model = $this->findFasi($id);
		$attr_db = $attr . '_file';
		
		if($model->{$attr_db}){
			$file = Yii::getAlias('@upload/' . $model->{$attr_db});
		}else{
			$file = Yii::getAlias('@img') . '/user.png';
		}
        
		
			if (file_exists($file)) {
			
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			
			$filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname . '.' . $ext ;
			
			Upload::sendFile($file, $filename, $ext);
			
			}
		
	}

	
	
	
	protected function findFasi($id)
    {
        if (($model = Fasi::findOne(['user_id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	

}
