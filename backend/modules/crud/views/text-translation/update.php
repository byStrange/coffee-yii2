<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\TextTranslation $model */

$this->title = 'Update Text Translation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Text Translations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="text-translation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
