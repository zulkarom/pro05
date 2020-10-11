<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model common\models\Application */

$this->title = 'Kemaskini Permohonan';
$this->params['breadcrumbs'][] = ['label' => 'Applications', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>


<div class="box">
<div class="box-body"><?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
			'fasi.user.fullname',
			[
			'attribute' => 'semester_id' ,
			'value' => function($model){
				return $model->semester->niceFormat();
			}]
	
			
			
			
        ],
    ]) ?></div>
</div>

	
	
	
<div class="application-update">


   <div class="box box-primary">
<div class="box-header"></div>
<div class="box-body"> <?= $this->render('_form', [
        'model' => $model,
		'courses' => $courses,
    ]) ?></div>
</div>


</div>
