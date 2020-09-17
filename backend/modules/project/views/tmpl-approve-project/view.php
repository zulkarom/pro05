<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TmplOfferFasi */

$this->title = $model->id . '.' . $model->template_name;
$this->params['breadcrumbs'][] = ['label' => 'Tmpl Approve Letter', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tmpl-offer-fasi-view">

    <p>
	<?= Html::a('List', ['index'], ['class' => 'btn btn-success']) ?> 
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'template_name',
            'pengarah',
            'yg_benar',
            'tema:ntext',
            'per3:ntext',
            'per4:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?></div>
</div>


</div>
