<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AdminLteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/adminlte.min.css',
        '/css/site.css',
    ];
    public $js = [
        //'js/adminlte.min.js',
        '/js/Chart.min.js',
        '/js/custom.js',
        '//www.amcharts.com/lib/4/core.js',
        'https://cdn.amcharts.com/lib/4/charts.js',
        '//www.amcharts.com/lib/4/themes/animated.js',
        '//www.amcharts.com/lib/4/lang/ru_RU.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
