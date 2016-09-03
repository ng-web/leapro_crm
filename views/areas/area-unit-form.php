<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\AreaUnits;
use app\models\Units;
use app\models\Companies;
use app\models\CompanyLocations;
use app\models\LocationContacts;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
?>

 <?php $form = ActiveForm::begin([
       'enableAjaxValidation' => true,
       'id'=>'area-unit-form',
    
 ]); ?>
<div class="area_unit_wrapper">
       <?php DynamicFormWidget::begin([
                'widgetContainer' => 'area_unit_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.area-units-items', // required: css class selector
                'widgetItem' => '.area-unit-items', // required: css class
                'limit' => 8, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.area-unit-add-item', // css class
                'deleteButton' => '.area-unit-remove-item', // css class
                'model' => $area_units[0],
                'formId' => 'area-unit-form',
                'formFields' => [
                    'area_id',
                    'unit_id',
                    
                ],
            ]); ?>

        <div class="panel panel-default">
          <div class="panel-heading">
            <button type="button" class="area-unit-add-item btn btn-success btn-xs pull-right">
                <i class="glyphicon glyphicon-plus"></i>
            </button>    
            <p>Please select the units along with the values that applies to this area</p>

          </div>
          <div class="panel-body area-units-items">
            <?php foreach ($area_units as $i => $area_unit): ?>
                <div class="area-unit-items">
                    <div class="row">
                     <div class="col-md-6">
                        <?php
                                    // necessary for update action.
                                if (! $area_unit->isNewRecord) {
                                        echo Html::activeHiddenInput($area_unit, "[{$i}]area_unit_id");
                                    }
                                ?>
                        <?=  Html::activeHiddenInput($area_unit, "[{$i}]area_id"); ?>
                                 
                       <?= $form->field($area_unit, "[{$i}]unit_id")->dropDownList(ArrayHelper::map(
                             Units::find()->all(), 'unit_id', 'unit_name'),
                             ['prompt'=>'-Choose Unit-'],
                             ['class'=>'form-control inline-block ']
                             )->label('')
                       ?>
                       </div> 
                      <div class="col-md-4">
                        <?= $form->field($area_unit, "[{$i}]value")->textInput(['type' => 'number', ]) ?>
                       </div> 
                    <div class="col-md-2">
                     <button type="button" style="margin-top: 30px;" class="area-unit-remove-item btn btn-danger btn-xs">
                          <i class="glyphicon glyphicon-minus"></i>
                      </button>
                    </div> 
                </div>  
                </div> 
            <?php endforeach; ?>
             
          </div>
        </div>
  <?php DynamicFormWidget::end(); ?>
  <div class="row">
    <div class="col-md-4">
        <div class="form-group">
              <?= Html::submitButton($area_units[0]->isNewRecord ? 'Create' : 'Save', ['class' => $area_units[0]->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); 


$this->registerCss("


   ");

?>

