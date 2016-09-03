<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DeploySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deploy-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'deploy_id') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'address_id') ?>

    <?= $form->field($model, 'area_id') ?>

    <?= $form->field($model, 'equipment_id') ?>

    <?php // echo $form->field($model, 'deploy_date') ?>

    <?php // echo $form->field($model, 'deploy_notes') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
