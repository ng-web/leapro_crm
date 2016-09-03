<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
?>
<div class="dynamicform_area">
<div class="panel-body">
	 <?php DynamicFormWidget::begin([
		'widgetContainer' => 'dynamicform_area',
		'widgetBody' => '.container-areas',
		'widgetItem' => '.area-item', 
		'limit' => 4, 
		'min' => 1, 
		'insertButton' => '.add-area',
		'deleteButton' => '.remove-area', 
		'model' => $areas[0],
		'formId' => 'dynamic-form',
		'formFields' => [
			'area_name',
			'area_description',
			'width',
			'length',
			'square_foot',
		],
	]); ?>
	<table class="table table-bordered">
    <thead>
        <tr>
            <th>Areas</th>
            <th class="text-center">
               <button type="button" class="add-area btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
	        </th>
        </tr>
    </thead>
    <tbody class="container-areas">
     <?php foreach ($areas as $x => $area): ?>
        <tr class="area-item">
            <td class="vcenter">
                <?php
					// necessary for update action.
					if (! $area->isNewRecord) {
						echo Html::activeHiddenInput($area, "[{$x}]area_id");
					}
					echo $form->field($area, "[{$x}]company_location_id")->hiddenInput(['value'=> $company_location_id])->label(false);
				    
				?>
               <div class="row">
                    <div class="col-md-6">
                      <?= $form->field($area, "[{$x}]area_name")->textInput(['type' => 'text']) ?>
                    </div>    
                    <div class="col-md-6">
                       <?= $form->field($area, "[{$x}]area_description")->textarea(['rows' => 3]) ?>
                    </div>                                   
               </div>
              
            </td>
            <td class="text-center" style="width: 90px;">
                 <button type="button" class="remove-area btn btn-danger btn-xs" style="margin-top: 25px; margin-right: 10px;"><i class="glyphicon glyphicon-minus"></i></button>
	        </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
</table>			
<?php DynamicFormWidget::end(); ?>
</div>
</div>