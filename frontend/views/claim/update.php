<?php

use yii\helpers\Html;
use backend\models\ClaimSetting;
use common\models\Common;

/* @var $this yii\web\View */
/* @var $model common\models\Claim */

$this->title = 'BORANG TUNTUTAN BULAN ' . strtoupper($model->monthName()) . ' ' . $model->year;
$this->params['breadcrumbs'][] = ['label' => 'Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$set = ClaimSetting::findOne(1);
$due = $set->claim_due_at;
$status = $model->getWfStatus();
$month = Common::months();
?>

<?php
if($set->block_due == 1){
	$year = $model->year;
	$next = $model->month + 1;
	if($next == 13){
		$next = 1;
		$year++;
	}
	?>
	<div class="form-group"><b><i>* sila hantar tuntutan ini sebelum <?=$due?>hb <?=$month[$next] . ' ' . $year?>.</i></b></div>
	<?php
}

?>




<?= $this->render('_info', [
        'model' => $model,
		'items' => $items,
    ]) ?>


    <?php 
	
	if($status == 'draft' or $status == 'returned'){
		echo $this->render('_form_item', [
			'model' => $model,
			'items' => $items,
			'setting' => $setting
		]);
	}else{
		echo $this->render('_view_item', [
			'model' => $model,
			'items' => $items,
		]);
	}
	
	
	
	?>

