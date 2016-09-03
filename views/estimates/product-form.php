<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Products;
use wbraganca\dynamicform\DynamicFormWidget;
?>
<div class="product_form_wrapper">
<div class="panel-body">
	 <?php DynamicFormWidget::begin([
		'widgetContainer' => 'product_form_wrapper',
		'widgetBody' => '.container-products',
		'widgetItem' => '.product-item', 
		'limit' => 4, 
		'min' => 1, 
		'insertButton' => '.add-pro',
		'deleteButton' => '.remove-pro', 
		'model' => $productUsedPerAreas[$j][$i][0],
		'formId' => 'dynamic-form',
		'formFields' => [
			'product_id',
			'area_name',
		],
	]); ?>
	<table class="table table-bordered">
    <thead>
        <tr>
            <th>Products</th>
            <th class="text-center">
               <button type="button" class="add-pro btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
	        </th>
        </tr>
    </thead>
    <tbody class="container-products">
     <?php foreach ($productUsedPerAreas[$j][$i] as $x => $productUsedPerArea): ?>
        <tr class="product-item">
            <td class="vcenter">
                <?php
					// necessary for update action.
					if (! $productUsedPerArea->isNewRecord) {
						echo Html::activeHiddenInput($productUsedPerArea, "[{$j}][{$i}][{$x}]product_id");
					}
				?>
                <?= $form->field($productUsedPerArea, "[{$j}][{$i}][{$x}]product_id")->dropDownList(ArrayHelper::map(
												 Products::find()->all(), 'product_id', 'product_name'),
												 ['prompt'=>'-Choose Products-'],
												 ['class'=>'form-control inline-block']
												 )->label('')
				?>
              </td>
            <td class="text-center" style="width: 50px; margin-top: 20px;">
                 <button type="button" class="remove-pro btn btn-danger btn-xs" style="margin-top: 25px; margin-right: 10px;"><i class="glyphicon glyphicon-minus"></i></button>
	        </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
</table>			
</div>
</div>
<?php DynamicFormWidget::end(); ?>

