<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class KnobAsset extends AssetBundle
{
    public $sourcePath = '@backend/assets/knob';
    
    public $js = [
        'jquery.knob.js',
    ];
	
	public $depends = [
        'backend\assets\AppAsset',
    ];
  
}
