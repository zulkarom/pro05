<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\project\models\Coordinator */

$this->title = 'Tambah Penyelaras';
$this->params['breadcrumbs'][] = ['label' => 'Coordinators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coordinator-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
