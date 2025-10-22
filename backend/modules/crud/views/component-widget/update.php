<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ComponentWidget $model */

$this->title = 'Update Component Widget: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Component Widgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="component-widget-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
