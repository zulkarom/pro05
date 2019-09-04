<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ClaimSetting */

$this->title = 'Claim Setting';
$this->params['breadcrumbs'][] = ['label' => 'Claim Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="claim-setting-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div></div>
</div>
