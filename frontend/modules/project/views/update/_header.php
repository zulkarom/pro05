
<div class="row">
<div class="col-md-4"><div class="form-group">
<b><?=strtoupper($model->fasiCoorPost)?></b> : <?=$model->fasi->user->fullname?>
</div></div>

<div class="col-md-5">
<div class="form-group">

<b>KURSUS</b> : <?=$model->course->course_code .' '. strtoupper($model->course->course_name) . ' ('.$model->group->group_name.')'?>

</div>
</div>

<div class="col-md-3">
<div class="form-group">
<b>SEMESTER</b> : <?=$model->semester->niceFormat()?>
<div><b>STATUS</b> : <?=$model->statusName ?></div>
</div>
</div>

</div>	  