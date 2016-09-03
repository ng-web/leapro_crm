<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Addresses;
use wbraganca\dynamicform\DynamicFormWidget;
?>

<div class="panel-body">
	 	 <?php DynamicFormWidget::begin([
			'widgetContainer' => 'locationform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
			'widgetBody' => '.container-location', // required: css class selector
			'widgetItem' => '.location-item', // required: css class
			'limit' => 4, // the maximum times, an element can be cloned (default 999)
			'min' => 1, // 0 or 1 (default 1)
			'insertButton' => '.add-location', // css class
			'deleteButton' => '.remove-location', // css class
			'model' => $companyLocations[$i][0],
			'formId' => 'company-form',
			'formFields' => [
				'product_id',
				'area_name',
				
			],
		]); ?>

	<table class="table table-bordered">
    <thead>
        <tr>
            <th>Location</th>
            
            <th class="text-center">
               <button type="button" class="add-location btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
	        </th>
        </tr>
    </thead>
    <tbody class="container-location">
     <?php foreach ($companyLocations[$i] as $x => $companyLocation): ?>
        <tr class="location-item">
            <td class="vcenter">
	               	<?php
							if (! $companyLocation->isNewRecord) {
								echo Html::activeHiddenInput($companyLocation, "[{$i}][{$x}]company_location_id");
							}
					?>

				    <?= $form->field($companyLocation, "[{$i}]branch_name")->textInput(['maxlength' => true])
				            ->label('Location Name');
				    ?>

				    <?= $form->field($companyLocation, "[{$i}][{$x}]address_id")->dropDownList(ArrayHelper::map(
						 Addresses::find()->all(), 'address_id', 'fullAddress'),
						 ['prompt'=>'-Choose Address-'],
						 ['class'=>'form-control inline-block']
						 )->label('')
				    ?>
				
            </td>
          
            <td class="text-center" style="width: 50px;">
                 <button type="button" class="remove-location btn btn-danger btn-xs" style="margin-top: 25px; margin-right: 10px;"><i class="glyphicon glyphicon-minus"></i></button>
	        </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
</table>			
<?php DynamicFormWidget::end(); ?>
