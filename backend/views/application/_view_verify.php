<?php
use yii\widgets\DetailView;
use common\models\ApplicationCourse;
?>

<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">MAKLUMAT SOKONGAN</h3>

</div>
<div class="box-body">

	
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			[
				'attribute' =>'selected_course',
				'value' => function($model){
					$course = ApplicationCourse::findOne(['application_id' => $model->id, 'is_accepted' => 1]);
					if($course){
						return $course->course->course_code . ' - ' . $course->course->course_name;
					}
					
				}
				
			]
			,
			'groupName',
			[
                'attribute' => 'rate_amount',
                'value' => function($model){
                    return 'RM'. $model->rate_amount;
                    
                }
                
            ],
			
			[
			 'attribute' => 'verifier.fullname',
			 'label' => 'Disokong oleh'
			],
			'verify_note',
			'verified_at:datetime',

            
        ],
    ]) ?>

</div>
</div>