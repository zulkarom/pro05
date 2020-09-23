<?php

namespace backend\modules\esiap\models;


use Yii;
use yii\helpers\Url;
use backend\models\Faculty;
use backend\models\Department;
use common\models\User;
use backend\models\Component;
use yii\bootstrap\Modal;



/**
 * This is the model class for table "sp_course".
 *
 * @property int $id
 * @property string $course_code
 * @property string $course_name
 * @property string $course_name_bi
 * @property int $credit_hour
 * @property int $crs_type
 * @property int $crs_level
 * @property int $faculty
 * @property int $department
 * @property int $program
 * @property int $is_dummy
 */
class Course extends \yii\db\ActiveRecord
{
	public $course_label;
	public $course_data;
	public $course_code_name;
	public $staff_pic;
	public $staff_access;
	public $progress;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			
			[['course_name', 'course_name_bi', 'course_code', 'credit_hour', 'is_dummy', 'faculty_id', 'course_type'], 'required', 'on' => 'create'],
			
			[['course_name', 'course_name_bi', 'course_code', 'credit_hour', 'is_dummy'], 'required', 'on' => 'update'],
			
			[['course_name', 'course_name_bi', 'course_code', 'credit_hour', 'course_class'], 'required', 'on' => 'update2'],
			
            [['program_id', 'department_id', 'faculty_id', 'is_dummy', 'course_type', 'is_active', 'method_type', 'component_id', 'course_class'], 'integer'],
			
            [['course_name', 'course_name_bi'], 'string', 'max' => 100],
			
            [['course_code'], 'string', 'max' => 50],
			
			[['credit_hour'], 'integer'],
			
