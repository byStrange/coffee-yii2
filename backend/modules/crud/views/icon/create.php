<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Icon $model */

$this->title = 'Create Icon';
$this->params['breadcrumbs'][] = ['label' => 'Icons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="icon-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
