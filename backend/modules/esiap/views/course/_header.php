<div class="row">
<div class="col-md-12"><div ><div style="font-size:14px;font-weight:bold"><?=$course->course_code . ' ' . $course->course_name ?></div>
<div style="font-size:14px">VERSION: <?=$course->developmentVersion->version_name?></div>

<?php 
$per = $course->developmentVersion->progress;

?>
<div style="margin-bottom:10px;font-size:14px">PROGRESS: <?=$course->developmentVersion->progress?>%</div>

<div class="progress progress-sm active">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?=$per?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$per?>%">
          
                </div>
              </div>

</div></div>

<div class="col-md-4">
<!-- <select type="text" class="form-control" placeholder="VIEW OTHER VERSION"></select> -->
</div>

</div>