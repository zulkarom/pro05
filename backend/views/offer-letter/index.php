<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'SURAT TAWARAN';
$this->params['breadcrumbs'][] = $this->title;
?>
  
 
  <?php $form = ActiveForm::begin(); ?>
  
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="application-index">

<div class="table-responsive">
   <?= GridView::widget([
        'dataProvider' => $dataProvider,
		
        'columns' => [
			['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],
			
			
			[
			 'attribute' => 'status',
			 'label' => 'Status',
			 'format' => 'html',
			 'value' => function($model){
				 return $model->getWfLabel();  
				 
				 }


			],
			
			
			[
			 'attribute' => 'fasi_id',
			 'label' => 'Nama Fasilitator',
			 'format' => 'html',
			 'value' => function($model){
				 return strtoupper($model->fasi->user->fullname) . '<br />' . $model->acceptedCourse->course->course_code . ' - ' . $model->acceptedCourse->course->course_name . ' ('.$model->applicationGroup->group_name .')';;
			 }
			],
			
		

            
			
			[
				'attribute' => 'ref_letter'
			
			],

            ['class' => 'yii\grid\ActionColumn',
				 'contentOptions' => ['style' => 'width: 8.7%'],
				'template' => '{view} {surat}',
				//'visible' => false,
				'buttons'=>[
					'view'=>function ($url, $model) {

						return '<a href="'.Url::to(['/application/view/', 'id' => $model->id]).'"><span class="glyphicon glyphicon-search"></span></a>';
					},
					'surat'=>function ($url, $model) {

						return '<a href="'.Url::to(['/offer-letter/pdf/', 'id' => $model->id]).'" target="_blank"><span class="glyphicon glyphicon-file"></span></a>';
					},
				],
			
			],
			
			

        ],
    ]); ?>
</div>
	
</div>
</div>
</div>

<div class="row">

<div class="col-md-6">


<div class="box">
<div class="box-header"></div>
<div class="box-body">


<div class="row">
<div class="col-md-8"><?=$form->field($model, 'ref_letter')?></div>
<div class="col-md-4"><?=$form->field($model, 'start_number')->textInput(['style' => 'width:70%']) ?></div>
</div>








</div>
</div>

<div class="form-group">
        
<?= Html::submitButton('Generate Reference', ['class' => 'btn btn-warning', 'name'=> 'actiontype', 'value' => 'generate']) ?>
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