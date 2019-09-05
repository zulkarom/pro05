<?php 
$application = $model->application;
$semester =$application->semester;
$course = $application->acceptedCourse->course;
?>

<div class="row">
<div class="col-md-4"><div class="form-group">
<b>FASILILATOR</b> : <?=$model->application->fasi->user->fullname?>
</div></div>

<div class="col-md-5">
<div class="form-group">

<b>KURSUS</b> : <?=$course->course_code .' '. strtoupper($course->course_name) . ' ('.$application->applicationGroup->group_name.')'?>

</div>
</div>

<div class="col-md-3">
<div class="form-group">
<b>SEMESTER</b> : <?=$semester->niceFormat()?>

</div>
</div>

</div>	  