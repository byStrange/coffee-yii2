<?php
return [
  'aliases' => [
    '@bower' => '@vendor/bower-asset',
    '@npm'   => '@vendor/npm-asset',
  ],
  'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
  'components' => [
    'cache' => [
      'class' => \yii\caching\FileCache::class,
    ],
    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false, // hides index.php in URLs
      'enableStrictParsing' => false,
    ],
  ],
];
