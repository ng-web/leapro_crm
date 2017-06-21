<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BsrActivitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bsr-activity-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'bs_id') ?>

    <?= $form->field($model, 'bs_status') ?>

    <?= $form->field($model, 'bs_qty') ?>

    <?= $form->field($model, 'weight') ?>

    <?= $form->field($model, 'number_seen') ?>

    <?php // echo $form->field($model, 'employee_id') ?>

    <?php // echo $form->field($model, 'bs_condition') ?>

    <?php // echo $form->field($model, 'bs_comments') ?>

    <?php // echo $form->field($model, 'equipment_id') ?>

    <?php // echo $form->field($model, 'bsr_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
