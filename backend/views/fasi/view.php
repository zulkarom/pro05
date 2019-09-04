<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Fasi */

$this->title = $model->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Fasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="fasi-view">

<p>
    <?= Html::a('Back', ['index'], ['class' => 'btn btn-warning']) ?> 
	<?= Html::a('<span class="glyphicon glyphicon-lock"></span> Update Login Info', ['/user/update', 'id' => $model->user_id], ['class' => 'btn btn-primary']) ?>
</p>

	
	<style>
table.detail-view th {
    width:25%;
}
</style>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
			'user.fullname',
			'nric',
			'user.email',
            'gender',
            'address_postal',
            'address_home',
            'birth_date',
            'birth_place',
            'citizen',
            'marital_status',
            'handphone',
            'distance_umk',
            'position_work',
            'position_grade',
            'department',
            'salary_grade',
            'salary_basic',
            'address_office',
            'office_phone',
            'office_fax',
            'in_study',
            'umk_staff',
            'staff_no',
            
        ],
    ]) ?>

</div></div>
</div>
