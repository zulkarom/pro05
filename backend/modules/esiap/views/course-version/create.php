<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\CourseVersion */

$this->title = 'Create Course Version';
$this->params['breadcrumbs'][] = ['label' => 'Course Versions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-version-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
