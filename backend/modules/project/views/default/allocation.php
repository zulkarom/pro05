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


<?php 
$batches = $searchModel->batches;
$jum = 0;
if($batches){
	foreach($batches as $bat){
		$name = $bat->batch;
		if($name){
			if($name == '-'){
				$color = 'warning';
				$icon = 'fa fa-circle-thin';
			}else{
				$color = 'primary';
				$icon = 'glyphicon glyphicon-download-alt';
			}
			$amount = $searchModel::getAllocationByBatch($name);
			echo '<div class="col-md-2">
			<a href="'. Url::to(['batch-pdf', 'batch' => $name]) .'" target="_blank" class="btn btn-'.$color.' btn-block btn-flat"><span class="'.$icon.'"></span> Batch '.$name .'<br />
			RM'.number_format($amount, 2).'
			</a>
			</div>';
		$jum += $amount;
		}
		
	}
}

?>

<div class="col-md-2">
<span class="btn btn-block btn-flat bg-purple"><b><span class="fa fa-money"></span> JUMLAH</b><br />
<b>RM<?=number_format($jum, 2)?></b>
</span>
</div>

</div>

</div>


<?=$this->render('_search', ['model' => $searchModel])?>


<?php $form = ActiveForm::begin(['id'=>'form-allocation']); ?>
<i>* senarai adalah yang telah dilulus sahaja</i>
    <div class="box">
<div class="box-body"><div class="table-responsive">
<input type="hidden" id="batch_name" name="batch_name" value="" />
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


