<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\project\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'SENARAI PERUNTUKAN';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

<div class="form-group">

<div class="row">
<div class="col-md-2">
<a class="btn btn-primary btn-block btn-flat"><span class="glyphicon glyphicon-download-alt"></span> Batch 01<br />
RM300.00
</a>
</div>

<div class="col-md-2">
<a class="btn btn-primary btn-block btn-flat"><span class="glyphicon glyphicon-download-alt"></span> Batch 02<br />
RM350.00
</a>
</div>

<div class="col-md-2">
<span class="btn btn-block btn-flat bg-purple">JUMLAH<br />
RM650.00
</span>
</div>

</div>

</div>


<?=$this->render('_search', ['model' => $searchModel])?>


<?php $form = ActiveForm::begin(); ?>
<i>* senarai adalah yang telah dilulus sahaja</i>
    <div class="box">
<div class="box-body"><div class="table-responsive">

<?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        //'filterModel' => $searchModel,
        'columns' => [
			['class' => 'yii\grid\CheckboxColumn',
				 'checkboxOptions' => function($model, $key, $index, $column) {
						 return ['checked' => true];
				}
			],
            ['class' => 'yii\grid\SerialColumn'],
            [
				'label' => 'Nama',
				'value' => function($model){
					if($model->fasi){
						return strtoupper($model->eft_name);
					}
					
					;
				}
			],
			[
				'label' => 'No. Kad Pengenalan',
				'value' => function($model){
					if($model->fasi){
						return strtoupper($model->eftIcString);
					}
					
					;
				}
			],
			[
				'label' => 'No. Akaun',
				'value' => function($model){
					if($model->fasi){
						return strtoupper($model->eft_account);
					}
					
					;
				}
			],
			[
				'label' => 'Bank',
				'value' => function($model){
					if($model->fasi){
						return strtoupper($model->eft_bank);
					}
					
					;
				}
			],
            
			[
				'label' => 'Kod Kursus / Nama Kursus',
				'value' => function($model){
					if($model->fasi){
						if($model->course){
							return	strtoupper($model->course->course_name . ' ('. $model->group->group_name.')');
						}
						
					}
					
					;
				}
			],
			[
				'label' => 'Nama Program',
				'value' => function($model){
					return  strtoupper($model->pro_name);
				}
				
			],
			[
				'label' => 'Jumlah (RM)',
				'value' => function($model){
					if($model->resourceCenterAmount){
						return $model->resourceCenterAmount->rs_amount;
					}
					
				}
				
			],	
			
			[
				'label' => 'Kampus',
				'value' => function($model){
					return $model->campus->campus_name;
				}
				
			],
			
			[
				'label' => 'Tarikh Lulus',
				'value' => function($model){
					return date('d M Y', strtotime($model->approved_at));
				}
				
			],
			
			[
				'label' => 'Batch No.',
				'value' => function($model){
					return $model->batch_no;
				}
				
			],
			
			
            

            
        ],
    ]); ?></div></div>
</div>




</div>



    <?php ActiveForm::end(); ?>


