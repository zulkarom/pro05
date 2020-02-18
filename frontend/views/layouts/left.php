<?php 
use yii\helpers\Url;
use backend\modules\esiap\models\CoursePic;
use backend\modules\esiap\models\Course;
?>

<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= Url::to(['/profile/image']) ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->fullname?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
		
		<?php 
		
		$course_focus = [];
		if(Yii::$app->controller->id == 'course' and Yii::$app->controller->module->id == 'esiap'){
			switch(Yii::$app->controller->action->id){
				case 'update': case 'profile':case 'course-clo':
				case 'course-syllabus':case 'course-assessment':
				case 'clo-assessment':case 'course-slt': case 'clo-plo':
				case 'clo-taxonomy':case 'clo-softskill': case 'course-reference':
				case 'clo-delivery': case 'report':
				$course_id = Yii::$app->getRequest()->getQueryParam('course');
				
				$course = Course::findOne($course_id);
				
				$status = $course->developmentVersion->status;
				
				if($status == 0){
					$visi = true;
				}else{
					$visi = false;
				}
				
				$course_focus  = [
                        'label' => $course->course_name,
                        'icon' => 'book',
						'format' => 'html',
                        'url' => '#',
                        'items' => [
						
				['label' => 'Course Information', 'visible' => $visi, 'icon' => 'pencil', 'url' => ['/esiap/course/update', 'course' => $course_id]],
				
				
				['label' => 'Course Profile', 'visible' => $visi,'icon' => 'book', 'url' => ['/esiap/course/profile', 'course' => $course_id]],
				
				['label' => 'Course Learning Outcome', 'visible' => $visi,'icon' => 'book', 'url' => ['/esiap/course/course-clo', 'course' => $course_id]],
				
				['label' => 'CLO PLO', 'visible' => $visi,'icon' => 'book', 'url' => ['/esiap/course/clo-plo', 'course' => $course_id]],
				
				['label' => 'CLO Taxonomy', 'visible' => $visi,'icon' => 'book', 'url' => ['/esiap/course/clo-taxonomy', 'course' => $course_id]],
				
				['label' => 'CLO Softskill', 'visible' => $visi,'icon' => 'book', 'url' => ['/esiap/course/clo-softskill', 'course' => $course_id]],
				
				['label' => 'CLO Delivery', 'visible' => $visi,'icon' => 'book', 'url' => ['/esiap/course/clo-delivery', 'course' => $course_id]],
				
				
				['label' => 'Syllabus', 'visible' => $visi, 'icon' => 'book', 'url' => ['/esiap/course/course-syllabus', 'course' => $course_id]],
				['label' => 'Assessment', 'visible' => $visi, 'icon' => 'book', 'url' => ['/esiap/course/course-assessment', 'course' => $course_id]],
				['label' => 'Student Learning Time', 'visible' => $visi, 'icon' => 'book', 'url' => ['/esiap/course/course-slt', 'course' => $course_id]],
				
				
				['label' => 'CLO Assessment', 'visible' => $visi, 'icon' => 'book', 'url' => ['/esiap/course/clo-assessment', 'course' => $course_id]],
				
				['label' => 'References', 'visible' => $visi, 'icon' => 'book', 'url' => ['/esiap/course/course-reference', 'course' => $course_id]],
				
				['label' => 'Preview & Submit', 'icon' => 'book', 'url' => ['/esiap/course/report', 'course' => $course_id]],

                 ]
                    ];
				break;
			}
		}
		
		
		$penyelaras = [];
		
		$coor = CoursePic::find()->where(['staff_id' => Yii::$app->user->identity->staff->id])->all();
		
		if($coor){
			foreach($coor as $c){
				$ver = $c->course->developmentVersion->status;
				if($ver == 0){
					$rt = '/esiap/course/update';
				}else{
					$rt = '/esiap/course/report';
				}
				$arr[] = ['label' => $c->course->course_name, 'icon' => 'book', 'url' => [$rt, 'course' => $c->course_id]];
			}
			
			$menu_coor = [
                        'label' => 'Penyelaras Kursus',
                        'icon' => 'book',
                        'url' => '#',
                        'items' => $arr,
                    ]
				;
				
			$penyelaras  = $menu_coor;	
		}
		
		
		
		
		
		?>

        <?php
		
				$menuItems = [
					
					$course_focus,
					
					
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/dashboard/index']],
					
					
					[
                        'label' => 'Maklumat Fasilitator',
                        'icon' => 'user',
                        'url' => '#',
                        'items' => [
						
                            ['label' => 'Maklumat Peribadi', 'icon' => 'user', 'url' => ['/profile/index']],
							
							['label' => 'Maklumat Pekerjaan', 'icon' => 'ship', 'url' => ['/profile/job']],
							
							['label' => 'Pendidikan', 'icon' => 'mortar-board', 'url' => ['/profile/education']],
							
							['label' => 'Pengalaman', 'icon' => 'male', 'url' => ['/profile/experience'],],
							
							['label' => 'Dokumen', 'icon' => 'files-o', 'url' => ['/document/index'],],
							
							['label' => 'Preview', 'icon' => 'search', 'url' => ['/profile/preview'],],
							

                        ],
                    ],
					
					['label' => 'Permohonan Fasilitator', 'icon' => 'mouse-pointer', 'url' => ['/application/index']],
					
					['label' => 'Senarai Tuntutan', 'icon' => 'usd', 'url' => ['/claim/index']],
					
					
					[
                        'label' => 'Kertas Kerja',
                        'icon' => 'files-o',
                        'url' => '#',
                        'items' => [
						
                            ['label' => 'Semak & Hantar', 'icon' => 'search', 'url' => ['/project/fasi/index']],
							
							['label' => 'Tukar Kata Kunci', 'icon' => 'lock', 'url' => ['/project/fasi/change-key']],
							
				
							
							['label' => 'Penyelaras', 'icon' => 'user', 'url' => ['/project/fasi/coordinator']],
							
							

                        ],
                    ],
					
					$penyelaras ,
					
					//['label' => 'Kerja Kursus', 'icon' => 'truck', 'url' => ['#']],
					
					['label' => 'Ubah Kata Laluan', 'icon' => 'lock', 'url' => ['/user-setting/change-password']],
					
					['label' => 'Log Keluar', 'icon' => 'arrow-left', 'url' => ['/site/logout'], 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>']
					
					
					
					

					
					//my request
					
			
                    
                ];
				
				?>
		
		<?php 
		
		$favouriteMenuItems[] = ['label' => 'MAIN MENU', 'options' => ['class' => 'header']];
		
		echo dmstr\widgets\Menu::widget([
			'items' => \yii\helpers\ArrayHelper::merge($favouriteMenuItems, $menuItems),
		]);
		
		
		?>

    </section>

</aside>
