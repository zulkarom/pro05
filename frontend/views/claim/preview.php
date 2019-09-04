<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use common\models\Hour;
use common\models\Common;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model common\models\Claim */

$this->title = 'Sila sahkah butiran tuntutan di bawah.';
$this->params['breadcrumbs'][] = ['label' => 'Claims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="claim-create">

<?= $this->render('_info', [
		'model' => $model
    ]);
?>
<div class="claim-update">

    <?= $this->render('_view_item', [
        'model' => $model,
		'items' => $items,
    ]) ?>

</div>

<?php
$form = ActiveForm::begin(); ?>

<?=$form->field($model, 'submit_at')->hiddenInput(['value' => time()])->label(false)?>




</div>


<div class="form-group">
		<?= Html::a('Kembali', ['claim/update', 'id' => $model->id], ['class' => 'btn btn-default']) ?> 
		<?= Html::submitButton('Sah dan Hantar Tuntutan', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
