<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'css/pm.css',
        'css/site.css',
    	'css/datatables.bootstrap.css',
    	'css/fullcalendar.min.css',
    	'css/jquery.datetimepicker.css',
    ];
    public $js = [
    	'js/jquery-3.1.1.js',
    	'js/datatables.js',
    	'js/table-datatables-responsive.js',
    	'js/moment.min.js',
    	'js/fullcalendar.min.js',
    	'js/jquery-ui.min.js',
    	'js/locale/th.js',
    	'js/jquery.datetimepicker.full.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
