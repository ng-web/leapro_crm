<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\CompanyLocations;
use app\models\Companies;
use app\models\Customers;
use app\models\Addresses;
use app\models\ProductsUsedPerArea;
use app\models\AdvertisingCampaign;
use app\models\EstimateStatus;
use kartik\date\DatePicker;
?>
<div class="estimates-form">

<?php $form = ActiveForm::begin(['id'=>'dynamic-form']); ?>
     <div id="h" style="width: 440px">
        <span style="width: 200px; float: left;">
        	<?php
        	   if($customer->customer_type == 'Commercial')
        	   {
		            echo '<td class="col-sm-6">
		        	 <input type = "hidden" id="cust_id" value = "'.$customer->customer_id.'"></input>'.
		        	   $form->field(new Companies(), 'company_id')->dropDownList(ArrayHelper::map(Companies::find()->asArray()->all(), 'company_id', 'company_name'),
					      [
						     'onchange' => '
						          $.post("index.php?r=company-locations/locations&id='.'"+$(this).val(), function( data ) {
				                  $( "select#companylocations-company_location_id" ).html( data );});',
								  'prompt'=>'-Choose Company-',
						  ],
						 ['class'=>'form-control'])->label('Company')
				    

					.''.$form->field(new CompanyLocations(), 'company_location_id')->dropDownList(ArrayHelper::map(
						 Addresses::find()->all(), 'address_id', 'fullAddress'),
						 ['prompt'=>'-Choose Location-',
						 'onchange' => '
						     $.post("index.php?r=areas/areas&id='.'"+$(this).val(), function( data ) {
				                  $( "select#estimatedareas-0-area_id" ).html( data );});',
						 ],
						 ['class'=>'form-control inline-block']
						 )->label('Location');
			    }
				
            ?>
            </span>
            <span style="width: 200px; float: left;">
            	<?= $form->field($model, 'campaign_id')->dropDownList(ArrayHelper::map(
					 AdvertisingCampaign::find()->all(), 'id', 'name'),
					 ['prompt'=>'-Choose Campaign-'],
					 ['class'=>'form-control inline-block']
					 )->label('Campaign')
				?>
				<?= $form->field($model, 'expiry_date')->widget(DatePicker::ClassName(),
				   [
					'name' => 'expiry_date', 
					'options' => ['placeholder' => 'Select issue date ...'],
					'pluginOptions' => [
					'format' => 'yyyy-m-d',
					'todayHighlight' => true
					]
				]);
		        ?> 
            </span>
	</div>	
   <div class="col-sm-12">
	  <?php
	    
		  echo $this->render('services-form', [
    			'customer'=> $customer,
		   	    'form' => $form,
		        'model' => $model,
		       'productServices' => (empty($productServices)) ? [new productServices] : $productServices,
		       'estimatedAreas' => (empty($estimatedAreas)) ? [new EstimatedAreas] : $estimatedAreas,
		       'productUsedPerAreas' => (empty($productUsedPerAreas)) ? [new ProductsUsedPerArea] : $productUsedPerAreas,
     ]);
	  ?>

   </div>
   <div class="form-group">
             <?= $form->field($model, "tax")->textInput(['type' => 'number'])->label('Tax') ?>
             <?= $form->field($model, "discount")->textInput(['type' => 'number'])->label('Discount') ?>
             <?= $form->field($model, "factor")->textInput(['type' => 'number'])->label('Multiplier') ?>
   </div >
   <div class="form-group">
		 <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
   </div>
    
    <?php ActiveForm::end(); ?>

</div>

<?php 
$this->registerCss("
	.form-control{
		width: 180px;
		font-size:14px;
		border-radius: 0px;
	}
 ");


?>
