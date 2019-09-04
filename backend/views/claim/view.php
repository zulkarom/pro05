<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Todo;

/* @var $this yii\web\View */
/* @var $model common\models\Claim */

$this->title = 'MAKLUMAT TUNTUTAN';
$this->params['breadcrumbs'][] = ['label' => 'Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$status = $model->getWfStatus();
?>
<?= $this->render('_info', [
        'model' => $model,
		'items' => $items,
    ]) ?>
<?= $this->render('_view_item', [
        'model' => $model,
		'items' => $items,
    ]) ?>
	
<?php 

if($status == 'submit' && Todo::can('return-claim')){
	echo $this->render('_form_return', [
			'model' => $model,
	]);
}

