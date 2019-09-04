<?php
namespace frontend\models;

class LoginAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/views/myasset';
    public $css = [
        'css/admin-forms.css',
		'css/theme.css'
    ];

    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