			/* ['course_code', 'unique', 'targetClass' => '\backend\modules\esiap\models\Course', 'message' => 'This course code has already been taken'], */
			
        ];
    }

        /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_name' => 'Course Name (BM)',
			'course_name_bi' => 'Course Name (EN)',
            'course_code' => 'Course Code',
			'is_developed' => 'Is Active',
			'program_id' => 'Program',
			'faculty_id' => 'Faculty',
			'department_id' => 'Department',
			'course_class' => 'Course Classification'
        ];
    }
	
	
	public function getCoursePics(){
		return $this->hasMany(CoursePic::className(), ['course_id' => 'id']);
	}
	
	public function getPicStr(){
		$list = $this->coursePics;
		$str = '';
		if($list){
			$i = 1;
			foreach($list as $pic){
				$br = $i == 1 ? '' : '<br />';
				$str .= $br. strtoupper($pic->staff->user->fullname);
				
			$i++;
			}
		}
		return $str;
	}
	
	public function getStaffViewStr(){
		$list = $this->courseAccesses;
		$str = '';
		if($list){
			$i = 1;
			foreach($list as $acc){
				$br = $i == 1 ? '' : '<br />';
				$str .= $br. strtoupper($acc->staff->user->fullname);
				
			$i++;
			}
		}
		return $str;
	}
	
	public function getCourseAccesses(){
		return $this->hasMany(CourseAccess::className(), ['course_id' => 'id']);
	}
	
	public function IAmCoursePic(){
		$pics = $this->coursePics;
		if($pics){
			foreach($pics as $pic){
				if($pic->staff_id == Yii::$app->user->identity->staff->id){
					return true;
				}
			}
		}
		return false;
	}
	
	public function getCodeAndCourse(){
		return $this->course_code . ' - ' . $this->course_name;
	}
	
	public function getCodeCourseCredit(){
		return strtoupper($this->course_code . ' - ' . $this->course_name . ' (' . $this->credit_hour . ' CREDIT HOURS)');
	}
	
	public static function activeCourses(){
		return self::find()->where(['is_dummy' => 0, 'is_active' => 1, 'faculty_id' => Yii::$app->params['faculty_id']])->orderBy('course_name ASC')->all();
	}
	
	public static function activeCoursesNameCode(){
		return self::find()
		->select(['id', 'concat(course_code, " - ", course_name) AS course_code_name'])
		->where(['is_dummy' => 0, 'is_active' => 1, 'faculty_id' => Yii::$app->params['faculty_id']])
		->orderBy('course_name ASC')
		->all();
	}
	
	public function getCodeBrCourse(){
		return $this->course_code . '<br />' . $this->course_name;
	}
	
	public function getCodeCourseString(){
		return $this->course_code . ' ' . strtoupper($this->course_name);
	}
	
	public function allCoursesArray(){
		$result = self::find()->orderBy('course_name ASC')
		->where(['faculty_id' => Yii::$app->params['faculty_id'], 'is_dummy' => 0])
		->all();
		$array[0] = 'Tiada / Nil';
		foreach($result as $row){
			$array[$row->id] = $row->course_name .' - '.$row->course_code;
		}
		return $array;
	}
	
	public function flashError(){
        if($this->getErrors()){
            foreach($this->getErrors() as $error){
                if($error){
                    foreach($error as $e){
                        Yii::$app->session->addFlash('error', $e);
                    }
                }
            }
        }

    }
	
	public function getDevelopmentVersion(){
		return CourseVersion::findOne(['course_id' => $this->id, 'is_developed' => 1]);

	}
	
	public function getPublishedVersion(){
		return CourseVersion::findOne(['course_id' => $this->id, 'is_published' => 1]);

	}
	
	public function getVersions(){
		return $this->hasMany(CourseVersion::className(), ['course_id' => 'id'])->orderBy('created_at DESC');
	}
	
	public function getDefaultVersion(){
		if($this->publishedVersion){
			return $this->publishedVersion;
		}else if($this->developmentVersion){
			return $this->developmentVersion;
		}else{
			return false;
		}
	}
	
	public function getFaculty(){
        return $this->hasOne(Faculty::className(), ['id' => 'faculty_id']);
    }
	
	public function getDepartment(){
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }
	
	public function getClassification(){
        return $this->hasOne(CourseClass::className(), ['id' => 'course_class']);
    }
	
	public function getProgram(){
        return $this->hasOne(Program::className(), ['id' => 'program_id']);
    }
	
	public function getCourseVersion(){
		return $this->hasMany(CourseVersion::className(), ['course_id' => 'id'])->orderBy('sp_course_version.created_at DESC');
	}
	
	public function getComponent(){
		return $this->hasOne(Component::className(), ['id' => 'component_id']);
	}
	
	public function getLevel(){
		return $this->hasOne(CourseLevel::className(), ['id' => 'course_level']);
	}
	
	
	public function getCoor(){
		return $this->hasOne(User::className(), ['id' => 'coordinator']);
	}
	
	public function reportList($text, $version_id = false){
		if($version_id){
			$version = CourseVersion::findOne($version_id);
		}else{
			$version = $this->defaultVersion;
		}
		
		if($version){
			$html = '<button type="button" class="btn btn-default" data-toggle="modal" data-target="#course-'.$this->id.'-version-'.$version->id .'"><span class="fa fa-files-o"></span> View Documents</button>

		<div id="course-'.$this->id.'-version-'.$version->id .'" class="fade modal" role="dialog" tabindex="-1" style="display: none;">
		<div class="modal-dialog modal-md">
		<div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		'.$this->course_code.' '. strtoupper($this->course_name).'
		</div>
		<div class="modal-body">
		';
//<a target="_blank" href="'.Url::to(['/esiap/course/tbl4', 'course' => $this->id, 'version' => $version->id]).'" class="btn btn-app"><i class="fa fa-file-pdf-o"></i> TABLE 4 v1.0</a>
		$html .= '
		
		<div class="form-group">
		
		VERSION: '.$version->version_name .'
		<br />STATUS: '.$version->labelStatus .'
		
		</div>
	  
		<a target="_blank" href="'.Url::to(['/esiap/course/html-view', 'course' => $this->id, 'version' => $version->id]).'" class="btn btn-app"> <i class="fa fa-globe"></i> HTML</a>
		
		
		<a target="_blank" href="'.Url::to(['/esiap/course/fk1', 'course' => $this->id, 'version' => $version->id]).'" class="btn btn-app"><i class="fa fa-file-pdf-o"></i> FK01</a>
		
		<a target="_blank" href="'.Url::to(['/esiap/course/fk2', 'course' => $this->id, 'version' => $version->id]).'" class="btn btn-app"><i class="fa fa-file-pdf-o"></i> FK02</a>
		
		<a target="_blank" href="'.Url::to(['/esiap/course/fk3', 'course' => $this->id, 'version' => $version->id]).'" class="btn btn-app"><i class="fa fa-file-pdf-o"></i> FK03</a>
		
		<br />
		
		
		
		<a target="_blank" href="'.Url::to(['/esiap/course/tbl4-excel', 'course' => $this->id, 'version' => $version->id]).'" class="btn btn-app"><i class="fa fa-file-excel-o"></i> TABLE 4 v1.0</a>
		
		<a target="_blank" href="'.Url::to(['/esiap/course/tbl4-excel2', 'course' => $this->id, 'version' => $version->id]).'" class="btn btn-app"><i class="fa fa-file-excel-o"></i> TABLE 4 v2.0</a>
		
		';
	  
		$html .= '</div>
<div class="modal-footer">
<div class="form-group">
			<button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-default">Close</button> 
				
			 </div>
</div>
</div>
</div>
</div>';
		}else{
			$html = 'NO VERSION';
		}
		
			

return $html;
		
	}

}
