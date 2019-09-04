<?php
use common\models\Common;
use yii\widgets\DetailView;
use common\models\Fasi;
use common\models\ApplicationCourse;

$apply = $model->application;
$fasi = $apply->fasi;
?>

<div class="row">
<div class="col-md-6">
<div class="box">
<div class="box-header">

<h3 class="box-title"><i class="fa fa-asterisk"></i> BAHAGIAN A</h3>

</div>
<div class="box-body"><div class="claim-form">

 <?= DetailView::widget([
        'model' => $fasi,
        'attributes' => [
			[
				'attribute' => 'user.fullname',
				'label' => 'Nama Pemohon',
			]
            ,
			'staff_no',
			[
				'attribute' => 'office_phone',
				'label' => 'Pejabat / H/P',
				'value' => function($model){
					return $model->office_phone . ' / ' . $model->handphone;
				}
			],
			'nric',
			'department',
			'position_work',
			'position_grade',
			[
				'label' => 'Kelayakan Tertinggi',
				'value' => function($model){
					$edu = $model->getHighestEdu();
					return $edu->levelName->edu_name . ' (' .$edu->edu_name . ')';
				}
			],
			
			'address_office',
			'address_home'
			
			

            
            
        ],
    ]) ?>

</div></div>
</div></div>
<div class="col-md-6">

<div class="box">
<div class="box-header">

<h3 class="box-title"><i class="fa fa-asterisk"></i> MAKLUMAT LANTIKAN</h3>

</div>
<div class="box-body"><div class="claim-form">

 <?= DetailView::widget([
        'model' => $apply,
        'attributes' => [
		
            'fasi.user.fullname',
            [
			'attribute' => 'semester_id' ,
			'value' => function($model){
				return $model->semester->niceFormat();
			}],
			'campus.campus_name'
            ,
			[
				'attribute' =>'selected_course',
				'label' => 'Kursus',
				'value' => function($model){
					$course = ApplicationCourse::findOne(['application_id' => $model->id, 'is_accepted' => 1]);
					return $course->course->course_code . ' - ' . $course->course->course_name;
				}
				
			]
			,
			'applicationGroup.group_name',
			'rate_amount:currency',
			[
				'label' => 'Tempoh Kuatkuasa',
				'value' => function($model){
					return Common::date_malay_short($model->semester->date_start) .' - '.Common::date_malay_short($model->semester->date_end);
				}
			]
            
            
        ],
    ]) ?>

</div></div>
</div>





<?php if($model->month > 0){?>
<div class="box">
<div class="box-header">
<h3 class="box-title"><i class="fa fa-asterisk"></i> MAKLUMAT TUNTUTAN</h3>
</div>
<div class="box-body">

 <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			[
				'label' => 'Bulan',
				'value' => Common::months()[$model->month]
			],
            'year',
			[
				'label' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->getWfLabel();
				}
			]
            
            
        ],
    ]) ?>


</div>
</div>

<?php } ?>

</div>
</div>






