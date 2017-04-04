<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    //引入样式文件
    public $css = [
        'statics/css/site.css',
        //使用图标
        'statics/css/font-awesome-4.4.0/css/font-awesome.min.css',

    ];
    public $js = [
        //进入js文件
        'statics/js/site.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
