<?php

/** @var \yii\web\View $this */
/** @var string $content */

use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!--=============== DESCRIPTION ===============-->
  <meta name="description" content="by Omonjon Sobirov">

  <!--=============== FAVICON ===============-->
  <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">

  <?php $this->head() ?>

  <title>Coffee</title>
</head>

<body class="d-flex flex-column h-100">
  <?php $this->beginBody() ?>


  <?= $content ?>


  <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
