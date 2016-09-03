 <?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\CompanyLocations;
use app\models\Companies;
use app\models\Customers;
use app\models\Addresses;
use app\models\Areas;
use app\models\Products;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
?>

<div class="area_form_wrapper">
        <div class="panel-body">
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'area_form_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.area-item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $estimatedAreas[$j][0],
                'formId' => 'dynamic-form',
                'formFields' => [
				    'area_id',
                    'area_name',
                ],
            ]); ?>

        <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Areas</th>
                <th style="width: 450px;">Products To Be Used</th>
                <th class="text-center" style="width: 90px;">
                    <button type="button" class="add-item btn btn-success btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i></button>				  
			    </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($estimatedAreas[$j] as $i => $estimatedArea): ?>
            <tr class="area-item">
                <td class="vcenter">
                    <?php
                            // necessary for update action.
                            if (! $estimatedArea->isNewRecord) {
                                echo Html::activeHiddenInput($estimatedArea, "[{$i}]area_id");
                            }
                    ?>
                   <?php 
                      if($customer->customer_type == 'Commercial')
                      {
                         echo $form->field($estimatedArea, "[{$j}][{$i}]area_id")->dropDownList(ArrayHelper::map(
    						 Areas::find()->all(), 'area_id', 'area_name'),
    						 ['prompt'=>''],
    						 ['class'=>'form-control inline-block']
    						 )->label('');
                      }
                      else{
                         echo $form->field($estimatedArea, "[{$j}][{$i}]area_id")->dropDownList(ArrayHelper::map(
                             Areas::find()->where(['customer_id'=>$customer->customer_id])->all(), 'area_id', 'area_name'),
                             ['prompt'=>'--Select Area--'],
                             ['class'=>'form-control inline-block'],
                             ['id'=>'residential-area']
                             )->label('');
                      }
					?>
                </td>
                <td>
                 <?= $this->render('product-form', [
                 	    'form' => $form,
				        'productServices' => (empty($productServices)) ? [new productServices] : $productServices,
                        'estimatedAreas' => (empty($estimatedAreas)) ? [new EstimatedAreas] : $estimatedAreas,
                        'productUsedPerAreas' => (empty($productUsedPerAreas)) ? [new ProductsUsedPerArea] : $productUsedPerAreas,
                        'i' => $i,
                        'j' => $j
				      ]);
		         ?>
		               
                </td>
                <td class="text-center" style="width: 50px;">
                       <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
    </table>
  <?php DynamicFormWidget::end(); ?>
</div>