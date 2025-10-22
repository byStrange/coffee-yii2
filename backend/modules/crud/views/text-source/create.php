<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\TextSource $model */

$this->title = 'Create Text Source';
$this->params['breadcrumbs'][] = ['label' => 'Text Sources', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="text-source-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
