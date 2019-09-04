<?php
use backend\models\Semester;
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'Dashboard';
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
              <h3>PROFILE</h3>

              <p><a style="color:#FFFFFF" href="<?=Url::to(['profile/preview'])?>">View My Profile</a></p>
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
              <h3>APPLY</h3>

              <p>Submit an Application</p>
            </div>
            <div class="icon">
              <i class="fa fa-mouse-pointer"></i>
            </div>
            <a href="#" class="small-box-footer">
              More <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>CLAIM</h3>

              <p><a style="color:#FFFFFF" href="<?=Url::to(['claim/create'])?>">Make a Claim</a></p>
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
              <h3>PROJECT</h3>

              <p>Manage Last Year Project</p>
            </div>
            <div class="icon">
              <i class="fa fa-truck"></i>
            </div>
            <a href="#" class="small-box-footer">
              More <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
      </div>
	  
  
	  
        

    </div>
	
		  

</div>
<br />


