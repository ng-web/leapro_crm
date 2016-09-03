<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\models\Employee;
use backend\models\Equipment;
use backend\models\Job;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\BsrHeader */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bsr-header-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'layout' => 'horizontal']); ?>

    <?= $form->field($model, 'bsr_docnum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bsr_approvedby')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bsr_verifiedby')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'job_id')->dropDownList(
        ArrayHelper::map(Job::find()->all(),'job_id','job_number'),
        ['prompt'=>'Select Job...' ]
    );?>
    
    <?= $form->field($model, 'employee_id')->dropDownList(
        ArrayHelper::map(Employee::find()->all(),'employee_id','employee_name'),
        ['prompt'=>'Select Technician...' ]
    );?>
    
    <?= $form->field($model, 'bsr_date', [
    'horizontalCssClasses' => [
        'wrapper' => 'col-sm-4',
    ]])->widget(
        DatePicker::className(), [
            // inline too, not bad
             'inline' => false, 
             // modify template for custom rendering
            //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-m-d'
            ]
    ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
