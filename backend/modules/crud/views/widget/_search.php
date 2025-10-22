<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var backend\modules\crud\models\WidgetSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="widget-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'style') ?>

    <?= $form->field($model, 'widget_type_id') ?>

    <?= $form->field($model, 'class') ?>

    <?= $form->field($model, 'hidden')->checkbox() ?>

    <?php // echo $form->field($model, 'background') ?>

    <?php // echo $form->field($model, 'order') ?>

    <?php // echo $form->field($model, 'parent_widget_id') ?>

    <?php // echo $form->field($model, 'section_id') ?>

    <?php // echo $form->field($model, 'margin') ?>

    <?php // echo $form->field($model, 'padding') ?>

    <?php // echo $form->field($model, 'center')->checkbox() ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
