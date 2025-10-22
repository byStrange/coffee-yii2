<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\modules\crud\models\TextSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="text-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'text_source_id') ?>

    <?= $form->field($model, 'widget_id') ?>

    <?= $form->field($model, 'styles') ?>

    <?= $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'font_family') ?>

    <?php // echo $form->field($model, 'align') ?>

    <?php // echo $form->field($model, 'letter_spacing') ?>

    <?php // echo $form->field($model, 'color') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
