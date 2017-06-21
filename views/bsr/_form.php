<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BsrActivity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bsr-activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'bs_status')->textInput() ?>

    <?= $form->field($model, 'bs_qty')->textInput() ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'number_seen')->textInput() ?>

    <?= $form->field($model, 'employee_id')->textInput() ?>

    <?= $form->field($model, 'bs_condition')->textInput() ?>

    <?= $form->field($model, 'bs_comments')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'equipment_id')->textInput() ?>

    <?= $form->field($model, 'bsr_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
