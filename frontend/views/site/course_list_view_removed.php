<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Courses';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="ftco-services ftco-no-pb">
		<div class="container">
		<div class="col-md-12 text-center heading-section">
            <h2 class="mb-4"><span>Senarai Kursus</span> </h2>
            
          </div>

<div class="row">

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
		'summary'=>'', 
        //'filterModel' => $searchModel,
        'itemView' => function($model){
			?>
			
			<div class="col-md-3">
						<?php 
							$synop = $model->defaultVersion->profile->synopsis;
							$synop_bi = $model->defaultVersion->profile->synopsis_bi;
							$code = $model->course_code;
							$name = $model->course_name;
							?>
						<div class="text bg-light p-4">
							<h3><a href="#"><?=$code?></a></h3>
							<h4><?=$name?></h4>
							<p>Kategori: <?=$model->component->name?></p>
							
						
							<p>
							
							<?php 
							Modal::begin([
								'title' => $code,
								'size' => 'modal-lg',
								'footer' => '<button type="button" class="btn btn-outline-default" data-dismiss="modal">Close</button>',
								
								'toggleButton' => ['label' => 'Sinopsis', 'class'=> 'btn btn-secondary'],
							]);
							echo '<h3>' . $code .' '. $name . '</h3>';
							
							echo $synop .'<br /><br />';
							
							echo '<a href="javascript:void(0)" class="btn_syp_en">English Synopsis</a>';
							
							echo '<br /><br /><i class="syp_en" style="display:none">'.$synop_bi .'</i>';

							Modal::end();

							?>
							
							
							</p>
						</div>
						<br />
			</div>
			
			
			<?php
		}
    ]); ?>
	</div>
</div>

</section>


