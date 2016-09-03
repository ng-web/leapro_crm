<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\Products;
use wbraganca\dynamicform\DynamicFormWidget;
?>

<div class="panel-body">
	 <?php DynamicFormWidget::begin([
		'widgetContainer' => 'contactform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
		'widgetBody' => '.container-contacts', // required: css class selector
		'widgetItem' => '.contact-item', // required: css class
		'limit' => 4, // the maximum times, an element can be cloned (default 999)
		'min' => 1, // 0 or 1 (default 1)
		'insertButton' => '.add-contacts', // css class
		'deleteButton' => '.remove-contacts', // css class
		'model' =>$locationContacts[$i][$x][0],
		'formId' => 'company-form',
		'formFields' => [
			'contact_name',
			'contact_number',
			'contact_fax',
			'contact_cell',
			'contact_email',
		],
	]); ?>
	<table class="table table-bordered">
    <thead>
        <tr>
            <th>Contacts</th>
            <th class="text-center">
               <button type="button" class="add-contacts btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
	        </th>
        </tr>
    </thead>
    <tbody class="container-contacts">
     <?php foreach ($locationContacts[$i][$x] as $j => $locationContact): ?>
        <tr class="contact-item">
            <td class="vcenter">
            	<div class="col-md-4">
               <?php
					// necessary for update action.
				if (! $locationContact->isNewRecord) {
						echo Html::activeHiddenInput($locationContact, "[{$i}][{$x}][{$j}]contact_id");
					}
				?>
				<span style="display:inline;float: left;" >
				<?= $form->field($locationContact, "[{$i}][{$x}][{$j}]contact_name")->textInput(['maxlength' => true]) ?>

				<?= $form->field($locationContact, "[{$i}][{$x}][{$j}]contact_number")->textInput(['type' => 'tel']) ?>
                </div>
			   <div class="col-md-4">
				<?= $form->field($locationContact, "[{$i}][{$x}][{$j}]contact_fax")->textInput(['type' => 'tel']) ?>

				<?= $form->field($locationContact, "[{$i}][{$x}][{$j}]contact_email")->textInput(['type' => 'email']) ?>
			   </div>
											   
            </td>
           
            <td class="text-center" style="width: 50px;">
                 <button type="button" class="remove-contacts btn btn-danger btn-xs" style="margin-top: 25px; margin-right: 10px;"><i class="glyphicon glyphicon-minus"></i></button>
	        </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
</table>			
<?php DynamicFormWidget::end(); ?>
