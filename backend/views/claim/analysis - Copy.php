<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\models\Campus;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ANALISIS TUNTUTAN';
$this->params['breadcrumbs'][] = $this->title;
?>
  
 
  <?php $form = ActiveForm::begin(); ?>
  
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="application-index">

<div class="table-responsive">
   <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			[
			 'attribute' => 'fasi_name',
			 'label' => 'Nama Fasilitator',
			 'value' => function($model){
				 return strtoupper($model->fasi->user->fullname);
			 }
			],
            [
			//'attribute' => 'semester_id' ,
			'label' => 'Kursus',
			'value' => function($model){
				return strtoupper($model->acceptedCourse->course->course_code . ' - ' . $model->acceptedCourse->course->course_name);
			},
			],
			
            [
			 'attribute' => 'campus_id',
			// 'label' => 'Location',
			//'with' => '10%',
			 'value' => function($model){
				 return strtoupper($model->campus->campus_name);
			 },
			 'filter' => Html::activeDropDownList($searchModel, 'campus_id', ArrayHelper::map(Campus::find()->asArray()->all(), 'id', 'campus_name'),['class'=> 'form-control','prompt' => 'Pilih Kampus']),
			],
			
			[
			'label' => 'Claims Details',
			'format' => 'html',
			'value' => function($model){
				$table = '<table width="100%">';
				if($model->claims){
					$hours = 0;
					foreach($model->claims as $claim){
						if($claim->status == 'ClaimWorkflow/ee-approved'){
							$gly = '<span class="glyphicon glyphicon-ok"></span>';
						}else{
							$gly = '';
						}
						$table .= '<tr>
							<td width="35%">' . $claim->month . '/'.$claim->year.'</td>
							<td>RM' . $claim->rate_amount . ' x ' . $claim->total_hour . ' = </td>
							<td>RM' . $claim->rate_amount * $claim->total_hour . ' '.$gly.'</td>
						</tr>';
						$hours += $claim->total_hour;
						
					}
					$table .= '<tr style="border-top:1px solid #000000">
							<td>TOTAL</td>
							<td>RM' . $claim->rate_amount . ' x ' . $hours . ' = </td>
							<td>RM' . $claim->rate_amount * $hours . ' '.$gly.'</td>
						</tr>';
				}
				
				
				$table .= '</table>';
				
				return $table;
			},
			],
			
			
			

        ],
    ]); ?>
</div>
	
</div>
</div>
</div>




<?php ActiveForm::end(); ?>


<?php 

$js = '
$("#checkAll").click(function(){
    $(\'input:checkbox\').not(this).prop(\'checked\', this.checked);
});

';
$this->registerJs($js);
?>