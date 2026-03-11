<?php 
use yii\helpers\Html;
use common\models\Slider;

$directoryAsset = Yii::getAlias('@web');

$sliders = Slider::find()
    ->where(['is_active' => 1])
    ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
    ->all();

?>
<section class="home-slider owl-carousel">
      
<?php foreach ($sliders as $slider) : ?>
<?php
    $headingParts = [];
    if ($slider->heading_line1) { $headingParts[] = Html::encode($slider->heading_line1); }
    if ($slider->heading_line2) { $headingParts[] = Html::encode($slider->heading_line2); }
    if ($slider->heading_line3) { $headingParts[] = Html::encode($slider->heading_line3); }
    $headingHtml = implode('<br>', $headingParts);

    $btnHtml = '';
    if ((int)$slider->button_type === Slider::BUTTON_COURSE) {
        $btnHtml = Html::a('Lihat Senarai Kursus', ['site/course'], ['class' => 'btn btn-secondary px-4 py-3 mt-3']);
    } elseif ((int)$slider->button_type === Slider::BUTTON_LOGIN) {
        $btnHtml = Html::a('Sistem e-Fasi', ['user/login'], ['class' => 'btn btn-secondary px-4 py-3 mt-3']);
    }
?>
      <div class="slider-item" style="background-image:url(<?= $directoryAsset ?><?= Html::encode($slider->image_path) ?>);">
	  	<div class="overlay"></div>
        <div class="container">
          <div class="row no-gutters slider-text align-items-center justify-content-center" data-scrollax-parent="true">
          <div class="col-md-8 text-center ftco-animate fadeInUp ftco-animated">
            <h1 class="mb-4"><?php echo $headingHtml; ?></h1>
            <p><?= $btnHtml ?></p>
          </div>
        </div>
        </div>
      </div>

<?php endforeach; ?>
    </section>