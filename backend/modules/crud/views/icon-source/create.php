<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\IconSource $model */

$this->title = 'Create Icon Source';
$this->params['breadcrumbs'][] = ['label' => 'Icon Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="icon-source-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
