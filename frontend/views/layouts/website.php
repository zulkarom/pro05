<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
frontend\assets\WebAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/webasset');
?>
<?php $this->beginPage() ?>
    
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
  <head>
  <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
		
    <title>PUSAT KOKURIKULUM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fredericka+the+Great" rel="stylesheet">
	
	<?php $this->head() ?>
	

   
  </head>
   
  <body>
<?php $this->beginBody() ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco_navbar ftco-navbar-light" id="ftco-navbar">
	    <div class="container d-flex align-items-center">
		<span id="logo-umk"><img src="<?=$directoryAsset?>/images/header-bi.jpg" /> </span>
	    	<a class="navbar-brand" href="index.html"></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="oi oi-menu"></span> Menu
			  </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	        	<li class="nav-item"><a href="<?=Url::to(['/site/index'])?>" class="nav-link pl-0">Home</a></li>
	        	<li class="nav-item"><a href="<?=Url::to(['/site/course'])?>" class="nav-link">Senarai Kursus</a></li>
	        	<li class="nav-item"><a href="<?=Url::to(['/user/login'])?>" class="nav-link">e-Fasi</a></li>
				<li class="nav-item"><a href="<?=Url::to(['/project'])?>" class="nav-link">Kertas Kerja</a></li>
				<li class="nav-item"><a href="#hubungi" class="nav-link">Hubungi</a></li>

	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->
    
    <?=$content?>

    
		
		
		
		

		
		


		
    <footer id="hubungi" class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-6 col-lg-3">
            <div class="ftco-footer-widget mb-5">
            	<h2 class="ftco-heading-2">Hubungi Kami</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">Kampus Kota, Karung Berkunci 36, Pengkalan Chepa, 16100 Kota Bharu, Kelantan, Malaysia</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">609 7717000</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">pusatko@umk.edu.my</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
      
          <div class="col-md-6 col-lg-3">
            <div class="ftco-footer-widget mb-5 ml-md-4">
              <h2 class="ftco-heading-2">Links</h2>
              <ul class="list-unstyled">
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>UTAMA</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>SENARAI KURSUS</a></li>
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>LOGIN E-FASI</a></li>
            
                <li><a href="#"><span class="ion-ios-arrow-round-forward mr-2"></span>HUBUNGI</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 col-lg-3">

            <div class="ftco-footer-widget mb-5">
            	<h2 class="ftco-heading-2 mb-0">Connect With Us</h2>
            	<ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-3">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Made By <a href="http://skyhint.com" target="_blank">Skyhint Design</a> | Template by <a href="https://colorlib.com" target="_blank">Colorlib</a>
  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
    </footer>
    
  

    <?php $this->endBody() ?>
  </body>
</html>

<?php $this->endPage() ?>