<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BsrHeaderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bsr-header-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'bsr_docnum') ?>

    <?= $form->field($model, 'bsr_approvedby') ?>

    <?= $form->field($model, 'bsr_verifiedby') ?>

    <?= $form->field($model, 'bsr_date') ?>

    <?php // echo $form->field($model, 'emp_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
