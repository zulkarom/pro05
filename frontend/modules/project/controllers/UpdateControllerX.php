<?php

namespace frontend\modules\project\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\project\models\Project;
use backend\modules\project\models\Resource;
use backend\modules\project\models\ExpBasic;
use backend\modules\project\models\ExpTool;
use backend\modules\project\models\ExpRent;
use backend\modules\project\models\TentativeDay;
use backend\modules\project\models\TentativeTime;
use backend\models\Semester;
use yii\db\Expression;
use common\models\Model;
use yii\helpers\ArrayHelper;


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
		$token = strtoupper($token);
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
		$model->scenario = 'update';
		
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
		
        $days = $model->tentativeDays;

        if ($model->load(Yii::$app->request->post())) {
			
			$model->updated_at = new Expression('NOW()');  

            $oldDayIDs = ArrayHelper::map($days, 'id', 'id');
			
            $days = Model::createMultiple(TentativeDay::classname(), $days);
			
			//print_r($days);
            Model::loadMultiple($days, Yii::$app->request->post());
			
			/* echo '<pre>';
			print_r(Yii::$app->request->post());
			
			$days = ArrayHelper::map($days, 'id', 'pro_date');
			
			print_r($days); */
			
			/* foreach($days as $day){
				echo 'xx';print_r($day);die();
			} */

            // validate person and houses models
            $valid = $model->validate();
			
            $valid = Model::validateMultiple($days) && $valid;
			//echo $valid;die();
   

            if ($valid) {
				
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {

                        foreach ($days as $indexDay => $day) {

                            if ($flag === false) {
                                break;
                            }

                            $day->pro_id = $model->id;

                            if (!($flag = $day->save(false))) {
								
                                break;
                            }

    
                        }
                    }
					
					//print_r($model->getErrors());die();

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['tentative', 'token' => $token]);
                    } else {
						
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
		
		return $this->render('tentative', [
            'model' => $model,
            'expenses' => (empty($days)) ? [new TentativeDay] : $days
        ]);
		

    }
	
	
	
	public function actionIncome($token)
    {
		$model = $this->findModel($token);
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
        $resources = $model->resources;
       
        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($resources, 'id', 'id');
            
            
            $resources = Model::createMultiple(Resource::classname(), $resources);
            
            Model::loadMultiple($resources, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($resources, 'id', 'id')));
            
            foreach ($resources as $i => $resource) {
                $resource->rs_order = $i;
            }
            
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($resources) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            Resource::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($resources as $i => $resource) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $resource->pro_id = $model->id;

                            if (!($flag = $resource->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Pendapatan telah dikemaskini");
                            return $this->redirect(['income','token' => $token]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

		}

		
		
        return $this->render('income', [
			'model' => $model,
			'resources' => (empty($resources)) ? [new Resource] : $resources
		
		]);
    }
	
	public function actionExpense($token)
    {
		$model = $this->findModel($token);
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
        $expenses = $model->expenseBasics;
       
        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($expenses, 'id', 'id');
            
            
            $expenses = Model::createMultiple(ExpBasic::classname(), $expenses);
            
            Model::loadMultiple($expenses, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($expenses, 'id', 'id')));
            
            foreach ($expenses as $i => $expense) {
                $expense->exp_order = $i;
            }
            
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($expenses) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            ExpBasic::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($expenses as $i => $expense) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $expense->pro_id = $model->id;

                            if (!($flag = $expense->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Perbelanjaan asas telah dikemaskini");
                            return $this->redirect(['expense','token' => $token]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

		}

		
		
        return $this->render('expense', [
			'model' => $model,
			'expenses' => (empty($expenses)) ? [new ExpBasic] : $expenses
		
		]);
    }
	
	public function actionExpenseTool($token)
    {
		$model = $this->findModel($token);
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
        $expenses = $model->expenseTools;
       
        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($expenses, 'id', 'id');
            
            
            $expenses = Model::createMultiple(ExpTool::classname(), $expenses);
            
            Model::loadMultiple($expenses, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($expenses, 'id', 'id')));
            
            foreach ($expenses as $i => $expense) {
                $expense->exp_order = $i;
            }
            
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($expenses) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            ExpTool::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($expenses as $i => $expense) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $expense->pro_id = $model->id;

                            if (!($flag = $expense->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Perbelanjaan peralatan telah dikemaskini");
                            return $this->redirect(['expense-tool','token' => $token]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

		}

		
		
        return $this->render('expense-tool', [
			'model' => $model,
			'expenses' => (empty($expenses)) ? [new ExpTool] : $expenses
		
		]);
    }
	
	public function actionExpenseRent($token)
    {
		$model = $this->findModel($token);
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
        $expenses = $model->expenseRents;
       
        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($expenses, 'id', 'id');
            
            
            $expenses = Model::createMultiple(ExpRent::classname(), $expenses);
            
            Model::loadMultiple($expenses, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($expenses, 'id', 'id')));
            
            foreach ($expenses as $i => $expense) {
                $expense->exp_order = $i;
            }
            
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($expenses) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            ExpRent::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($expenses as $i => $expense) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $expense->pro_id = $model->id;

                            if (!($flag = $expense->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Perbelanjaan sewaan telah dikemaskini");
                            return $this->redirect(['expense-rent','token' => $token]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

		}

		
		
        return $this->render('expense-rent', [
			'model' => $model,
			'expenses' => (empty($expenses)) ? [new ExpRent] : $expenses
		
		]);
    }
	
	public function actionPreview($token)
    {
		$model = $this->findModel($token);
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
		$model->scenario = 'update-income';
		
		if ($model->load(Yii::$app->request->post())) {
			$model->updated_at = new Expression('NOW()');
			
			if($model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['index', 'token' => $token]);
			}
            
        }
		
		
        return $this->render('preview', [
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
