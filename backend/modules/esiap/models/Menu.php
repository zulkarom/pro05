<?php

namespace backend\modules\esiap\models;

use Yii;

class Menu
{
	
	
	public static function courseFocus(){
		$course_focus = [];
		if(Yii::$app->controller->id == 'course' and Yii::$app->controller->module->id == 'esiap'){
			switch(Yii::$app->controller->action->id){
				case 'update': case 'profile':case 'course-clo':
				case 'course-syllabus':case 'course-assessment':
				case 'clo-assessment':case 'course-slt': case 'clo-plo':
				case 'clo-taxonomy':case 'clo-softskill': case 'course-reference':
				case 'clo-delivery':case 'report':case 'view-course':
				$course_id = Yii::$app->getRequest()->getQueryParam('course');
				$course = Course::findOne($course_id);
				$version = $course->developmentVersion;
				$status = $version->status;
				$show = false;
				if($status == 0 and $course->IAmCoursePic()){
					$show = true;
				}
				$course_focus  = [
					'label' => $course->course_code,
					'icon' => 'book',
					'format' => 'html',
					'url' => '#',
					'items' => [
					
				['label' => 'View Course', 'visible' => $show, 'icon' => 'eye', 'url' => ['/esiap/course/view-course', 'course' => $course_id]],
						
				['label' => 'Course Profile', 'visible' => $show, 'icon' => 'pencil', 'url' => ['/esiap/course/update', 'course' => $course_id]],
				
				['label' => 'Assessment', 'visible' => $show, 'icon' => 'pencil', 'url' => ['/esiap/course/course-assessment', 'course' => $course_id]],
				
				['label' => 'CLOs',  'icon' => 'pencil', 'url' => '#', 
					'items' => [
						['label' => 'CLO Text', 'visible' => $show, 'icon' => 'pencil', 'url' => ['/esiap/course/course-clo', 'course' => $course_id]],
				
						['label' => 'PLO', 'icon' => 'pencil', 'visible' => $show, 'url' => ['/esiap/course/clo-plo', 'course' => $course_id]],
						
						['label' => 'Taxonomy', 'visible' => $show, 'icon' => 'pencil', 'url' => ['/esiap/course/clo-taxonomy', 'course' => $course_id]],
						
						['label' => 'Teaching Methods', 'visible' => $show, 'icon' => 'pencil', 'url' => ['/esiap/course/clo-delivery', 'course' => $course_id]],
						
						['label' => 'Assessment', 'visible' => $show, 'icon' => 'pencil', 'url' => ['/esiap/course/clo-assessment', 'course' => $course_id]],
						
						['label' => 'Softskills', 'visible' => $show, 'icon' => 'pencil', 'url' => ['/esiap/course/clo-softskill', 'course' => $course_id]],
					]
				],
				
				
				
				
				
				['label' => 'Course Syllabus', 'visible' => $show, 'icon' => 'pencil', 'url' => ['/esiap/course/course-syllabus', 'course' => $course_id]],
				
				
				
				
				
				['label' => 'Student Learning Time', 'visible' => $show, 'icon' => 'pencil', 'url' => ['/esiap/course/course-slt', 'course' => $course_id]],
				
				
				['label' => 'References', 'visible' => $show, 'icon' => 'pencil', 'url' => ['/esiap/course/course-reference', 'course' => $course_id]],
				
				['label' => 'Preview & Submit', 'icon' => 'search', 'url' => ['/esiap/course/report', 'course' => $course_id]],

                 ]
                    ];
				break;
			}
		}
		
		return $course_focus;
	}
	
	
	public static function adminEsiap(){
		$esiap_admin = [
                        'label' => 'eSIAP Admin',
                        'icon' => 'mortar-board',
						'visible' => Yii::$app->user->can('esiap-management'),
                        'url' => '#',
                        'items' => [
				['label' => 'My Course(s)', 'icon' => 'user', 'url' => ['/esiap']],
				
				['label' => 'Summary', 'icon' => 'pie-chart', 'url' => ['/esiap/dashboard']],
				
				['label' => 'Course List', 'icon' => 'book', 'url' => ['/esiap/course-admin']],
				
				//['label' => 'Bulk Course Version', 'icon' => 'book', 'url' => ['/esiap/course-admin/bulk-version']],
				
				['label' => 'Program List', 'icon' => 'book', 'url' => ['/esiap/program-admin']],
				
				
				
				['label' => 'Inactive Courses', 'icon' => 'remove', 'url' => ['/esiap/course-admin/inactive']],
				

                 ]
                    ];	
		return $esiap_admin;
	}

}
