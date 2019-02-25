<?php

namespace diazoxide\SliderRevolution\Module\assets;

use yii\web\AssetBundle;

class SliderRevolutionAsset extends AssetBundle
{
    public $sourcePath = '@vendor/diazoxide/yii2-revslider/assets/rv-slider';
    public $js = [
        'js/jquery.themepunch.revolution.min.js',
        "js/jquery.themepunch.tools.min.js",
        "js/jquery.themepunch.revolution.min.js",
        "js/extensions/revolution.extension.actions.min.js",
        "js/extensions/revolution.extension.carousel.min.js",
        "js/extensions/revolution.extension.kenburn.min.js",
        "js/extensions/revolution.extension.layeranimation.min.js",
        "js/extensions/revolution.extension.migration.min.js",
        "js/extensions/revolution.extension.navigation.min.js",
        "js/extensions/revolution.extension.parallax.min.js",
        "js/extensions/revolution.extension.slideanims.min.js",
        "js/extensions/revolution.extension.video.min.js",
    ];
    public $css = [
        'css/settings.css',
        'fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css',
        'fonts/font-awesome/css/font-awesome.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}