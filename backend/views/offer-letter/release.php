<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'RELEASE LETTER';
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
				 return strtoupper($model->fasi->user->fullname) . '<br />' . $model->acceptedCourse->course->course_code . ' - ('.$model->applicationGroup->group_name .')';
			 }
			],
			
	
			
			
			[
				'attribute' => 'ref_letter'
			
			],

            ['class' => 'yii\grid\ActionColumn',
				 'contentOptions' => ['style' => 'width: 8.7%'],
				'template' => '{surat}',
				//'visible' => false,
				'buttons'=>[
	
					'surat'=>function ($url, $model) {

						return '<a href="'.Url::to(['/offer-letter/pdf/', 'id' => $model->id]).'" target="_blank" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-download-alt"></span></a>';
					},
				],
			
			],
			
			

        ],
    ]); ?>
</div>
	
</div>
</div>
</div>

<div class="form-group">

<?=$form->field($model, 'released_at')->hiddenInput(['value' => time()])->label(false)?>
<?= Html::submitButton('RELEASE ALL SELECTED', ['class' => 'btn btn-primary', 'name'=> 'actiontype', 'value' => 'release']) ?>


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