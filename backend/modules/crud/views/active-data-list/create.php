<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ActiveDataList $model */

$this->title = 'Create Active Data List';
$this->params['breadcrumbs'][] = ['label' => 'Active Data Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="active-data-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
