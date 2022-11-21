<?php 
use yii\helpers\Html;
$directoryAsset = Yii::getAlias('@web');

$btn_kursus = Html::a('Lihat Senarai Kursus', ['site/course'], ['class' => 'btn btn-secondary px-4 py-3 mt-3']);

?>
<section class="home-slider owl-carousel">
      <div class="slider-item" style="background-image:url(<?=$directoryAsset?>/images/1.jpg);">
      	<div class="overlay"></div>
        <div class="container">
          <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-8 text-center ftco-animate fadeInUp ftco-animated">
            <h1 class="mb-4">Kita<span>#BinaLegasiUMK Bersama</span></h1>
            <p><?=$btn_kursus?></p>
          </div>
        </div>
        </div>
      </div>

      <div class="slider-item" style="background-image:url(<?=$directoryAsset?>/images/2.jpg);">
      	<div class="overlay"></div>
        <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-8 text-center ftco-animate fadeInUp ftco-animated">
            <h1 class="mb-4">#WeAreUMKFamily<span></span></h1>
            <p><?=$btn_kursus?></p>
          </div>
        </div>
        </div>
      </div>
	  <div class="slider-item" style="background-image:url(<?=$directoryAsset?>/images/3.jpg);">
      	<div class="overlay"></div>
        <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-8 text-center ftco-animate fadeInUp ftco-animated">
            <h1 class="mb-4">#OneUMKOneDream<span></span></h1>
            <p><?=$btn_kursus?></p>
          </div>
        </div>
        </div>
      </div>
    </section>