<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DataProvider $model */

$this->title = 'Update Data Provider: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Data Providers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="data-provider-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
