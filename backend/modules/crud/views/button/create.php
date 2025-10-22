<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Button $model */

$this->title = 'Create Button';
$this->params['breadcrumbs'][] = ['label' => 'Buttons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="button-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
