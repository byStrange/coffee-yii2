<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Text $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="text-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'text_source_id')->textInput() ?>

    <?= $form->field($model, 'widget_id')->textInput() ?>

    <?= $form->field($model, 'styles')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'font_family')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'align')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'letter_spacing')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'color')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
