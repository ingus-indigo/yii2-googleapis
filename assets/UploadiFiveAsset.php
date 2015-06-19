<?php

namespace omni\googleApis\assets;

use yii\web\AssetBundle;

class UploadiFiveAsset extends AssetBundle
{
    public $sourcePath = '@vendor/omni/yii2-omni-google-apis/assets';

    public $css = [
        'css/uploadifive.css',
    ];

    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );

    public $js = [
        'js/uploadifive-v1.2.2/jquery.uploadifive.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];

}
