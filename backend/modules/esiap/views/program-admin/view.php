<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Program */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="program-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'pro_name',
            'pro_name_bi',
            'pro_name_short',
            'pro_level',
            'faculty',
            'department',
            'status',
            'pro_cat',
            'pro_field',
            'grad_credit',
            'prof_body',
            'coll_inst',
            'study_mode',
            'sesi_start',
            'pro_sustain:ntext',
            'full_week_long',
            'full_week_short',
            'full_sem_long',
            'full_sem_short',
            'part_week_long',
            'part_week_short',
            'part_sem_long',
            'part_sem_short',
            'full_time_year',
            'full_max_year',
            'part_max_year',
            'part_time_year',
            'synopsis:ntext',
            'synopsis_bi:ntext',
            'objective:ntext',
            'just_stat:ntext',
            'just_industry:ntext',
            'just_employ:ntext',
            'just_tech:ntext',
            'just_others:ntext',
            'nec_perjawatan:ntext',
            'nec_fizikal:ntext',
            'nec_kewangan:ntext',
            'kos_yuran:ntext',
            'kos_beven:ntext',
            'pro_tindih_pub:ntext',
            'pro_tindih_pri:ntext',
            'jumud:ntext',
            'admission_req:ntext',
            'admission_req_bi:ntext',
            'career:ntext',
            'career_bi:ntext',
            'trash',
        ],
    ]) ?>

</div>
