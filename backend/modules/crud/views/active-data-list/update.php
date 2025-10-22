<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ActiveDataList $model */

$this->title = 'Update Active Data List: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Active Data Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="active-data-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
