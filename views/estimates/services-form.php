 <?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Services;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
?>

<div class="service_form_wrappper">
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'service_form_wrappper', 
                'widgetBody' => '.container-services', 
                'widgetItem' => '.service-item', 
                'limit' => 4, 
                'min' => 1, 
                'insertButton' => '.add-service', 
                'deleteButton' => '.remove-service', 
                'model' => $productServices[0],
                'formId' => 'dynamic-form',
                'formFields' => [
				    'service_id',
                    'discount',
                ],
            ]); ?>

        <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Services</th>
                <th></th>
                <th class="text-center" style="width: 30px;">
                    <button type="button" class="add-service btn btn-success btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i></button>				  
			    </th>
            </tr>
        </thead>
        <tbody class="container-services">
        <?php foreach ($productServices as $j => $productService): ?>
            <tr class="service-item">
                <td class="vcenter">
                    <?php
                            // necessary for update action.
                            if (! $productService->isNewRecord) {
                                echo Html::activeHiddenInput($productService, "[{$j}]service_id");
                            }
                    ?>
                   <?= $form->field($productService, "[{$j}]service_id")->dropDownList(ArrayHelper::map(
						 Services::find()->all(), 'service_id', 'service_name'),
						 ['prompt'=> '-Choose Service-'],
						 ['class' =>  'form-control inline-block'],
                         [
                           
                         ]
						 )->label('')
					?>
                  
                </td>
                <td>
                   <?= $this->render('company-form', [
                        'j'=> $j,
                        'customer'=> $customer,
                        'form'=> $form,
                        'model' => $model,
                        'productServices' => (empty($productServices)) ? [new productServices] : $productServices,
                        'estimatedAreas' => (empty($estimatedAreas)) ? [new EstimatedAreas] : $estimatedAreas,
                        'productUsedPerAreas' => (empty($productUsedPerAreas)) ? [new ProductsUsedPerArea] : $productUsedPerAreas,
                    ]) ?>
                </td>   
                <td class="text-center vcenter" style="width: 50px; ">
                       <button type="button" class="remove-service btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
    </table>
  <?php DynamicFormWidget::end(); ?>

</div>

<?php?>