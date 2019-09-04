<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Assignment */
/* @var $usernameField string */
/* @var $extraColumns string[] */

$this->title = 'Admin Assignment';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    ['class' => 'yii\grid\SerialColumn'],
	'username',
    'fullname',
	'email'
];
if (!empty($extraColumns)) {
    $columns = array_merge($columns, $extraColumns);
}
$columns[] = [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{view}',
	'buttons'=>[
					'view'=>function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update Role Assignment',$url, ['class'=>'btn btn-primary btn-sm']);
						
						
					
					}
				],

];
?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="assignment-index">

    <?php Pjax::begin(); ?>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]);
    ?>
    <?php Pjax::end(); ?>

</div></div>
</div>
