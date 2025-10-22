<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SectionGroup $model */

$this->title = 'Create Section Group';
$this->params['breadcrumbs'][] = ['label' => 'Section Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
