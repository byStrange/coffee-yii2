<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Button;
use yii\bootstrap5\Offcanvas;


$this->registerCsrfMetaTags();
$this->registerMetaTag(["charset" => Yii::$app->charset], "charset");
$this->registerMetaTag([
  "name" => "viewport",
  "content" => "width=device-width, initial-scale=1, shrink-to-fit=no",
]);
$this->registerMetaTag([
  "name" => "description",
  "content" => $this->params["meta_description"] ?? "",
]);
$this->registerMetaTag([
  "name" => "keywords",
  "content" => $this->params["meta_keywords"] ?? "",
]);
$this->registerLinkTag([
  "rel" => "icon",
  "type" => "image/x-icon",
  "href" => Yii::getAlias("@web/favicon.ico"),
]);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
  <title><?= Html::encode($this->title) ?></title>
  <?php $this->head(); ?>
</head>

<body class="d-flex flex-column h-100" style="padding-top: 140px">
  <?php $this->beginBody(); ?>

  <header class="hello" id="header">
    <?php
    Offcanvas::begin([
      "placement" => Offcanvas::PLACEMENT_START,
      "backdrop" => true,
      "scrolling" => true,
      "id" => "sidebar-offcanvas",
    ]);
    // Render the vertical navbar with groups
    echo Html::tag('h5', Yii::t('app', 'Widget Settings'));  // Group heading
    echo Nav::widget([
      "options" => ["class" => "nav flex-column nav-pills"],
      "items" => [
        ["label" => Yii::t('app', 'Widget Types'), "url" => ["widget-type/index"]],
      ]
    ]);

    ?>
    <!-- Dropdown Section: Layout -->
    <h5>
      <a data-bs-toggle="collapse" href="#layoutItems" role="button" aria-expanded="false" aria-controls="layoutItems">
        <?= Yii::t('app', 'Layout') ?>
      </a>
    </h5>
    <div class="collapse" id="layoutItems">
      <?= Nav::widget([
        'options' => ['class' => 'nav flex-column nav-pills mb-4'],
        'items' => [
          ['label' => Yii::t('app', 'Section'), 'url' => ['section/index']],
          ['label' => Yii::t('app', 'SectionGroup'), 'url' => ['section-group/index']],
        ],
      ]) ?>
    </div>

    <h5>
      <a data-bs-toggle="collapse" href="#widgetItems" role="button" aria-expanded="false" aria-controls="widgetItems">
        <?= Yii::t('app', 'Widgets') ?>
      </a>
    </h5>
    <div class="collapse" id="widgetItems">
      <?= Nav::widget([
        "options" => ["class" => "nav flex-column nav-pills"],
        "items" => [
          ["label" => Yii::t('app', 'Button'), "url" => ["button/index"]],
          ["label" => Yii::t('app', 'Text'), "url" => ["text/index"]],
          ["label" => Yii::t('app', 'Input'), "url" => ["input/index"]],
          ["label" => Yii::t('app', 'Container'), "url" => ["container/index"]],
          ["label" => Yii::t('app', 'Icon'), "url" => ["icon/index"]],
          ["label" => Yii::t('app', 'Image'), "url" => ["image/index"]],
          ["label" => Yii::t('app', 'Link'), "url" => ["link/index"]],
          ["label" => Yii::t('app', 'View'), "url" => ["view/index"]],
          ["label" => Yii::t('app', 'ComponentWidget'), "url" => ["component-widget/index"]],
          ["label" => Yii::t('app', 'ActiveDataList'), "url" => ["active-data-list/index"]],
        ]
      ]);
      ?>
    </div>

    <h5>
      <a data-bs-toggle="collapse" href="#widgetSourceItems" role="button" aria-expanded="false" aria-controls="widgetSourceItems">
        <?= Yii::t('app', 'Widget sources') ?>
      </a>
    </h5>
    <div class="collapse" id="widgetSourceItems">
      <?= Nav::widget([
        "options" => ["class" => "nav flex-column nav-pills"],
        "items" => [
          ["label" => Yii::t('app', 'Component'), "url" => ["component/index"]],
          ["label" => Yii::t('app', 'IconSource'), "url" => ["icon-source/index"]],
          ["label" => Yii::t('app', 'TextSource'), "url" => ["text-source/index"]],
          ["label" => Yii::t('app', 'TextTranslation'), "url" => ["text-translation/index"]],
          ["label" => Yii::t('app', 'DataProvider'), "url" => ["data-provider/index"]],
        ]
      ]);

      ?>
    </div>

    <h5>
      <a data-bs-toggle="collapse" href="#datasetItems" role="button" aria-expanded="false" aria-controls="datasetItems">
        <?= Yii::t('app', 'Datasets') ?>
      </a>
    </h5>
    <div class="collapse" id="datasetItems">
      <?= Nav::widget([
        "options" => ["class" => "nav flex-column nav-pills"],
        "items" => [
          ["label" => Yii::t('app', 'Coffee'), "url" => ["coffee/index"]],
          ["label" => Yii::t('app', 'Coffee Category'), "url" => ["coffee-category/index"]],
        ]
      ]);
      ?>
    </div>
    <!-- Dropdown Section: Layout -->
    <?php
    Offcanvas::end();
    ?>
  </header>

  <main id="main" class="flex-shrink-0" role="main">
    <div class="container">
      <div class="d-flex gap-2 justify-center align-items-baseline">
        <?php echo Button::widget([
          "label" =>
          '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24" height="24"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM64 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L96 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"/></svg>',
          "encodeLabel" => false,
          "options" => [
            "class" => "btn  p-1 btn-light navbar-toggler",
            "type" => "button",
            "data-bs-toggle" => "offcanvas",
            "data-bs-target" => "#sidebar-offcanvas", // Use the same ID from Offcanvas
          ],
        ]); ?>
        <?php if (!empty($this->params['breadcrumbs'])) : ?>
          <?= Breadcrumbs::widget([
            "links" => $this->params["breadcrumbs"],
            "homeLink" => ["url" => "/admin", "label" => Yii::t('app', 'Admin')],
          ]) ?>
        <?php endif ?>

        <div>
          <?= Html::beginForm(['/site/language'], 'post') ?>
          <?= Html::dropDownList('language', Yii::$app->language, ['en-US' => 'English', 'ru-RU' => 'Russian', 'uz-UZ' => 'Uzbek']) ?>
          <?= Html::submitButton(Yii::t('app', 'Change')) ?>
          <?= Html::endForm() ?>
        </div>

      </div>
      <?= $content ?>

    </div>
  </main>

  <?php $this->endBody(); ?>
</body>

</html>
<?php $this->endPage(); ?>
