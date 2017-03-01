<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/slider.css',
    ];
    public $js = [
        //'js/jquery.js',
        'js/jquery-migrate-1.1.1.js',
        'js/superfish.js',
        'js/sForm.js',
        'js/jquery.equalheights.js',
        'js/jquery.easing.1.3.js',
        'js/tms-0.4.1.js',
        'js/jquery.carouFredSel-6.1.0-packed.js',
        'js/jquery.touchSwipe.min.js',
        'js/slider.js',
        'js/carousel1.js',
    ];
    public $cssOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD,
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
