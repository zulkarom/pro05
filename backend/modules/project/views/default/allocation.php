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
<?php $form = ActiveForm::begin(); ?>
<i>* senarai adalah yang telah dilulus sahaja</i>
    <div class="box">
<div class="box-body"><div class="table-responsive">

<?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        //'filterModel' => $searchModel,
        'columns' => [
			['class' => 'yii\grid\CheckboxColumn'],
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
						return	strtoupper($model->course->course_name . ' ('. $model->group->group_name.')');
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
					return $model->resourceCenterAmount->rs_amount;
				}
				
			],	
			
			[
				'label' => 'Kampus',
				'value' => function($model){
					return $model->campus->campus_name;
				}
				
			],
			
			'approved_at:date'
            

            
        ],
    ]); ?></div></div>
</div>




</div>



    <?php ActiveForm::end(); ?>


