<?php
use backend\models\Semester;
use yii\helpers\Url;
use common\models\Common;
/* @var $this yii\web\View */

$this->title = 'DASHBOARD';
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
<div class="site-index">

    <div class="body-content">

	
	<?php 
$m = null;

if($sem = Semester::getOpenDateSemester()){
	$m = "Tempoh pendaftaran bagi semester " . $sem->niceFormat() . " adalah dari " . date('d M Y', strtotime($sem->open_at)) . " hingga " . date('d M Y', strtotime($sem->close_at)) . ".";
	echo '<p><div class="alert alert-info"><span class="fa fa-info-circle"></span>  '.$m.'</div></p>';
}

?>
	
	
	<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 style="font-size:30px;">PROFIL</h3>

              <p><a style="color:#FFFFFF" href="<?=Url::to(['profile/preview'])?>">Kemaskini Maklumat Diri</a></p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="<?=Url::to(['profile/preview'])?>" class="small-box-footer">
              More  <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 style="font-size:30px;">MOHON</h3>

              <p><a style="color:#FFFFFF" href="<?=Url::to(['application/create'])?>">Permohonan Fasilitator</a></p>
            </div>
            <div class="icon">
              <i class="fa fa-mouse-pointer"></i>
            </div>
            <a href="<?=Url::to(['application/create'])?>" class="small-box-footer">
              More <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 style="font-size:30px;">TUNTUTAN</h3>

              <p><a style="color:#FFFFFF" href="<?=Url::to(['claim/create'])?>">Buat Tuntutan</a></p>
            </div>
            <div class="icon">
              <i class="fa fa-usd"></i>
            </div>
            <a href="<?=Url::to(['claim/create'])?>" class="small-box-footer">
              More <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 style="font-size:30px;">KERTAS KERJA</h3>

              <p>Kemaskini Kertas Kerja</p>
            </div>
            <div class="icon">
              <i class="fa fa-files-o"></i>
            </div>
            <a href="<?=Url::to(['project/fasi/index'])?>" class="small-box-footer">
              More <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
      </div>
<?php if($application){
	$course = $application->acceptedCourse->course;
	?>  
	  <h3>SEMESTER <?=strtoupper($semester->niceFormat())?></h3>
	  
  
	  <div class="row">
<div class="col-md-4">

<div class="box">
<div class="box-header">
	<div class="box-title">KURSUS</div>
</div>
<div class="box-body">


<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tbody>
      <tr>
        <td><?='<b>'.$course->course_code .'</b> '. strtoupper($course->course_name) . ' ('.$application->applicationGroup->group_name.')'?></td>
      </tr>
      <tr>
        <td><a target="_blank" href="<?=Url::to(['application/offer-letter', 'id' => $application->id])?>"><span class="glyphicon glyphicon-download-alt"></span> SURAT TAWARAN PERLANTIKAN</a></td>

      </tr>
      <tr>
        <td><a href="<?=Url::to(['/esiap/course/fk1', 'course' => $course->id])?>" target="_blank" class="btn btn-default" >FK1</a> <a href="<?=Url::to(['/esiap/course/fk2', 'course' => $course->id])?>" target="_blank" class="btn btn-default" >FK2</a> <a href="<?=Url::to(['/esiap/course/fk3', 'course' => $course->id])?>" target="_blank" class="btn btn-default" >FK3</a></td>

      </tr>
    </tbody>
  </table>
</div>

</div>
</div>


</div>

<div class="col-md-4">
<div class="box">
<div class="box-header">
	<div class="box-title">TUNTUTAN</div>
</div>
<div class="box-body">

<?php 

$claims = $application->submittedClaims;

?>
<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Bulan</th>
        <th>Jumlah</th>
      </tr>
    </thead>
    <tbody>
	<?php 
	
	if($claims){
		$sum = 0;
		foreach($claims as $claim){
			$sub = $claim->total_hour * $claim->rate_amount;
			$sum +=$sub;
			echo ' <tr>
        <td><a href="'.Url::to(['claim/view', 'id' => $claim->id]).'">'.strtoupper(Common::months()[$claim->month]) .'</a></td>
        <td>RM'.number_format($sub,2).'</td>

      </tr>';
		}
		
	}
	
	?>
     <tr>
        <td><b>JUMLAH</b></td>
        <td><b>RM<?=number_format($sum,2)?></b></td>

      </tr>
      
    </tbody>
  </table>
</div>


</div>
</div>
</div>

<div class="col-md-4">
<div class="box">
<div class="box-header">
	<div class="box-title">KERTAS KERJA</div>
</div>
<div class="box-body">
<div class="table-responsive">
  <table class="table table-striped table-hover">

    <tbody>
      <tr>
        <td>KATA KUNCI: DHE323</td>
      </tr>
      <tr>
        <td>STATUS : DERAF</td>
      </tr>
      <tr>
        <td><a href="" class="btn btn-default btn-sm">Kemaskini</a> <a href="" class="btn btn-default btn-sm">Tukar Kata Kunci</a></td>
      </tr>
    </tbody>
  </table>
</div>


</div>
</div>
</div>

</div>
        
<?php } ?>
    </div>
	
		  

</div>
<br />


