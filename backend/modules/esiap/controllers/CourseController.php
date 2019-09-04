<?php

namespace backend\modules\esiap\controllers;

use Yii;
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
use backend\modules\esiap\models\Fk1;
use backend\modules\esiap\models\Fk2;
use backend\modules\esiap\models\Fk3;
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
	
/* 	public function actionReref(){
		$ref = CourseReference::find()->all();
		foreach($ref as $r){
			$r->ref_full = $r->ref_author . ' (' . $r->ref_year .'). *'. $r->ref_title .'* '. $r->ref_others;
			$r->save();
		}
		
	} */
	
	 /**
     * Lists all CourseVersion models.
     * @return mixed
     */
    public function actionCourseVersion($course)
    {
        $searchModel = new CourseVersionSearch();
        $dataProvider = $searchModel->search($course, Yii::$app->request->queryParams);
		
		$courseModel = $this->findModel($course);

        return $this->render('../course-version/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'course' => $courseModel
        ]);
    }
	
	/**
     * Creates a new CourseVersion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCourseVersionCreate($course)
    {
        $model = new CourseVersion();

        if ($model->load(Yii::$app->request->post())) {
			
			$model->plo_num = 8;
			$model->course_id = $course;
			$model->created_by = Yii::$app->user->identity->id;
			$model->created_at = new Expression('NOW()');
			
			if($model->save()){
				return $this->redirect(['course-version', 'course' => $course]);
			}
            
        }

        return $this->render('../course-version/create', [
            'model' => $model,
        ]);
    }
	
	public function actionCourseVersionUpdate($id)
    {
        $model = CourseVersion::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
			
			if($model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['course-version', 'course' => $model->course->id]);
			}
            
        }

        return $this->render('../course-version/update', [
            'model' => $model,
        ]);
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
		$version = $model->defaultVersion;
		$version->scenario = 'save_date';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			if ($version->load(Yii::$app->request->post()) && $version->save()) {
				return $this->redirect(['update','course' => $course]);
			}
        }

        return $this->render('update', [
            'model' => $model,
			'version' => $version
        ]);
    }
	
	 public function actionReport($course)
    {
        $model = $this->findModel($course);
		
		$version = $model->defaultVersion;

        if ($version->load(Yii::$app->request->post())) {
			$version->prepared_at = new Expression('NOW()');
			$version->prepared_by = Yii::$app->user->identity->id;
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->addFlash('success', "Data Updated");
            return $this->redirect(['profile', 'course' => $course]);
        }

        return $this->render('profile', [
            'model' => $model,
        ]);
    }
	
	public function actionCourseReference($course){
		$model = $this->findDefaultVersion($course);
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
		$model = $this->findDefaultVersion($course);
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
		$model = $this->findDefaultVersion($id);
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
		
        $model = $this->findDefaultVersion($course);
		$clos = $model->clos;
        
        if (Yii::$app->request->post()) {
			if(Yii::$app->request->validateCsrfToken()){
				
                $post_clo = Yii::$app->request->post('CourseClo');
				if($post_clo){
					foreach($post_clo as $key => $pclo){
						$clo = CourseClo::findOne($key);
						if($clo){
							$clo->clo_text = $pclo['clo_text'];
							$clo->clo_text_bi = $pclo['clo_text_bi'];
							$clo->save();
						}
					}
				}
				
            }
			return $this->redirect(['course-clo','course'=>$course]);
		}
	
		return $this->render('clo', [
				'model' => $model,
				'clos' => $clos
			]);
	
	
	
	}
	
	public function actionCloPlo($course){
		$model = $this->findDefaultVersion($course);
		$clos = $model->clos;
		if (Yii::$app->request->post() ) {
			if(Yii::$app->request->validateCsrfToken()){
                $clos = Yii::$app->request->post('plo');
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
			return $this->redirect(['clo-plo', 'course' => $course]);
			
		}
	
		return $this->render('clo_plo', [
				'model' => $model,
				'clos' => $clos
			]);
	}
	
	public function actionCloTaxonomy($course){
		$model = $this->findDefaultVersion($course);
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
		$model = $this->findDefaultVersion($course);
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
		$model = $this->findDefaultVersion($course);
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
		$model = $this->findDefaultVersion($course);
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
		$model = $this->findDefaultVersion($course);
		$slt = $model->slt;
		$syll = $model->syllabus;
		if ($model->load(Yii::$app->request->post())) {
			
			if(Yii::$app->request->validateCsrfToken()){
				$post_slt = Yii::$app->request->post('slt');
				foreach($post_slt as $key => $val){
				$slt->{$key} = $val;
				}
				$slt->save();
				
				$post_assess = Yii::$app->request->post('assess');
				if($post_assess){
					foreach($post_assess as $key => $val){
					$as = CourseAssessment::findOne($key);
					$as->scenario = 'update_slt';
					if($as){
						$as->assess_hour = $val;
						if(!$as->save()){
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
							$syl->flashError();
						}
					}
				}
            }
			//die();
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
		
        $model = $this->findDefaultVersion($course);
		
		$items = $model->assessments;
		
        
        if (Yii::$app->request->post()) {
			if(Yii::$app->request->validateCsrfToken()){
				
                $assess = Yii::$app->request->post('CourseAssessment');
				

				
				foreach($assess as $key => $as){
					$assesment = CourseAssessment::findOne($as['id']);
					if($assesment){
						$assesment->assess_name = $as['assess_name'];
						$assesment->assess_name_bi = $as['assess_name_bi'];
						$assesment->assess_cat = $as['assess_cat'];
						$assesment->save();
					}
				}
				Yii::$app->session->addFlash('success', "Data Updated");
            }
			return $this->redirect(['course-assessment','course'=>$course]);
		}
		
		
	
	
		return $this->render('assessment', [
				'model' => $model,
				'items' => (empty($items)) ? [new CourseAssessment] : $items,
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
		$default = $this->findDefaultVersion($id);
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
	
	protected function findDefaultVersion($id){
		$default = CourseVersion::findOne(['course_id' => $id, 'is_active' => 1]);
		if($default){
			return $default;
		}else{
			throw new NotFoundHttpException('Please create default active version for this course!');
		}
	}
	
	protected function findCourseClo($id)
    {
		$default = $this->findDefaultVersion($id);
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
	
	public function actionFk1($course){
		$model = $this->findDefaultVersion($course);
			$pdf = new Fk1;
			$pdf->model = $model;
			$pdf->generatePdf();
	}
	
	public function actionTest($course){
		$model = $this->findDefaultVersion($course);
		$sum = $model->sltAssessmentSummative;
			echo $sum->as_hour;
	}
	
	public function actionFk2($course){
		$model = $this->findDefaultVersion($course);
			$pdf = new Fk2;
			$pdf->model = $model;
			$pdf->generatePdf();
	}
	
	public function actionFk3($course){
		$model = $this->findDefaultVersion($course);
			$pdf = new Fk3;
			$pdf->model = $model;
			$pdf->generatePdf();
	}
}
