<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font-awesome.min.css',
        'administrator/css/sb-admin.css',
        //'administrator/css/plugins/DataTables/datatables.min.css',
        'administrator/css/site.css',
    ];
    public $js = [
        'administrator/js/bootstrap.min.js',
        //'administrator/js/plugins/DataTables/datatables.min.js',
        'administrator/js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}