<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\WidgetType $model */

$this->title = 'Update Widget Type: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Widget Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="widget-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
