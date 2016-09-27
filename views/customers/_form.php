<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Addresses;
use app\models\Companies;
use app\models\CompanyLocations;
use app\models\LocationContacts;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use wbraganca\dynamicform\DynamicFormWidget;
/* @var $this yii\web\View */
/* @var $model app\models\Customers */
/* @var $form yii\widgets\ActiveForm */
?>

<?php 

      Modal::begin([
				'header'=>'<h4></h4>',
				'id'=>'modal',
				'size'=>'modal-lg']);
			echo "<div id='modalContent'></div>";
	  Modal::end();
?>

<div class="customers-form">

    <?php $form = ActiveForm::begin(['id'=>'company-form']); ?>
<div class="row">
	<div class="col-md-6">
	    <?= $form->field($model, 'customer_firstname')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'customer_lastname')->textInput(['maxlength' => true]) ?>

	    <?= $form->field($model, 'customer_midname')->textInput(['maxlength' => true]) ?>
		
		<?= $form->field($model, 'gender')->dropDownList([ 'male' => 'Male', 'female' => 'Female', ], ['prompt' => '-Select Gender-']) ?>


	    <?= $form->field($model, 'customer_details')->textarea(['rows' => 6]) ?>
	</div>

	<div class="col-md-6">
	    <?= $form->field($model, 'address_id')->dropDownList(ArrayHelper::map(
			 Addresses::find()->all(), 'address_id', 'fullAddress'),
			 ['prompt'=>'-Choose Location-'],
			 ['class'=>'form-control inline-block']
			 )->label('Location') 
	    ?>
	    <a value="<?= Url::to('index.php?r=customers/new-address')?>" class ='btn btn-primary' id='modalButton'>
		 Add Address
		</a>
	     
		 <?= $form->field($model, 'customer_telephone')->widget(\yii\widgets\MaskedInput::className(),[
	    'mask' => '999-999-9999',]) ?>

		  <?= $form->field($model, 'customer_cell')->widget(\yii\widgets\MaskedInput::className(),[
			'mask' => '999-999-9999',]) ?>
			
		  <?= $form->field($model, 'customer_email')->textInput(['maxlength' => true]) ?>
		  
		  <?php if(!$model->isNewRecord) echo $form->field($model, 'status')->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive', ]) ?>

	</div>
	<div class="company-info-form">
		<div class="col-md-12">
		   <?php
            	if($model->customer_type == 'Commercial'){
				    echo $this->render('company-form', [
				    	 'form' => $form,
				        'model' => $model,
						'companies' => (empty($companies)) ? [new Companies] : $companies,
						'companyLocations' => (empty($companyLocations)) ? [new CompanyLocations] : $companyLocations,
						'locationContacts' => (empty($locationContacts)) ? [new Contacts] : $locationContacts
				    ]) ;
			    }
		    ?>
		 </div>
	</div>	
</div>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			  <?= Html::submitButton( 'Create', ['class' => 'btn btn-success']) ?>
		</div>
	</div>
</div>
 <?php ActiveForm::end(); ?>

</div>
<?php
   $this->registerJs("
    $(function(){
         $('#modalButton').click(function (){
          $('#modal').modal('show')
                     .find('#modalContent')
                 .load($(this).attr('value'));
             });
    });

	");
?>