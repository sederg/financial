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
    public $css = [
        'css/site.css',
        'css/sisga.css',
        'plugins/font-awesome/css/font-awesome.min.css',
        'css/font-awesome.min.css',
        //'css/financial.css',
        'css/adminlte.css',
       // 'css/adminlte.min.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        //  'yidas\yii\fontawesome\FontawesomeAsset'
   
    ];
}
