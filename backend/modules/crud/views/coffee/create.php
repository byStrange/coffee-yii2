<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Coffee $model */

$this->title = 'Create Coffee';
$this->params['breadcrumbs'][] = ['label' => 'Coffees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coffee-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
