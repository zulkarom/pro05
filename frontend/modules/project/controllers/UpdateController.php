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
use backend\modules\project\models\Objective;
use backend\modules\project\models\ProjectPrint;
use backend\modules\project\models\ProjectStudent;
use backend\models\Semester;
use backend\models\Student;
use yii\db\Expression;
use common\models\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

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
		
			$objectives = $model->objectives;
       
        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($objectives, 'id', 'id');
            
            
            $objectives = Model::createMultiple(Objective::classname(), $objectives);
            
            Model::loadMultiple($objectives, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($objectives, 'id', 'id')));
            
            foreach ($objectives as $i => $objective) {
                $objective->obj_order = $i;
            }
            
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($objectives) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            Objective::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($objectives as $i => $objective) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $objective->pro_id = $model->id;

                            if (!($flag = $objective->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Maklumat telah dikemaskini");
                            return $this->redirect(['index','token' => $token]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

		}
			
			
			return $this->render('index', [
				'model' => $model,
				'objectives' => (empty($objectives)) ? [new Objective] : $objectives
			
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
		
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
		
        $modelsDay = $model->tentativeDays;
        $modelsTime = [];
        $oldTimes = [];

        if (!empty($modelsDay)) {
            foreach ($modelsDay as $indexDay => $modelDay) {
                $times = $modelDay->tentativeTimes;
                $modelsTime[$indexDay] = $times;
                $oldTimes = ArrayHelper::merge(ArrayHelper::index($times, 'id'), $oldTimes);
            }
        }

        if ($model->load(Yii::$app->request->post())) {
			
			//echo '<pre>';
			//print_r(Yii::$app->request->post());die();

            // reset
            $modelsTime = [];

            $oldDayIDs = ArrayHelper::map($modelsDay, 'id', 'id');
            $modelsDay = Model::createMultiple(TentativeDay::classname(), $modelsDay);
            Model::loadMultiple($modelsDay, Yii::$app->request->post());
            $deletedDayIDs = array_diff($oldDayIDs, array_filter(ArrayHelper::map($modelsDay, 'id', 'id')));

            // validate person and days models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsDay) && $valid;

            $timesIDs = [];
			//print_r( $_POST['Time']);die();
            if (isset($_POST['TentativeTime'][0][0])) {
                foreach ($_POST['TentativeTime'] as $indexDay => $times) {
					//echo '<pre>';print_r($times);die();
                    $timesIDs = ArrayHelper::merge($timesIDs, array_filter(ArrayHelper::getColumn($times, 'id')));
					//print_r(ArrayHelper::getColumn($times, 'id'));die();
                    foreach ($times as $indexTime => $time) {
						//echo '<pre>';print_r($time);die();
                        $data['TentativeTime'] = $time;
                        $modelTime = (isset($time['id']) && isset($oldTimes[$time['id']])) ? $oldTimes[$time['id']] : new TentativeTime;
						//echo '<pre>';print_r($modelTime);echo '<br /><br /><br /><br />';
                        $modelTime->load($data);
						//echo '<pre>';print_r($modelTime);die();
                        $modelsTime[$indexDay][$indexTime] = $modelTime;
                        $valid = $modelTime->validate();
                    }
                }
            }

            $oldTimesIDs = ArrayHelper::getColumn($oldTimes, 'id');
            $deletedTimesIDs = array_diff($oldTimesIDs, $timesIDs);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {

                        if (! empty($deletedTimesIDs)) {
                            TentativeTime::deleteAll(['id' => $deletedTimesIDs]);
                        }

                        if (! empty($deletedDayIDs)) {
                            TentativeDay::deleteAll(['id' => $deletedDayIDs]);
                        }

                        foreach ($modelsDay as $indexDay => $modelDay) {

                            if ($flag === false) {
                                break;
                            }

                            $modelDay->pro_id = $model->id;

                            if (!($flag = $modelDay->save(false))) {
                                break;
                            }

                            if (isset($modelsTime[$indexDay]) && is_array($modelsTime[$indexDay])) {
								
                                foreach ($modelsTime[$indexDay] as $indexTime => $modelTime) {
									//echo '<pre>';print_r($modelTime);die();
                                    $modelTime->day_id = 
									$modelDay->id;
                                    if (!($flag = $modelTime->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
						Yii::$app->session->addFlash('success', "Data Updated");
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
            'days' => (empty($modelsDay)) ? [new TentativeDay] : $modelsDay,
            'times' => (empty($modelsTime)) ? [[new TentativeTime]] : $modelsTime
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
	
	
	
	public function actionDownload($token){
		$model = $this->findModel($token);
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
		
		$pdf = new ProjectPrint;
		$pdf->model = $model;
		$pdf->generatePdf();

	}
	
	public function actionStudent($token){
		$model = $this->findModel($token);
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
		$query = ProjectStudent::find()->where(['pro_token' => $token]);
		$query->joinWith(['project','student']);
		
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('student', [
            'dataProvider' => $dataProvider,
			'model' => $model
        ]);
	}
	
	public function actionAssign($token){
		$model = $this->findModel($token);
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
		
		$student = new Student;
		$student->scenario = 'check';
		
		if ($student->load(Yii::$app->request->post())) {
			$matric = $student->student_matric;
			$search = Student::findOne(['student_matric' => $matric]);
			
			if(!$search){
				if($student->save()){
					return $this->redirect(['add-student', 'token' => $token, 'student' => $student->id]);
				}
			}else{
				return $this->redirect(['add-student', 'token' => $token, 'student' => $search->id]);
			}
			
			
        }
		
		return $this->render('assign-matric', [
			'model' => $model,
			'student' => $student
		
		]);
	}
	
	public function actionAddStudent($token, $student){
		$model = $this->findModel($token);
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
		
		$student = $this->findStudent($student);
		$student->scenario = 'update';
		
		if ($student->load(Yii::$app->request->post())) {
			$student->save();
			$search = ProjectStudent::findOne(['student_id' => $student->id, 'project_id' => $model->id]);
			if(!$search){
				$add = new ProjectStudent;
				$add->project_id = $model->id;
				$add->student_id = $student->id;
				if($add->save()){
					Yii::$app->session->addFlash('success', "Pelajar telah ditambah");
					
				}
			}else{
				Yii::$app->session->addFlash('error', "Pelajar telah disenaraikan");
			}
			
			return $this->redirect(['student', 'token' => $token]);
			
			
		}
		
		return $this->render('add-student', [
			'model' => $model,
			'student' => $student
		
		]);
	}
	
	protected function findStudent($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	
	
	
}
