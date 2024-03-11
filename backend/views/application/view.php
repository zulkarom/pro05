<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\models\Todo;

/* @var $this yii\web\View */
/* @var $model common\models\Application */

$this->title = 'PERMOHONAN FASILITATOR';//$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$status = $model->getWfStatus();

echo $this->render('_view_profile', [
			'model' => $model->fasi,
	]);

?>
<div class="box">
<div class="box-header"><i class="fa fa-asterisk"></i>
<h3 class="box-title">MAKLUMAT PERMOHONAN</h3><span class="pull-right"><a href="<?=Url::to(['application/edit', 'id' => $model->id])?>" class="btn btn-default btn-sm"><span class="fa fa-edit"></span> Edit</a></span>
</div>
<div class="box-body"><div class="application-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
			'fasi.user.fullname',
			[
                'label' =>'Jenis',
                'value' => function($model){
                    return $model->fasiType->type_name;
                }
            ],
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
				'attribute' => 'groupName',
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
						if($course){
							$str .= '<li>';
								$str .= $course->course_code . ' - ' . $course->course_name;
								if($c->is_accepted == 1){
									$str .= ' <span class="glyphicon glyphicon-ok"></span> ';
								}
							$str .= '</li>';
						}
							
						
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
					return '<a id="yoo" target="_blank" href="'.Url::to(['application/accept-letter', 'id' => $model->id]).'"><span class="glyphicon glyphicon-download-alt"></span> SLIP PENERIMAAN TAWARAN</a>';
				}
			]
        ],
    ]) ?>

</div>
</div>
</div>

<?php 

if($status == 'submit' && Todo::can('verify-application')){
	echo $this->render('_form_verify', [
			'model' => $model,
	]);
}

if($status == 'verified' or $status == 'approved'){
	echo $this->render('_view_verify', [
			'model' => $model,
	]);
}


if($status == 'verified' && Todo::can('approve-application')){
	echo $this->render('_form_approve', [
			'model' => $model,
	]);
}

if($status == 'approved'){
	echo $this->render('_view_approve', [
        'model' => $model,
]);
}

?>