<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\CourseVersion */

$this->title = 'Update Course Version ' . $model->course->course_code .' '. $model->course->course_name;

$course = $model->course;


$this->title = 'Course Versions: ' . $course->course_code .' '. $course->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Course List', 'url' => ['/esiap/course-admin/index']];
$this->params['breadcrumbs'][] = ['label' => 'Update', 'url' => ['/esiap/course-admin/update', 'course' => $course->id]];
$this->params['breadcrumbs'][] = ['label' => 'Version List', 'url' => ['/esiap/course-admin/course-version', 'course' => $course->id]];
$this->params['breadcrumbs'][] = 'Update';


?>



<div class="course-version-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
