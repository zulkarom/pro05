<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Application */

$this->title = 'PERMOHONAN FASILITATOR';
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$status = $model->getWfStatus();

?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="application-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			'fasi.user.fullname',
			[
			'attribute' => 'semester_id' ,
			'value' => function($model){
				return $model->semester->niceFormat();
			}]
			,
            
            
			[
				'attribute' => 'campus.campus_name',
				//'label' => 'Lokas'
			]
            ,
			[
				'attribute' => 'applicationCourses',
				'format' => 'html',
				'value' => function($model){
					$str = '<ol>';
					foreach($model->applicationCourses as $c){
						$course = $c->course;
							$str .= '<li>';
								$str .= $course->course_code . ' - ' . $course->course_name;
								if($c->is_accepted == 1){
									$str .= ' <span class="glyphicon glyphicon-ok"></span> ';
								}
							$str .= '</li>';
						
					}
					$str .='</ol>';
					return $str;
				}
			],
			[
				'attribute' => 'status',
				'format' => 'html',
				'value' => function($model){
					return $model->getWfLabel();
				}
			],
			
			[
				'attribute' => 'submit_at',
				'format' => 'datetime',
				'label' => 'Hantar pada'

			]
            ,
			[
				'attribute' => 'verified_at',
				'format' => 'datetime',
				'visible' => $model->showingVerified(),
			]
			,
			[
				'attribute' => 'approved_at',
				'format' => 'datetime',
				'visible' => $model->showingApproved(),
			],
			[
				'attribute' => 'ref_letter',
				'format' => 'raw',
				'label' => 'Surat Tawaran',
				'visible' => $model->showingRelease(),
				'value' => function($model){
					//return Html::a('Profile', ['user/view', 'id' => $model->id], ['target' => '_blank']);
					return '<a id="yoo" target="_blank" href="'.Url::to(['application/offer-letter', 'id' => $model->id]).'"><span class="glyphicon glyphicon-download-alt"></span> SURAT TAWARAN PERLANTIKAN</a>';
				}
			]
			,
			[
				'attribute' => 'accept_at',
				'format' => 'datetime',
				'label' => 'Terima pada',
				'visible' => $model->showingAccept(),
			]
			,
			
			[
				'attribute' => 'ref_letter',
				'format' => 'raw',
				'label' => 'Slip Penerimaan',
				'visible' => $model->showingAccept(),
				'value' => function($model){
					//return Html::a('Profile', ['user/view', 'id' => $model->id], ['target' => '_blank']);
					return '<a id="yoo" target="_blank" href="'.Url::to(['application/accept-letter', 'id' => $model->id]).'"><span class="glyphicon glyphicon-download-alt"></span> SLIP PENERIMAAN TAWARAN</a> <br /><i>*sila cetak, tandatangan dan hantar slip ini kepada pusat ko-kurikulum.</i>';
				}
			]
			

			
			
			
            
        ],
    ]) ?>
<?php 
if(!($status == 'release' or $status == 'accept')){
$date_result = $model->semester->result_date;
?>
<i>* permohonan yang tidak mendapat surat tawaran selepas dari tarikh <?=date('d M Y', strtotime($date_result))?> dianggap tidak berjaya.</i>
<?php } ?>
</div>


<?php 
if($status == 'release'){
	
$form = ActiveForm::begin();

echo $form->field($model, 'accept_at')->hiddenInput(['value' => time()])->label(false)?>

<div class="row">
<div class="col-md-8"><div class="form-group"><p><b>Saya bersetuju untuk menjadi fasilitator sambilan kursus ko-kurikulum berkredit berdasarkan syarat-syarat yang telah ditetapkan sebagaimana dalam surat tawaran.</b></p></div></div>
</div>


<div class="form-group">


		
	<?=Html::submitButton('Terima Tawaran', ['class' => 'btn btn-success', 'name' => 'wfaction', 'value' => 'btn-accept', 'data' => [
                'confirm' => 'Adakah anda pasti untuk terima?'
            ],
])?>

    </div>
	
<?php 

ActiveForm::end(); 

} 

?>

</div>
</div>