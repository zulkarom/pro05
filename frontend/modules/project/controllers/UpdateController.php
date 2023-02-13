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
use backend\modules\project\models\CommitteeMain;
use backend\modules\project\models\CommitteePosition;
use backend\modules\project\models\CommitteeMember;
use backend\models\Semester;
use backend\models\Student;
use yii\db\Expression;
use common\models\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

use backend\modules\project\models\Person;
use backend\modules\project\models\House;
use backend\modules\project\models\Room;
use backend\models\Api;

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
		
		//add auto students
		$app = $model->application;
		$api = new Api;
		$api->semester = $app->semester->id;
		$api->subject = $app->acceptedCourse->course->course_code;
		$api->group = $app->groupName;
		$response = $api->student();
		
		$this->addStudents($model->id, $response);

		
		if($model){
			
			if($model->status > 0){
				return $this->redirect(['/project/update/preview', 'token' => $token]);
			}
			
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
	
	protected function addStudents($project, $response){
		if($response){
			if($response->result){
				foreach($response->result as $stu){
					$fstu = Student::findOne(['student_matric' => $stu->id]);
					if($fstu){
						$fstu->student_name = $stu->name;
						$fstu->save();
						$inv = ProjectStudent::findOne(['student_id' => $fstu->id, 'project_id' => $project]);
						if(!$inv){
							$this->addStudentInvolved($fstu->id, $project);
						}
					}else{
						$newstu = new Student;
						$newstu->student_matric = $stu->id;
						$newstu->student_name = $stu->name;
						if($newstu->save()){
							$this->addStudentInvolved($newstu->id, $project);
						}
					}
				}
				
			}
		}
		
	}
	
	protected function addStudentInvolved($student_id, $project){
		$stud = new ProjectStudent;
		$stud->student_id = $student_id;
		$stud->project_id = $project;
		return ($stud->save());
	}
	
	public function actionCommitteeMember($token){
		
		$model = $this->findModel($token);
		
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
		
		if($model->status > 0){
			return $this->redirect(['/project/default/preview', 'token' => $token]);
		}
		
        $modelsPosition = $model->committeePositions;
		if(count($modelsPosition) == 0){
			$student = ProjectStudent::find()
			->joinWith('student')
			->orderBy('student_name ASC')
			->where(['project_id' => $model->id])
			->one();
			if($student){
				$model->putDefaultPosition($student->student_id);
				$model = $this->findModel($token);
				$modelsPosition = $model->committeePositions;
			}
			
		}
        $modelsMember = [];
        $oldMembers = [];

        if (!empty($modelsPosition)) {
            foreach ($modelsPosition as $indexPosition => $modelPosition) {
                $members = $modelPosition->committeeMembers;
                $modelsMember[$indexPosition] = $members;
                $oldMembers = ArrayHelper::merge(ArrayHelper::index($members, 'id'), $oldMembers);
            }
        }

        if ($model->load(Yii::$app->request->post())) {
			
			//echo '<pre>';
			//print_r(Yii::$app->request->post());die();

            // reset
            $modelsMember = [];

            $oldPositionIDs = ArrayHelper::map($modelsPosition, 'id', 'id');
            $modelsPosition = Model::createMultiple(CommitteePosition::classname(), $modelsPosition);
            Model::loadMultiple($modelsPosition, Yii::$app->request->post());
            $deletedPositionIDs = array_diff($oldPositionIDs, array_filter(ArrayHelper::map($modelsPosition, 'id', 'id')));

            // validate person and days models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsPosition) && $valid;

            $membersIDs = [];
			//print_r( $_POST['Time']);die();
            if (isset($_POST['CommitteeMember'][0][0])) {
                foreach ($_POST['CommitteeMember'] as $indexPosition => $members) {
					//echo '<pre>';print_r($members);die();
                    $membersIDs = ArrayHelper::merge($membersIDs, array_filter(ArrayHelper::getColumn($members, 'id')));
					//print_r(ArrayHelper::getColumn($members, 'id'));die();
                    foreach ($members as $indexMember => $member) {
						//echo '<pre>';print_r($member);die();
                        $data['CommitteeMember'] = $member;
                        $modelMember = (isset($member['id']) && isset($oldMembers[$member['id']])) ? $oldMembers[$member['id']] : new CommitteeMember;
						//echo '<pre>';print_r($modelMember);echo '<br /><br /><br /><br />';
                        $modelMember->load($data);
						//echo '<pre>';print_r($modelMember);die();
                        $modelsMember[$indexPosition][$indexMember] = $modelMember;
                        $valid = $modelMember->validate();
                    }
                }
            }

            $oldMembersIDs = ArrayHelper::getColumn($oldMembers, 'id');
            $deletedMemberIDs = array_diff($oldMembersIDs, $membersIDs);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
					$model->updated_at = new Expression('NOW()');
                    if ($flag = $model->save(false)) {

                        if (! empty($deletedMemberIDs)) {
                            CommitteeMember::deleteAll(['id' => $deletedMemberIDs]);
                        }

                        if (! empty($deletedPositionIDs)) {
                            CommitteePosition::deleteAll(['id' => $deletedPositionIDs]);
                        }

                        foreach ($modelsPosition as $indexPosition => $modelPosition) {

                            if ($flag === false) {
                                break;
                            }

                            $modelPosition->pro_id = $model->id;

                            if (!($flag = $modelPosition->save(false))) {
                                break;
                            }

                            if (isset($modelsMember[$indexPosition]) && is_array($modelsMember[$indexPosition])) {
								
                                foreach ($modelsMember[$indexPosition] as $indexMember => $modelMember) {
									//echo '<pre>';print_r($modelMember);die();
                                    $modelMember->position_id = 
									$modelPosition->id;
                                    if (!($flag = $modelMember->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
						Yii::$app->session->addFlash('success', "Data Updated");
                        return $this->redirect(['committee-member', 'token' => $token]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
		
		

        return $this->render('committee-member', [
            'model' => $model,
            'modelsPosition' => (empty($modelsPosition)) ? [new CommitteePosition] : $modelsPosition,
            'modelsMember' => (empty($modelsMember)) ? [[new CommitteeMember]] : $modelsMember
        ]);
	}
	
	public function actionDeleteStudent($token, $id){
		$model = $this->findModel($token);
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
		
		if($model->status > 0){
				return $this->redirect(['/project/update/preview', 'token' => $token]);
			}

		$main = CommitteeMain::find()->where(['pro_id' => $model->id, 'student_id' => $id])->count();
		$member = CommitteePosition::find()->joinWith(['committeeMembers'])
		->where(['pro_id' => $model->id, 'student_id' => $id])->count();
		if($main > 0 or $member > 0) {
			Yii::$app->session->addFlash('error', "Please exclude the student in the committee first!");
		}else{
			Yii::$app->session->addFlash('success', "Data Updated");
			ProjectStudent::deleteAll(['student_id' => $id]);
		}
		
		return $this->redirect(['update/student', 'token' => $token]);
		
		
	}
	
	public function actionCommittee($token)
    {
		$model = $this->findModel($token);
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
		
		if($model->status > 0){
				return $this->redirect(['/project/update/preview', 'token' => $token]);
			}
	
		$committees = $model->mainCommittees;
		if(count($committees) == 0){
			$student = ProjectStudent::find()
			->joinWith('student')
			->orderBy('student_name ASC')
			->where(['project_id' => $model->id])
			->one();
			if($student){
				$model->putDefaultCommittee($student->student_id);
				$model = $this->findModel($token);
				$committees = $model->mainCommittees;
			}
		}
		
		
       
        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($committees, 'id', 'id');
            
            $committees = Model::createMultiple(CommitteeMain::classname(), $committees);
            
            Model::loadMultiple($committees, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($committees, 'id', 'id')));
            
            foreach ($committees as $i => $committee) {
                $committee->com_order = $i;
            }
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($committees) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            CommitteeMain::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($committees as $i => $committee) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $committee->pro_id = $model->id;

                            if (!($flag = $committee->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Jawatankuasa telah dikemaskini");
                            return $this->redirect(['committee','token' => $token]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

		}
		
		
        return $this->render('committee', [
			'model' => $model,
			'committees' => (empty($committees)) ? [new CommitteeMain] : $committees
		
		]);
    }
	
	public function actionTentative($token)
    {
		$model = $this->findModel($token);
		
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
		
		if($model->status > 0){
				return $this->redirect(['/project/update/preview', 'token' => $token]);
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
					$model->updated_at = new Expression('NOW()');
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
		
		if($model->status > 0){
				return $this->redirect(['/project/update/preview', 'token' => $token]);
			}
		
        $resources = $model->resources;
		if(count($resources) == 0){
			$model->putDefaultIncome();
			$model = $this->findModel($token);
			$resources = $model->resources;
		}
       
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
					
					$total_income = $model->totalResources;
					$model->pro_fund = $total_income;
					$flag = $model->save(false);

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
		if($model->status > 0){
				return $this->redirect(['/project/update/preview', 'token' => $token]);
			}
		
        $expenses = $model->expenseBasics;
		if(count($expenses) == 0){
			$model->putDefaultExpense();
			$model = $this->findModel($token);
			$expenses = $model->expenseBasics;
		}
		
       
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
					
					$total_expense = $model->totalExpenses;
					$model->pro_expense = $total_expense;
					$flag = $model->save(false);

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
		if($model->status > 0){
				return $this->redirect(['/project/update/preview', 'token' => $token]);
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
					
					$total_expense = $model->totalExpenses;
					$model->pro_expense = $total_expense;
					$flag = $model->save(false);

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
		
		if($model->status > 0){
				return $this->redirect(['/project/update/preview', 'token' => $token]);
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
					
					$total_expense = $model->totalExpenses;
					$model->pro_expense = $total_expense;
					$flag = $model->save(false);

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
		$model->scenario = 'student_submit';
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
		
		//$model->scenario = 'update-income';
		
		if ($model->load(Yii::$app->request->post())) {
			if($model->status == 0){
				$model->status = 10;
			}
			
			$model->submitted_at = new Expression('NOW()');
			$model->updated_at = new Expression('NOW()');
			
			if($model->validateAllTabs()){
				if($model->save()){
					Yii::$app->session->addFlash('success', "Data Updated");
					return $this->redirect(['preview', 'token' => $token]);
				}
			}else{
				Yii::$app->session->addFlash('error', "Sila pastikan semua maklumat lengkap!");
				return $this->redirect(['preview', 'token' => $token]);
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
		->where([
			'pro_token' => $token, 
			'semester_id' => $semester->id])
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
		if($model->status > 0){
				return $this->redirect(['/project/update/preview', 'token' => $token]);
			}
		$query = ProjectStudent::find()->where(['pro_token' => $token]);
		$query->joinWith(['project','student'])->orderBy('student_name ASC');
		
		$dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
                'pageSize' => 100,
            ],

        ]);

        return $this->render('student', [
            'dataProvider' => $dataProvider,
			'model' => $model
        ]);
	}
	
	public function actionEft($token){
		$model = $this->findModel($token);
		if(!$model){
			return $this->redirect(['/project/default/index', 'token' => $token]);
		}
		if($model->status > 0){
			return $this->redirect(['/project/update/preview', 'token' => $token]);
		}
		
		$model->scenario = 'eft';
		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->addFlash('success', "Data Updated");
		}
		
        return $this->render('eft', [
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
			
			if($student->save()){
				$search = ProjectStudent::findOne(['student_id' => $student->id, 'project_id' => $model->id]);
				if(!$search){
					$add = new ProjectStudent;
					$add->project_id = $model->id;
					$add->student_id = $student->id;
					if($add->save()){
						Yii::$app->session->addFlash('success', "Pelajar telah ditambah");
					}
				}else{
					Yii::$app->session->addFlash('success', "Pelajar telah disenaraikan");
				}
				
				return $this->redirect(['student', 'token' => $token]);
			}
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
	
	protected function findPerson($id)
    {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionTest($id){
         $modelPerson = $this->findPerson($id);
        $modelsHouse = $modelPerson->houses;
        $modelsRoom = [];
        $oldRooms = [];

        if (!empty($modelsHouse)) {
            foreach ($modelsHouse as $indexHouse => $modelHouse) {
                $rooms = $modelHouse->rooms;
                $modelsRoom[$indexHouse] = $rooms;
                $oldRooms = ArrayHelper::merge(ArrayHelper::index($rooms, 'id'), $oldRooms);
            }
        }

        if ($modelPerson->load(Yii::$app->request->post())) {
            
            //echo '<pre>';
            //print_r(Yii::$app->request->post());die();

            // reset
            $modelsRoom = [];

            $oldHouseIDs = ArrayHelper::map($modelsHouse, 'id', 'id');
            $modelsHouse = Model::createMultiple(House::classname(), $modelsHouse);
            Model::loadMultiple($modelsHouse, Yii::$app->request->post());
            $deletedHouseIDs = array_diff($oldHouseIDs, array_filter(ArrayHelper::map($modelsHouse, 'id', 'id')));

            // validate person and houses models
            $valid = $modelPerson->validate();
            $valid = Model::validateMultiple($modelsHouse) && $valid;

            $roomsIDs = [];
            //print_r( $_POST['Room']);die();
            if (isset($_POST['Room'][0][0])) {
                foreach ($_POST['Room'] as $indexHouse => $rooms) {
                    
                    $roomsIDs = ArrayHelper::merge($roomsIDs, array_filter(ArrayHelper::getColumn($rooms, 'id')));
                    //print_r(ArrayHelper::getColumn($rooms, 'id'));die();
                    foreach ($rooms as $indexRoom => $room) {
                        
                        $data['Room'] = $room;
                        $modelRoom = (isset($room['id']) && isset($oldRooms[$room['id']])) ? $oldRooms[$room['id']] : new Room;
                        echo '<pre>';print_r($modelRoom);echo '<br /><br /><br /><br />';
                        $modelRoom->load($data);
                        //print_r($modelRoom);die();
                        $modelsRoom[$indexHouse][$indexRoom] = $modelRoom;
                        $valid = $modelRoom->validate();
                    }
                }
            }

            $oldRoomsIDs = ArrayHelper::getColumn($oldRooms, 'id');
            $deletedRoomsIDs = array_diff($oldRoomsIDs, $roomsIDs);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelPerson->save(false)) {

                        if (! empty($deletedRoomsIDs)) {
                            Room::deleteAll(['id' => $deletedRoomsIDs]);
                        }

                        if (! empty($deletedHouseIDs)) {
                            House::deleteAll(['id' => $deletedHouseIDs]);
                        }

                        foreach ($modelsHouse as $indexHouse => $modelHouse) {

                            if ($flag === false) {
                                break;
                            }

                            $modelHouse->person_id = $modelPerson->id;

                            if (!($flag = $modelHouse->save(false))) {
                                break;
                            }

                            if (isset($modelsRoom[$indexHouse]) && is_array($modelsRoom[$indexHouse])) {
                                
                                foreach ($modelsRoom[$indexHouse] as $indexRoom => $modelRoom) {
                                    //echo '<pre>';print_r($modelRoom);die();
                                    $modelRoom->house_id = 
                                    $modelHouse->id;
                                    if (!($flag = $modelRoom->save(false))) {
                                        break;
                                    }
                                }
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->addFlash('success', "Data Updated");
                        return $this->redirect(['test', 'id' => $modelPerson->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        
        

        return $this->render('test', [
            'modelPerson' => $modelPerson,
            'modelsHouse' => (empty($modelsHouse)) ? [new House] : $modelsHouse,
            'modelsRoom' => (empty($modelsRoom)) ? [[new Room]] : $modelsRoom
        ]);
    }

	
	
	
	
}
