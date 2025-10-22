<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\ActiveDataList $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="active-data-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'data_provider_id')->textInput() ?>

    <?= $form->field($model, 'filter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'limit')->textInput() ?>

    <?= $form->field($model, 'widget_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
