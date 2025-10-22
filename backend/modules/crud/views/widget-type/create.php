<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\WidgetType $model */

$this->title = 'Create Widget Type';
$this->params['breadcrumbs'][] = ['label' => 'Widget Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
