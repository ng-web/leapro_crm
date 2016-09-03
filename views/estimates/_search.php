<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EstimatesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="estimates-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'estimate_id') ?>

    <?= $form->field($model, 'area_id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'campaign_id') ?>

    <?= $form->field($model, 'status_id') ?>

    <?php // echo $form->field($model, 'received_date') ?>

    <?php // echo $form->field($model, 'confirmed_date') ?>

    <?php // echo $form->field($model, 'schedule_date_time') ?>

    <?php // echo $form->field($model, 'customer_id') ?>

    <?php // echo $form->field($model, 'product_cost_at_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
