<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\TextSource $model */

$this->title = 'Update Text Source: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Text Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="text-source-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
