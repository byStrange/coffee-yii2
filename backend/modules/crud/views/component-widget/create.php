<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\ComponentWidget $model */

$this->title = 'Create Component Widget';
$this->params['breadcrumbs'][] = ['label' => 'Component Widgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="component-widget-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
