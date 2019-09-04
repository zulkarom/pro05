<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class WebAsset extends AssetBundle
{
    public $sourcePath = '@frontend/views/webasset';
	
    public $css = [
        'css/open-iconic-bootstrap.min.css',
		'css/animate.css',
		'css/open-iconic-bootstrap.min.css',
		'css/animate.css',
		'css/owl.carousel.min.css',
		'css/owl.theme.default.min.css',
		'css/magnific-popup.css',
		'css/aos.css',
		'css/ionicons.min.css',
		'css/flaticon.css',
		'css/icomoon.css',
		'css/style.css'
    ];
	
    public $js = [
		//'js/jquery.min.js',
		'js/jquery-migrate-3.0.1.min.js',
		'js/popper.min.js',
		'js/bootstrap.min.js',
		'js/jquery.easing.1.3.js',
		'js/jquery.waypoints.min.js',
		'js/jquery.stellar.min.js',
		'js/owl.carousel.min.js',
		'js/jquery.magnific-popup.min.js',
		'js/aos.js',
		'js/scrollax.min.js',
		'js/main.js'
    ];
	
	
    public $depends = [
      'yii\web\YiiAsset',
	  //'yii\bootstrap\BootstrapPluginAsset',
      // 'yii\bootstrap\BootstrapAsset',
    ];
}
