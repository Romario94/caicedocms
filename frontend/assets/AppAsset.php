<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
//    public $basePath = '@webroot';
//    public $baseUrl = '@web';
    public $sourcePath = '@bower/plantilla/';
    public $css = [
       // 'css/site.css',
        'css/bootstrap.css',
        'css/style.css',
        'css/linecons.css',
        'css/font-awesome.css',
        'css/responsive.css',
        'css/animate.css',
        'http://fonts.googleapis.com/css?family=Lato:400,900,700,700italic,400italic,300italic,300,100italic,100,900italic',
        'http://fonts.googleapis.com/css?family=Dosis:400,500,700,800,600,300,200',
    ];
    public $js = [
        'js/jquery.1.8.3.min.js',
        'js/bootstrap.js',
        'js/jquery-scrolltofixed.js',
        'js/jquery.easing.1.3.js',
        'js/jquery.isotope.js',
        'js/wow.js',
        'js/classie.js',
        'js/main.js',
        'js/main1.js',
        'js/main2.js',
        'js/main3.js',
        'js/main4.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
