<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\CourseVersion */

$this->title = 'Update Course Version ' . $model->course->course_code .' '. $model->course->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Course Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="course-version-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
