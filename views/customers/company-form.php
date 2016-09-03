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
use app\models\ProductsUsedPerArea;
use app\models\AdvertisingCampaign;
use app\models\EstimateStatus;
use kartik\date\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
?>
<style type="text/css">
   .form-control, .btn{
    border-radius: 0px;
   }
</style>
<div class="dynamicform_wrapper">
       <?php DynamicFormWidget::begin([
                'widgetContainer' => 'companyform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.company-items', // required: css class selector
                'widgetItem' => '.items', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $companies[0],
                'formId' => 'company-form',
                'formFields' => [
                    'area_id',
                    'area_name',
                    
                ],
            ]); ?>

        <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Company</th>
                <th style="">Location</th>
                <th class="text-center" style="width: 50px;">
                    <button type="button" class="add-item btn btn-success btn-xs pull-right"><i class="glyphicon glyphicon-plus"></i></button>				  
			    </th>
            </tr>
        </thead>
        <tbody class="company-items">
        <?php foreach ($companies as $i => $company): ?>
            <tr class="items">
                <td class="vcenter">
                     <?php
                                // necessary for update action.
                                if (! $company->isNewRecord) {
                                    echo Html::activeHiddenInput($company, "[{$i}]company_id");
                                }
                            ?>
                     <?= $form->field($company, "[{$i}]company_name")->textInput(['maxlength' => true]) ?>

                </td>
                <td>
                 <?= $this->render('company-location-form', [
                 	    'form' => $form,
				        'model' => $model,
                        'companies' => (empty($companies)) ? [new Companies] : $companies,
                        'companyLocations' => (empty($companyLocations)) ? [new CompanyLocations] : $companyLocations,
                        'locationContacts' => (empty($locationContacts)) ? [new Contacts] : $locationContacts,
						'i' => $i,
				      ]);
		         ?>
		               
                </td>
                <td class="text-center vcenter" style="width: 50px; verti">
                       <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
    </table>
  <?php DynamicFormWidget::end(); ?>
