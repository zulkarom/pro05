<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
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

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
					
					['label' => 'Main Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/site']],
					
					[
                        'label' => 'Permohonan Fasilitator',
                        'icon' => 'user',
                        'url' => '#',
                        'items' => [
							
							['label' => 'Senarai Permohonan', 'icon' => 'list-alt', 'url' => ['/application/index']],
							
							['label' => 'Analisis Permohonan', 'icon' => 'pie-chart', 'url' => ['/application/analysis']],

							['label' => 'Rujukan Surat Tawaran', 'icon' => 'file', 'url' => ['/offer-letter/index'],],
						
                            ['label' => 'Release Letter', 'icon' => 'truck', 'url' => ['/offer-letter/release'],],
							
							['label' => 'Fasilitator Tasks', 'icon' => 'user', 'url' => ['/fasi-task/index'],],
							
	
							

                        ],
                    ],
					
					[
                        'label' => 'Tuntutan Fasilitator',
                        'icon' => 'money',
                        'url' => '#',
                        'items' => [

							['label' => 'Senarai Tuntutan', 'icon' => 'list-alt', 'url' => ['/claim/index']],
					
					['label' => 'Analisis Tuntutan', 'icon' => 'pie-chart', 'url' => ['/claim/analysis']],

                        ],
                    ],
		
					
					
					
					
					[
                        'label' => 'Kertas Kerja',
                        'icon' => 'files-o',
                        'url' => '#',
                        'items' => [

							['label' => 'Senarai Kertas Kerja', 'icon' => 'list-alt', 'url' => ['/project-admin']],
							['label' => 'Lulus Kertas Kerja', 'icon' => 'check', 'url' => ['/project-admin/default/approve']],
							['label' => 'Surat Kelulusan', 'icon' => 'file', 'url' => ['/project-admin/default/letter']],
							['label' => 'Senarai Peruntukan', 'icon' => 'money', 'url' => ['/project-admin/default/allocation']],
                            ['label' => 'Penyelaras', 'icon' => 'user', 'url' => ['/project-admin/coordinator']],
							['label' => 'Milestone', 'icon' => 'truck', 'url' => ['/project-admin/default/milestone']],

                        ],
                    ],
							
					
					['label' => 'Urus Semester', 'icon' => 'calendar-plus-o', 'url' => ['/semester/index'],],
					
		
					
					[
                        'label' => 'Urus Kursus',
                        'icon' => 'book',
                        'url' => '#',
                        'items' => [

							['label' => 'Senarai Kursus', 'icon' => 'book', 'url' => ['/esiap/course-admin']],
						
                            ['label' => 'Urus Penawaran', 'icon' => 'book', 'url' => ['/course/index']],

                        ],
                    ],
					
					

					
					//courses
					[
                        'label' => 'User Management',
                        'icon' => 'lock',
                        'url' => '#',
                        'items' => [
						
							['label' => 'User List', 'icon' => 'user', 'url' => ['/user/index'],],
							
							['label' => 'Fasilitator List', 'icon' => 'user', 'url' => ['/fasi/index'],],
							
							//['label' => 'User Signup', 'icon' => 'plus', 'url' => ['/admin/user/signup'],],
							
							
							['label' => 'User Assignment', 'icon' => 'user', 'url' => ['/admin'],],
						
                            ['label' => 'User Role List', 'icon' => 'user', 'url' => ['/admin/role'],],
							
							['label' => 'Route List', 'icon' => 'user', 'url' => ['/admin/route'],],
							
	
							

                        ],
                    ],
					
					[
                        'label' => 'Setting',
                        'icon' => 'cog',
                        'url' => '#',
                        'items' => [
							['label' => 'General Setting', 'icon' => 'cog', 'url' => ['/general-setting/update', 'id' => 1],],
							
							['label' => 'Claim Setting', 'icon' => 'cog', 'url' => ['/claim-setting/update', 'id' => 1],],
						
                            ['label' => 'Komponen', 'icon' => 'th-large', 'url' => ['/component/index'],],
                        ],
                    ],
					
					
					['label' => 'Ubah Kata Laluan', 'icon' => 'lock', 'url' => ['/user/change-password']],
					
					['label' => 'Log Keluar', 'icon' => 'arrow-left', 'url' => ['/site/logout'], 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>']
					
            
                  
                ],
            ]
        ) ?>

    </section>

</aside>
