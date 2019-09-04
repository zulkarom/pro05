<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Course */

$this->title = $model->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="course-view">


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
            'course_name',
            'course_code',
			[
				'attribute' => 'campus_1',
				'label' => 'Bachok',
				'format' => 'html',
				'value' => function($model){
					if($model->campus_1 == 1){
						return '<span class="label label-success">YES</span>';
					}else{
						return '<span class="label label-danger">NO</span>';
					}
				}
			]
			,
			[
				'attribute' => 'campus_2',
				'label' => 'Kota',
				'format' => 'html',
				'value' => function($model){
					if($model->campus_2 == 1){
						return '<span class="label label-success">YES</span>';
					}else{
						return '<span class="label label-danger">NO</span>';
					}
				}
			],
			[
				'attribute' => 'campus_3',
				'label' => 'Jeli',
				'format' => 'html',
				'value' => function($model){
					if($model->campus_3 == 1){
						return '<span class="label label-success">YES</span>';
					}else{
						return '<span class="label label-danger">NO</span>';
					}
				}
			]
        ],
    ]) ?>

</div>
</div>
</div>