<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\IconSource $model */

$this->title = 'Update Icon Source: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Icon Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="icon-source-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
