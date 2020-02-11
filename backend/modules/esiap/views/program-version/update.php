<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\CourseVersion */

$this->title = 'Update Program Version ' . $model->program->pro_name;

$program = $model->program;


$this->title = 'Program Versions: ' . $program->pro_name;
$this->params['breadcrumbs'][] = ['label' => 'Course List', 'url' => ['/esiap/course-admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Update', 'url' => ['/esiap/course-admin/update', 'program' => $program->id]];
$this->params['breadcrumbs'][] = ['label' => 'Version List', 'url' => ['/esiap/program-admin/program-version', 'program' => $program->id]];
$this->params['breadcrumbs'][] = 'Update';


?>



<div class="course-version-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
