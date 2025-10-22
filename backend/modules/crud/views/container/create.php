<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Container $model */

$this->title = 'Create Container';
$this->params['breadcrumbs'][] = ['label' => 'Containers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
