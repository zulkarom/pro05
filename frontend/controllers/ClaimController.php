<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\db\Expression;
use backend\models\ClaimSetting;
use backend\models\ClaimPrint;
use common\models\Claim;
use common\models\ClaimItem;
use common\models\ClaimFile;
use backend\models\ClaimAttend;
use common\models\Model;
use common\models\Upload;
use common\models\Application;

use raoul2000\workflow\validation\WorkflowScenario;

use yii\helpers\Json;

/**
 * ClaimController implements the CRUD actions for Claim model.
 */
class ClaimController extends Controller
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
     * Lists all Claim models.
     * @return mixed
     */
    public function actionIndex()
    {
		$query = Claim::find();
		//$query->joinWith(['application']);
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		$app = Application::getMyAcceptApplication();
		
		if($app){
			$app = $app->id;
		}else{
			$app = 0;
		}
		
        $query->andFilterWhere([
            'application_id' => $app,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Claim model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
		$model = $this->findModel($id);
		$status = $model->getWfStatus();
		 if($status == 'draft' or $status == 'returned'){
			$this->redirect(['update', 'id' => $id]);
		} 
		
		return $this->render('view', [
				'model' => $model,
			]);
        
    }
	
	public function actionDraftview($id)
    {
		$model = $this->findModel($id);		
		return $this->render('draftview', [
				'model' => $model,
			]);
        
    }

    /**
     * Creates a new Claim model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Claim();
		$apply = $model->getAcceptApplication();
		if($apply){
		
		$model->scenario = WorkflowScenario::enterStatus('aa-draft');
		if ($model->load(Yii::$app->request->post())) {
			
			$arr = explode('-', $model->month_year);
			$model->month = $arr[0];
			$model->year = $arr[1];
			$model->application_id = $apply->id;
			$model->rate_amount = $apply->rate_amount;
			$claim = $model->getExistingClaim();
			if($claim){
				$month = $model->monthName();
				$year = $model->year;
				
				
				
				if($claim->wfStatus == 'draft' or $claim->wfStatus == 'returned'){
					Yii::$app->session->addFlash('info', "Permohonan telah dibuat dan belum dihantar untuk bulan ".$month." ".$year.". Sila selesaikan pengisian butiran tuntutan dan hantar sebelum tarikh tutup.");
					return $this->redirect(['claim/update', 'id' => $claim->id]);
				}else if($claim->wfStatus == 'submit'){
					Yii::$app->session->addFlash('error', "Permohonan telah dihantar untuk bulan ".$month." ".$year.".");
					return $this->redirect(['claim/view', 'id' => $claim->id]);
				}
				
				
			}else{
				$model->draft_at = new Expression('NOW()');
				$model->sendToStatus('aa-draft');
				
				if($model->save()){
					
					/* $file = new ClaimFile;
					$file->claim_id = $model->id;
					$file->save(); */
					
					return $this->redirect(['claim/update/', 'id' => $model->id]);
				}
				
			}
			
			
			
		}
		
		
			return $this->render('create', [
				'model' => $model,
				'apply' => $apply
			]);
		
		//if no application
		}else{
			Yii::$app->session->addFlash('error', "Minta maaf, tiada permohonan yang telah dilulus serta diterima pada semester ini.");
			return $this->redirect(['claim/index']);
		}
    }

    /**
     * Updates an existing Claim model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
		
		
		
        $model = $this->findModel($id);
//print_r($model->getListPortalAttendanceRecorded($model->application_id));die();

		$model->scenario = 'save-draft';
		$status = $model->getWfStatus();
		
		if($status == 'submit'){
			$this->redirect(['view', 'id' => $id]);
		}else if($status == 'returned'){
			if($model->return_note){
				Yii::$app->session->addFlash('info', $model->return_note);
				$model->return_note = '';
			}
			
		}
		
		
		
		$items = $model->claimItems;
		

		if ($model->load(Yii::$app->request->post())) {
			
		
			$oldItemIDs = ArrayHelper::map($items, 'id', 'id');
			
			$items = Model::createMultiple(ClaimItem::classname(), $items);
			
			
			Model::loadMultiple($items, Yii::$app->request->post()); 
			
            $deletedItemIDs = array_diff($oldItemIDs, array_filter(ArrayHelper::map($items, 'id', 'id')));
			
			$wf = Yii::$app->request->post('wflow');
			

			$model->scenario = 'save-draft';
			$model->draft_at = new Expression('NOW()');
			
			//validate attachment
			

			
			$valid = $model->validate();
			
			$valid = Model::validateMultiple($items) && $valid;
			
			$valid = $model->validateClaimItem($items) && $valid;
			
			//echo $model->validateClaimItem($items);
			
			if ($valid) {
				
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
						
						if (! empty($deletedItemIDs)) {
                            ClaimItem::deleteAll(['id' => $deletedItemIDs]);
                        }
						
						foreach ($items as $indexItem => $item) {
							
                            if ($flag === false) {
                                break;
                            }

                            $item->claim_id = $model->id;

                            if (!($flag = $item->save(false))) {
                                break;
                            }
                        }
						
						//update attend
						
						$attend = Yii::$app->request->post('attendportal');
						//if($attend){
							//print_r($attend);
							//die();
                            $kira_post = count($attend);
                            $kira_lama = count($model->claimAttends);
                            if($kira_post > $kira_lama){
                                $bil = $kira_post - $kira_lama;
                                for($i=1;$i<=$bil;$i++){
                                    $insert = new ClaimAttend;
                                    $insert->claim_id = $model->id;
                                    $insert->save();
                                }
                            }else if($kira_post < $kira_lama){
    
                                $bil = $kira_lama - $kira_post;
                                $deleted = ClaimAttend::find()
                                  ->where(['claim_id'=>$model->id])
                                  ->limit($bil)
                                  ->all();
                                if($deleted){
                                    foreach($deleted as $del){
                                        $del->delete();
                                    }
                                }
                            }
                            
                            $update_attend = ClaimAttend::find()
                            ->where(['claim_id' => $model->id])
                            ->all();
    
                            if($update_attend){
                                $i=0;
                                foreach($update_attend as $ut){
                                    $ut->portal_id = $attend[$i];
									$ut->updated_at = new Expression('NOW()');
                                    if(!$ut->save()){
										$ut->flashError();
									}
                                    $i++;
                                }
                            }
                       // }
						
						/////
						
						
                    }
					
					$model = $this->findModel($id);

                    if ($flag) {
						
                        $transaction->commit();
						if($wf == 'draft'){
							Yii::$app->session->addFlash('info', "Maklumat tuntutan telah berjaya disimpan. Status tuntutan masih dalam deraf, sila klik butang [Kembali Kemaskini] untuk kemaskini dan hantar");
							return $this->redirect(['draftview', 'id' => $id]);
							
						}else if(($wf == 'submit')){
							if($model->validateClaimFiles()){
								
								//if(true){
								if($model->checkDueDate()){
									$model->submit_at = new Expression('NOW()');
									$model->sendToStatus('bb-submit');
									if($model->save()){
										
										Yii::$app->session->addFlash('success', "Permohonan tuntutan telah berjaya dihantar.");
											return $this->redirect(['claim/view', 'id' => $model->id]);

									}
								}else{
									Yii::$app->session->addFlash('error', 'Permohonan tuntutan telah ditutup.');
								}
								
							}else{
								Yii::$app->session->addFlash('error', 'Sila lampirkan fail kehadiran sebelum hantar tuntutan.');
							}
							
						}
						
                        
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
					
                }
            }
			
			if($wf == 'add-file'){
				$this->addFile($model->id);
			}
		
			
			
		}
		
		

      

			return $this->render('update', [
				'model' => $model,
				'items' => (empty($items)) ? [new ClaimItem] : $items,
				'setting' => ClaimSetting::findOne(1)
			]);
		

    }

    /**
     * Deletes an existing Claim model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($attr, $id)
	{
		$attr = $this->clean($attr);
        $model = $this->findClaimFile($id);
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

    /**
     * Finds the Claim model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Claim the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Claim::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionDeleteRow($id){
		$model = $this->findClaimFile($id);
		if($model->delete()){
			$this->redirect(['claim/update', 'id' => $model->claim_id]);
		}
	}
	
	protected function findClaimFile($id)
    {
        if (($model = ClaimFile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionUpload($attr, $id){
		
		$attr = $this->clean($attr);
        $model = $this->findClaimFile($id);
		$model->file_controller = 'claim';
		
		return Upload::upload($model, $attr, 'updated_at');

	}
	
	public function actionDownload($attr, $id){
		$attr = $this->clean($attr);
        $model = $this->findClaimFile($id);
		$filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
		
		
		
		Upload::download($model, $attr, $filename);
	}
	
	public function addFile($id){
		$claim = $this->findModel($id);
		$model = new ClaimFile;
		$model->scenario = 'add_file';
		
		$model->claim_id = $claim->id;
		$model->updated_at = new Expression('NOW()');
		
		
		if(!$model->save()){
			Yii::$app->session->addFlash('error', "Add File failed!");
		}
		//return $this->redirect(['claim/update', 'id' => $claim->id]);
	}
	protected function clean($string){
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	}
	
	public function actionClaimPrint($id){
		$model = $this->findModel($id);
		if($model->wfStatus <> 'draft'){
			$pdf = new ClaimPrint;
			$pdf->model = $model;
			$pdf->generatePdf();
		}
		
	}
}
