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
use app\models\Estimates;
use kartik\date\DatePicker;
?>
<div class="estimates-form">
<?php
  $isUpdate = !$model->isNewRecord;
  $company = new Companies();
  $company_location = new CompanyLocations(); 
  if(!$model->isNewRecord ){
  	 if($customer->customer_type == 'Commercial'){
       $company = Companies::findOne(['customer_id'=>Estimates::FindEstimateSql($model->estimate_id)[0]['customer_id']]);
       $company_location = CompanyLocations::findOne(['company_location_id'=>Estimates::FindEstimateSql($model->estimate_id)[0]['c_id']]);
       

    }
    
  }else{
      //initialized  number properties of the estimate model to reduce error
       $model->tax = 0;
       $model->discount = 0;
       $model->factor = 0;
    }

  
?>

<?php $form = ActiveForm::begin(['id'=>'dynamic-form']); ?>
    <div class="col-md-12">
        	<?php
        	   if($customer->customer_type == 'Commercial')
        	   {
		            echo ' <div class="col-md-3">
		        	 <input type = "hidden" id="cust_id" value = "'.$customer->customer_id.'"></input>'.
		        	   $form->field($company, 'company_id')->dropDownList(ArrayHelper::map(Companies::find()->asArray()->all(), 'company_id', 'company_name'),
					      [
						     'onchange' => '
						          $.post("index.php?r=company-locations/locations&id='.'"+$(this).val(), function( data ) {
				                  $( "select#companylocations-company_location_id" ).html( data );});',
								  'prompt'=>'-Choose Company-',
								  'disabled'=>$isUpdate,
						  ],
						 ['class'=>'form-control'])->label('Company')
				    

					.'</div> <div class="col-md-3">'.$form->field($company_location, 'company_location_id')->dropDownList(ArrayHelper::map(
						 Addresses::find()->all(), 'address_id', 'fullAddress'),
						 ['prompt'=>'-Choose Location-',
						 'onchange' => '
						     $.post("index.php?r=areas/areas&id='.'"+$(this).val(), function( data ) {
				                  $( "select#estimatedareas-0-area_id" ).html( data );});',
						 ],
						 ['class'=>'form-control inline-block']
						 )->label('Location').'</div>';
			    }
				
            ?>

            <div class="col-md-3">
            	<?= $form->field($model, 'campaign_id')->dropDownList(ArrayHelper::map(
					 AdvertisingCampaign::find()->all(), 'id', 'name'),
					 ['prompt'=>'-Choose Campaign-'],
					 ['class'=>'form-control inline-block']
					 )->label('Campaign')
				?>
			</div>
			<div class="col-md-3">
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
            </div>
             <div class="col-md-3">
            	<?= $form->field($model, 'recurring_value')->dropDownList(
					 [
					  'W'=>'Weekly',
					  'M'=>'Monthly',
					 ],
					 ['prompt'=>'None'],
					 ['class'=>'form-control inline-block']
					 )->label('Repeat')
				?>
			</div>
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
   	    <div class="col-md-12">
   	    	 <div class="col-md-4">
             <?= $form->field($model, "tax")->textInput(['type' => 'number'])->label('Tax') ?>
             </div>
             <div class="col-md-4">
             <?= $form->field($model, "discount")->textInput(['type' => 'number'])->label('Discount') ?>
             </div>
             <div class="col-md-4">
             <?= $form->field($model, "factor")->textInput(['type' => 'number',])->label('Multiplier') ?>
             </div>
         </div>
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

<?php
$script = "$(function(){
  $.post('index.php?r=companies/companies&id='+ $('#cust_id').val(), function( data ) {
    $( 'select#companies-company_id' ).html(data);
  });
});

$(function(){
   
$('select#companylocations-company_location_id').attr('disabled',true);
	$('select#companies-company_id').change(function () {
		if ($(this).val() > 0) {
			$('select#companylocations-company_location_id').attr('disabled',false);
		}
		else{
			$('select#companylocations-company_location_id').attr('disabled',true);
		}
	});
});


//Keeps track of the indice in the estimate form
$(function(){
    var serivce_index=0;
    var area_index = 0;
    var product_index = 0;
    /*
        Trigger when the an service dynamic field is added.
        Increment the index number and popular the product dropdown;
    */
     $('.service_form_wrappper').on('afterInsert', function(e, item) {
        serivce_index++;
        $('select#productservices-'+serivce_index+'-service_id').change(function(){
             
                  $.post('index.php?r=estimates/find-product-by-service&id='+$(this).val(), function( data ) {
                      $( 'select#productsusedperarea-'+serivce_index+'-'+area_index+'-0-product_id' ).html( data );});
          });
                /*
                    Trigger when the an area dynamic field is added.
                    Increment the index number and popular the product dropdown;
                */
                $('.area_form_wrapper').on('afterInsert', function(e, item) {
                    area_index++;
                   $.post('index.php?r=estimates/find-product-by-service&id='+$('select#productservices-'+serivce_index+'-service_id').val(), function( data ) {
                         $( 'select#productsusedperarea-'+serivce_index+'-'+area_index+'-0-product_id').html( data );
                   });

                   
                   
                }); 

                /*
                    Trigger when the an product dynamic field is added.
                    Increment the index number and popular the product dropdown;
                */
               $('.product_form_wrapper').on('afterInsert', function(e, item) {
                    product_index++;
                    console.log('select#productsusedperarea-'+serivce_index+'-'+area_index+'-'+product_index+'-product_id');
                       $.post('index.php?r=estimates/find-product-by-service&id='+$('select#productservices-'+serivce_index+'-service_id').val(), function( data ) {
                         $( 'select#productsusedperarea-'+serivce_index+'-'+area_index+'-'+product_index+'-product_id').html( data );
                   });

                }); 

                    /*
                        Trigger when the a product dynamic field is removed.
                        Reorder the product index number 
                   */
                    $('.product_form_wrapper').on('afterDelete', function(e) {
                        console.log('Deleted item!');
                        product_index--;
                    });
                    
                   /*
                        Trigger when the an area dynamic field is removed.
                        Reorder the area index number 
                    */
                   $('.area_form_wrapper').on('afterDelete', function(e) {
                        console.log('Area Deleted item!');
                        area_index--;
                    });
            /*
                Trigger when the a service dynamic field is removed.
                Reorder the service index number 
            */
             $('.service_form_wrappper').on('afterDelete', function(e) {
                    console.log('Service Deleted item!');
                    service_index--;
              });

    });


});
"


;

$this->registerJs($script);

?>