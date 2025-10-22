<?php

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';

  public $css = [
    'https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css',
    'css/admin.css',
    'css/vue.css',
    'css/tailwind.css'
  ];

  public $js = [
    'js/main.js',
    'js/App.js',
    'js/utils.js',
    'js/components/WidgetTree.js',
    'js/components/widgets/TextWidget.js',
    'js/components/widgets/ViewWidget.js',
  ];

  public $depends = [
    'yii\bootstrap5\BootstrapAsset'
  ];

  public $jsOptions = [
    'type' => 'module'
  ];
  public function init()
  {
    parent::init();
    $this->css[] = Yii::$app->params['frontendUrl']  . '/css/styles.css';
    $this->js[] = Yii::$app->params['frontendUrl']  . '/js/mixitup.min.js';
    $this->js[] = Yii::$app->params['frontendUrl'] . '/js/main.js';
  }
}
