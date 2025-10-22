<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Button $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="button-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'widget_id')->textInput() ?>

    <?= $form->field($model, 'action_type')->dropDownList([ 'navigate' => 'Navigate', 'jsexpression' => 'Jsexpression', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'action_data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
