<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DataProvider $model */

$this->title = 'Create Data Provider';
$this->params['breadcrumbs'][] = ['label' => 'Data Providers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-provider-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
