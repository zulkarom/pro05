<?php

namespace backend\modules\esiap\controllers;

use Yii;
use backend\modules\esiap\models\AssessmentCat;
use backend\modules\esiap\models\Course;
use backend\modules\esiap\models\CourseProfile;
use backend\modules\esiap\models\CourseClo;
use backend\modules\esiap\models\CourseCloAssessment;
use backend\modules\esiap\models\CourseSearch;
use backend\modules\esiap\models\CourseVersion;
use backend\modules\esiap\models\CourseSyllabus;
use backend\modules\esiap\models\CourseSltAs;
use backend\modules\esiap\models\CourseAssessment;
use backend\modules\esiap\models\CourseVersionSearch;
use backend\modules\esiap\models\CourseReference;
use backend\modules\esiap\models\CourseCloDelivery;
use backend\modules\esiap\models\CourseVersionClone;
use backend\modules\esiap\models\CourseTransferable;
use backend\modules\esiap\models\CourseStaff;
use backend\modules\esiap\models\Fk1;
use backend\modules\esiap\models\Fk2;
use backend\modules\esiap\models\Fk3;
use backend\modules\esiap\models\Tbl4;
use backend\modules\esiap\models\Tbl4Excel;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use common\models\Model;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseController extends Controller
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
     * Lists all Course models.
     * @return mixed
     */
    public function actionIndex()
    {
		
        /* $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); */
    }
	


    /**
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Course();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Course model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($course)
    {
        $model = $this->findModel($course);
		$version = $model->developmentVersion;
		$status = $version->status;
		if($status == 0){
			$version->scenario = 'save_date';
			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				
				if ($version->load(Yii::$app->request->post()) && $version->save()) {
					Yii::$app->session->addFlash('success', "Data Updated");
					return $this->redirect(['update','course' => $course]);
				}
			}

			return $this->render('update', [
				'model' => $model,
				'version' => $version
			]);
		}else{
			return $this->redirect(['report', 'course' => $course]);
		}
		
    }
	
	 public function actionReport($course)
    {
        $model = $this->findModel($course);
		$version = $model->developmentVersion;

        if ($version->load(Yii::$app->request->post())) {
			$version->prepared_at = new Expression('NOW()');
			$version->status = 10;
			if($version->save()){
				return $this->redirect(['course/report','course' => $course]);
			}
            
        }

        return $this->render('report', [
            'model' => $model,
			'version' => $version
        ]);
    }
	
	public function actionCoordinator($course)
    {
        $model = $this->findModel($course);
		$model->scenario = 'coor';
        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				return $this->redirect(['/course/list']);
			}else{
				$model->flashError();
			}
            
        }

        return $this->render('coordinator', [
            'model' => $model,
        ]);
    }
	
	public function actionProfile($course)
    {
        $model = $this->findProfile($course);
		$model->scenario = 'update';
		$transferables = $model->transferables;
		$staffs = $model->academicStaff;

        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');    
            
            $oldIDs = ArrayHelper::map($transferables, 'id', 'id');
			$staff_oldIDs = ArrayHelper::map($staffs, 'id', 'id');
            
            $transferables = Model::createMultiple(CourseTransferable::classname(), $transferables);
			$staffs = Model::createMultiple(CourseStaff::classname(), $staffs);
            
            Model::loadMultiple($transferables, Yii::$app->request->post());
			Model::loadMultiple($staffs, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($transferables, 'id', 'id')));
			$staff_deletedIDs = array_diff($staff_oldIDs, array_filter(ArrayHelper::map($staffs, 'id', 'id')));
            
			foreach ($transferables as $i => $t) {
                $t->transfer_order = $i;
            }
			foreach ($staffs as $i => $s) {
                $s->staff_order = $i;
            }

			
            $valid = $model->validate();
            $valid = Model::validateMultiple($transferables) && $valid;
			$valid = Model::validateMultiple($staffs) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            CourseTransferable::deleteAll(['id' => $deletedIDs]);
                        }
						if (! empty($deletedIDs)) {
                            CourseStaff::deleteAll(['id' => $staff_deletedIDs]);
                        }
                        foreach ($transferables as $i => $transfer) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $transfer->crs_version_id = $model->crs_version_id;

                            if (!($flag = $transfer->save(false))) {
                                break;
                            }
                        }
						foreach ($staffs as $i => $staff) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $staff->crs_version_id = $model->crs_version_id;

                            if (!($flag = $staff->save(false))) {
                                break;
                            }
                        }

                    }else{
						$model->flashError();
					}

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Course Profile updated");
                            return $this->redirect(['profile', 'course' => $course]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }
        }

        return $this->render('profile', [
            'model' => $model,
			'transferables' => (empty($transferables)) ? [new CourseTransferable] : $transferables,
			'staffs' => (empty($staffs)) ? [new CourseStaff] : $staffs
        ]);
    }
	
	public function actionCourseReference($course){
		$model = $this->findDevelopmentVersion($course);
		$ref = $model->references;
		
		if(Yii::$app->request->post()){
			if(Yii::$app->request->validateCsrfToken()){
				$post_ref = Yii::$app->request->post('ref');
				foreach($post_ref as $key => $pref){
					$ref = CourseReference::findOne($key);
					if($ref){
						$ref->ref_full = $pref['full'];
						$ref->ref_year = $pref['year'];
						$ref->is_main = $pref['main'];
						$ref->is_classic = $pref['isclassic'];
						$ref->save();
					}
				}
				

			}
			return $this->redirect(['course-reference', 'course' => $course]);
		}
		
		return $this->render('reference', [
            'model' => $model,
			'ref' => $ref
        ]);
	}
	
	public function actionCourseReferenceAdd($course, $version){
		$ref = new CourseReference;
		$ref->crs_version_id = $version;
		if($ref->save()){
			//
		}
		//$version = CourseVersion::findOne($version);
		//$course = $version->course_id;
		return $this->redirect(['course-reference','course'=>$course]);
	}
	
	public function actionCourseReferenceDelete($course, $version, $id){
		$ref = CourseReference::findOne(['crs_version_id' => $version, 'id' => $id]);
		$ref->delete();
		//$version = CourseVersion::findOne($version);
		//$course = $version->course_id;
		return $this->redirect(['course-reference','course'=>$course]);
	}
	
	public function actionCourseSyllabusAdd($version){
		$last_week = CourseSyllabus::find()->select('MAX(syl_order) as last_order')->where(['crs_version_id' => $version])->one();
		
		$syl = new CourseSyllabus;
		$syl->syl_order = $last_week->last_order;
		$syl->scenario = 'addweek';
		
		$syl->crs_version_id = $version;
		if($syl->save()){
			//
		}else{
			$syl->flashError();
		}
		$version = CourseVersion::findOne($version);
		$course = $version->course_id;
		return $this->redirect(['course-syllabus','course'=>$course]);
	}
	
	public function actionCourseSyllabusDelete($version, $id){
		$syl = CourseSyllabus::findOne(['crs_version_id' => $version, 'id' => $id]);
		$syl->delete();
		$version = CourseVersion::findOne($version);
		$course = $version->course_id;
		return $this->redirect(['course-syllabus','course'=>$course]);
	}
	
	public function actionCourseSyllabus($course){
		$model = $this->findDevelopmentVersion($course);
		$syllabus = $model->syllabus;
		
		$kira = count($syllabus);
		$clos = $model->clos;
		if(!$syllabus){
			$new = new CourseSyllabus;
			CourseSyllabus::createWeeks($model->id);
			return $this->redirect(['course-syllabus', 'course' => $course]);
		}
		
		if(Yii::$app->request->post()){
			if(Yii::$app->request->validateCsrfToken()){
				$i = 1;
				foreach($syllabus as $syl){
					if(Yii::$app->request->post('input-week-'.$i)){
						$syl->scenario = 'saveall';
						$syl->topics = Yii::$app->request->post('input-week-'.$i);
						$syl->week_num = Yii::$app->request->post('week-num-'.$i);
						if(Yii::$app->request->post($i . '-clo')){
							$clo = json_encode(Yii::$app->request->post($i . '-clo'));
							$syl->clo = $clo;
						}
						
						
						$syl->save();
					}
				$i++;
				}
				
				$model->study_week = Yii::$app->request->post('study-week');
				$model->final_week = Yii::$app->request->post('final-week');
				$model->save();
				
				Yii::$app->session->addFlash('success', "Data Updated");
			}
			return $this->redirect(['course-syllabus', 'course' => $course]);
			
		}
		
		return $this->render('syllabus', [
            'model' => $model,
			'syllabus' => $syllabus,
			'clos' => $clos
        ]);
	}
	
	public function actionCourseSyllabusReorder($id){
		$model = $this->findDevelopmentVersion($id);
		$syllabus = $model->syllabus;
		$reorder = Yii::$app->request->queryParams['or'];
		if($syllabus){
			foreach($syllabus as $s){
				if (array_key_exists($s->id,$reorder)){
					$s->syl_order = $reorder[$s->id];
					$s->save();
				}
				
			}
		}
		return $this->redirect(['course-syllabus', 'course' => $id]);
	}
	
	public function actionCourseCloDelete($version, $clo){
		$clo = CourseClo::findOne(['id' => $clo, 'crs_version_id' => $version]);
		$clo->delete();
		$version = CourseVersion::findOne($version);
		$course = $version->course_id;
		return $this->redirect(['course-clo','course'=>$course]);
	}
	public function actionCourseCloAdd($version){
		$clo = new CourseClo;
		$clo->crs_version_id = $version;
		if($clo->save()){
			//
		}
		$version = CourseVersion::findOne($version);
		$course = $version->course_id;
		return $this->redirect(['course-clo','course'=>$course]);
	}
	
	public function actionCourseClo($course)
    {
		
        $model = $this->findDevelopmentVersion($course);
		$clos = $model->clos;
        
        if (Yii::$app->request->post()) {
			if(Yii::$app->request->validateCsrfToken()){
				
				$flag = true;
                $post_clo = Yii::$app->request->post('CourseClo');
				foreach($post_clo as $key => $pclo){
					if(!$flag){
						break;
					}
					$clo = CourseClo::findOne($key);
					if($clo){
						$clo->clo_text = $pclo['clo_text'];
						$clo->clo_text_bi = $pclo['clo_text_bi'];
						if(!$clo->save()){
							$flag = false;
						}
					}
				}
            }
			if($flag){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['course-clo','course'=>$course]);
			}
			
		}
	
		return $this->render('clo', [
				'model' => $model,
				'clos' => $clos
			]);
	
	
	
	}
	
	public function actionCloPlo($course){
		$model = $this->findDevelopmentVersion($course);
		$clos = $model->clos;
		if (Yii::$app->request->post() ) {
			$flag = true;
			if(Yii::$app->request->validateCsrfToken()){
				
                $clos = Yii::$app->request->post('plo');
				if($clos){
					foreach($clos as $key => $plos){
						$row = CourseClo::findOne($key);
						if($row){
							foreach($plos as $p=>$plo){
								$row->{$p} = $plo;
							}
							if(!$row->save()){
								$flag = false;
								break;
							}
						}
					}
					
				}
				
            }
			if($flag){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['clo-plo', 'course' => $course]);
			}
			
			
		}
	
		return $this->render('clo_plo', [
				'model' => $model,
				'clos' => $clos
			]);
	}
	
	public function actionCloTaxonomy($course){
		$model = $this->findDevelopmentVersion($course);
		$clos = $model->clos;
		if (Yii::$app->request->post()) {
			if(Yii::$app->request->validateCsrfToken()){
                $clos = Yii::$app->request->post('taxo');
				if($clos){
					foreach($clos as $key => $plos){
						$row = CourseClo::findOne($key);
						if($row){
							foreach($plos as $p=>$plo){
								$row->{$p} = $plo;
							}
							$row->save();
						}
					}
				}
            }
			return $this->redirect(['clo-taxonomy', 'course' => $course]);
			
		}
	
		return $this->render('clo_taxonomy', [
				'model' => $model,
				'clos' => $clos
			]);
	}
	
	public function actionCloDelivery($course){
		$model = $this->findDevelopmentVersion($course);
		$clos = $model->clos;
		
		if (Yii::$app->request->post()) {
			if(Yii::$app->request->validateCsrfToken()){
				
				
                $clos = Yii::$app->request->post('method');
				if($clos){
					foreach($clos as $key => $clo){
						if($clo){
							foreach($clo as $k=>$d){
								$clodv = CourseCloDelivery::findOne(['clo_id' => $key, 'delivery_id' => $k]);
								if($d == 1){
									if(!$clodv){
										$add = new CourseCloDelivery;
										$add->clo_id = $key;
										$add->delivery_id = $k;
										$add->save();
									}
								}else{
									if($clodv){
										$clodv->delete();
									}
								}
								
							
							}
						}
					}
				}
            }
			return $this->redirect(['clo-delivery', 'course' => $course]);
			
		}
	
		return $this->render('clo_delivery', [
				'model' => $model,
				'clos' => $clos
			]);
	}
	
	public function actionCloSoftskill($course){
		$model = $this->findDevelopmentVersion($course);
		$clos = $model->clos;
		if (Yii::$app->request->post()) {
			if(Yii::$app->request->validateCsrfToken()){
                $clos = Yii::$app->request->post('ss');
				if($clos){
					foreach($clos as $key => $plos){
						$row = CourseClo::findOne($key);
						if($row){
							foreach($plos as $p=>$plo){
								$row->{$p} = $plo;
							}
							$row->save();
						}
					}
				}
            }
			return $this->redirect(['clo-softskill', 'course' => $course]);
			
		}
	
		return $this->render('clo_softskill', [
				'model' => $model,
				'clos' => $clos
			]);
	}
	
	public function actionCloAssessment($course){
		$model = $this->findDevelopmentVersion($course);
		$items = $model->assessments;
		if($model->putOneCloAssessment()){
			return $this->redirect(['course-assessment', 'course' => $course]);
		}
		
		$clos = $model->clos;
		if ($model->load(Yii::$app->request->post())) {
			if(Yii::$app->request->validateCsrfToken()){
                $cloAs = Yii::$app->request->post('CourseCloAssessment');
				if($cloAs){
					foreach($cloAs as $ca){
						$row = CourseCloAssessment::findOne($ca['id']);
						$row->assess_id = $ca['assess_id'];
						$row->percentage = $ca['percentage'];
						$row->save();
					}
				}
            }
			return $this->redirect(['clo-assessment', 'course' => $course]);
			
		}
	
		return $this->render('clo_assessment', [
				'model' => $model,
				'clos' => $clos,
				'assess' => $items
			]);
	}
	
	public function actionCourseSlt($course){
		$model = $this->findDevelopmentVersion($course);
		$slt = $model->slt;
		$syll = $model->syllabus;
		
		if ($model->load(Yii::$app->request->post())) {
	
			if(Yii::$app->request->validateCsrfToken()){
				$flag = true;
				$post_slt = Yii::$app->request->post('slt');
				foreach($post_slt as $key => $val){
				$slt->{$key} = $val;
				}
				$slt->is_practical = Yii::$app->request->post('is_practical');
				if(!$slt->save()){
					$flag = false;
				}
				
				$post_assess = Yii::$app->request->post('assess');
				if($post_assess){
					foreach($post_assess as $key => $val){
					$as = CourseAssessment::findOne($key);
					$as->scenario = 'update_slt';
					if($as){
						$as->assess_f2f = $val;
						if(!$as->save()){
							$flag = false;
							$as->flashError();
						}
					}
				}
				}
				
				$post_assess = Yii::$app->request->post('assess2');
				if($post_assess){
					foreach($post_assess as $key => $val){
					$as = CourseAssessment::findOne($key);
					$as->scenario = 'update_slt2';
					if($as){
						$as->assess_nf2f = $val;
						if(!$as->save()){
							$flag = false;
							$as->flashError();
						}
					}
				}
				}
				
				
				$post_assess = Yii::$app->request->post('syll');
				foreach($post_assess as $key => $val){
					$syl = CourseSyllabus::findOne($key);
					$syl->scenario = 'slt';
					if($syl){
						
						foreach($val as $i => $v){
							$syl->{$i} = $v;
						}
						if(!$syl->save()){
							$flag = false;
							$syl->flashError();
						}
					}
				}
            }
			//die();
			if($flag){
				Yii::$app->session->addFlash('success', "Student Learning Time has been successfully updated");
			}
			return $this->redirect(['course-slt', 'course' => $course]);
			
		}

		return $this->render('slt', [
				'model' => $model,
				'slt' => $slt,
				'syll' => $syll
			]);
	}
	
	public function actionCourseAssessment($course)
    {
        
        if (Yii::$app->request->post()) {
			if(Yii::$app->request->validateCsrfToken()){
				
                $assess = Yii::$app->request->post('CourseAssessment');
				if($assess){
				//print_r($assess);die();
				$final = 0;
				$flag = true;
				$transaction = Yii::$app->db->beginTransaction();
				foreach($assess as $key => $as){
					if(!$flag ){
						break;
					}
					//Yii::$app->session->addFlash('info', $as['id']);
					$assesment = CourseAssessment::findOne($as['id']);
					if($assesment){
						$cat = AssessmentCat::findOne($as['assess_cat']);
						$form_sum = $cat->form_sum;
						$final = $final + ($form_sum == 2 ? 1 : 0);
						$assesment->assess_name = $as['assess_name'];
						$assesment->assess_name_bi = $as['assess_name_bi'];
						$assesment->assess_cat = $as['assess_cat'];
						
						if($final > 1){
							Yii::$app->session->addFlash('error', "Only one final exam or assessment is allowed!");
							$flag = false;
							break;
						}
						
						
						if(!$assesment->save()){
							$flag = false;
							break;
						}
					}
				}
				if($flag){
					$transaction->commit();
					Yii::$app->session->addFlash('success', "Data Updated");
					return $this->redirect(['course-assessment','course'=>$course]);
					
				}else{
					$transaction->rollBack();
					return $this->redirect(['course-assessment','course'=>$course]);
				}
				
				}
				
            }
			
		}
		
	$model = $this->findDevelopmentVersion($course);
	$items = $model->assessments;
	
		return $this->render('assessment', [
				'model' => $model,
				'items' => (empty($items)) ? [] : $items,
			]);
	}
	
	public function actionCourseAssessmentAdd($version){
		$as = new CourseAssessment;
		$as->scenario = 'add';
		$as->crs_version_id = $version;
		$as->assess_cat = 1;
		$as->assess_name = 'assesment name';
		$as->assess_name_bi = 'assesment name - en';
		if($as->save()){
			$version = CourseVersion::findOne($version);
			$course = $version->course_id;
			$this->redirect(['course-assessment', 'course' => $course]);
		}else{
			$as->flashError();
		}
	}
	
	public function actionCourseAssessmentDelete($version, $id){
		$as = CourseAssessment::findOne(['crs_version_id' => $version, 'id' => $id]);
		$as->delete();
		$version = CourseVersion::findOne($version);
		$course = $version->course_id;
		return $this->redirect(['course-assessment','course'=>$course]);
	}
	
	public function actionAddAssessmentClo($course, $clo){
		$clo_as = new CourseCloAssessment;
		$clo_as->clo_id = $clo;
		$clo_as->save();
		$this->redirect(['clo-assessment', 'course' => $course]);
	}
	
	public function actionDeleteAssessmentClo($course, $id){
		$clo_as = CourseCloAssessment::findOne($id);
		$clo_as->delete();
		$this->redirect(['clo-assessment', 'course' => $course]);
	}
	
	
    /**
     * Deletes an existing Course model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	
	protected function findProfile($id)
    {
		$default = $this->findDevelopmentVersion($id);
		$model = CourseProfile::findOne(['crs_version_id' => $default->id]);
		if($model){
			return $model;
		}else{
			$profile = new CourseProfile;
			$profile->scenario = 'fresh';
			$profile->crs_version_id = $default->id;
			if($profile->save()){
				return $profile;
			}else{
				throw new NotFoundHttpException('There is problem creating course profile!');
			}
		}
    }
	
	protected function findDevelopmentVersion($id){
		$default = CourseVersion::findOne(['course_id' => $id, 'is_developed' => 1]);
		if($default){
			return $default;
		}else{
			throw new NotFoundHttpException('Please create development version for this course!');
		}
	}
	
	protected function findVersion($id){
		$default = CourseVersion::findOne($id);
		if($default){
			return $default;
		}else{
			throw new NotFoundHttpException('Page not found!');
		}
	}
	
	protected function findPublishedVersion($id){
		$default = CourseVersion::findOne(['course_id' => $id, 'is_published' => 1]);
		if($default){
			return $default;
		}else{
			throw new NotFoundHttpException('Please create published version for this course!');
		}
	}
	
	protected function findCourseClo($id)
    {
		$default = $this->findDevelopmentVersion($id);
		$model = CourseProfile::findOne(['crs_version_id' => $default->id]);
		if($model){
			return $model;
		}else{
			$model = new CourseClo;
			$model->scenario = 'fresh';
			$model->crs_version_id = $default->id;
			if($model->save()){
				return $model;
			}else{
				throw new NotFoundHttpException('There is problem creating this sub function course!');
			}
		}
    }
	
	public function actionFk1($course, $dev = false, $version = false){		
			$pdf = new Fk1;
			$pdf->model = $this->decideVersion($course, $dev, $version);
			$pdf->generatePdf();
	}
	
	public function actionFk2($course, $dev = false, $version = false){
			$pdf = new Fk2;
			$pdf->model = $this->decideVersion($course, $dev, $version);
			$pdf->generatePdf();
	}
	
	private function decideVersion($course, $dev, $version){
		if($version){
			//control access
			$model = $this->findVersion($version);
		}else if($dev){
			$model = $this->findDevelopmentVersion($course);
		}else{
			$published =CourseVersion::findOne(['course_id' => $course, 'is_published' => 1]);
			$developed =CourseVersion::findOne(['course_id' => $course, 'is_developed' => 1]);
			if($published){
				$model = $published;
			}else if($developed){
				$model = $developed;
			}else{
				die('Neither published nor development version exist!');
			}
		}
		return $model;
	}
	
	public function actionTbl4($course, $dev = false, $version = false){
			$pdf = new Tbl4;
			$pdf->model = $this->decideVersion($course, $dev, $version);
			$pdf->generatePdf();
	}
	
	public function actionTbl4Excel($course, $dev = false, $version = false){
			$pdf = new Tbl4Excel;
			$pdf->model = $this->decideVersion($course, $dev, $version);
			$pdf->generateExcel();
	}
	
	public function actionFk3($course, $dev = false, $version = false){
			$pdf = new Fk3;
			$pdf->model = $this->decideVersion($course, $dev, $version);
			$pdf->generatePdf();
	}
	
	public function actionDuplicate(){
		/* $clone = new CourseVersionClone;
		$clone->ori_version = 2;
		$clone->copy_version = 999;
		if($clone->cloneVersion()){
			echo 'good';
		} */
		
	}
	
	
	
}
