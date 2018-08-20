<?php

namespace frontend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i',
        'fonts/font-awesome/css/font-awesome.css',
        'css/normalize.css',
        'css/fileinput.css',
        'css/bootstrap.min.css',
        'css/bootstrap-switch.css',
        'css/bootstrap-datepicker3.css',
        'https://cdn.linearicons.com/free/1.0.0/icon-font.min.css',
        'css/animate.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css',
        'css/select2-bootstrap.css',
        'css/bootstrap-tagsinput.css',
        'css/bootstrap-datetimepicker.min.css',
        'css/slick.css',
        'css/style2.css',
    ];
    public $js = [
        'js/select2.min.js',
        'js/bootstrap-datepicker.min.js',
        'js/js-fileupload.js',
        'js/wow.min.js',
        'js/slick.min.js',
        'js/jquery.slimscroll.min.js',
        'js/bootstrap-tagsinput.min.js',
        'js/moment.min.js',
        'js/main2.js',
        'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    public function init()
    {
        parent::init();
        // resetting BootstrapAsset to not load own css files
        Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
            'js' => ['js/bootstrap.min.js']
        ];
    }
}