<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Employees;
use app\models\Equipment;
use app\models\EstimatedAreas;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\BsrHeader */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bsr-header-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'layout' => 'horizontal']); ?>

    <?= $form->field($model, 'bsr_docnum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bsr_approvedby')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bsr_verifiedby')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'employee_id')->dropDownList(
        ArrayHelper::map(Employees::find()->all(),'employee_id','employee_name'),
        ['prompt'=>'Select Technician...' ]
    );?>
    
    
    
  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
