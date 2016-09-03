<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
?>

<div class="panel-body">
	 <?php DynamicFormWidget::begin([
		'widgetContainer' => 'dynamicform_sub_area',
		'widgetBody' => '.container-sub-areas',
		'widgetItem' => '.sub-area-item', 
		'limit' => 4, 
		'min' => 1, 
		'insertButton' => '.add-sub-area',
		'deleteButton' => '.remove-sub-area', 
		'model' => $sub_areas[$x][0],
		'formId' => 'dynamic-form',
		'formFields' => [
			'area_name',
			'area_description',
			
		],
	]); ?>
	<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sub Areas</th>
            <th class="text-center">
               <button type="button" class="add-sub-area btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
	        </th>
        </tr>
    </thead>
    <tbody class="container-sub-areas">
     <?php foreach ($sub_areas[$x] as $y => $sub_area): ?>
        <tr class="sub-area-item">
            <td class="vcenter">
                <?php
					/// necessary for update action.
					if (! $sub_area->isNewRecord) {
						echo Html::activeHiddenInput($sub_area, "[{$x}][{$y}]area_id");
					}
				?>
               <div class="row">
                    <div class="col-md-6">
						 <?= $form->field($sub_area, "[{$x}][{$y}]area_name")->textInput(['type' => 'text']) ?>
                         <?= $form->field($sub_area, "[{$x}][{$y}]area_description")->textarea(['rows' => 6]) ?>
                  	</div>
                                   
               </div>
            </td>
            <td class="text-center" style="width: 90px;">
                 <button type="button" class="remove-sub-area btn btn-danger btn-xs" style="margin-top: 25px; margin-right: 10px;"><i class="glyphicon glyphicon-minus"></i></button>
	        </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
</table>			
<?php DynamicFormWidget::end(); ?>
</div>
