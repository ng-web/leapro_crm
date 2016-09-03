<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Addresses;
use wbraganca\dynamicform\DynamicFormWidget;
?>

<?php $form = ActiveForm::begin(['id'=>'dynamic-form']); ?>
    <div class="areas-form">
     <?= $this->render('area-form', [
            'company_location_id' => $company_location_id,
            'areas' =>  (empty($areas)) ? [new Areas] : $areas,
            'form' => $form
          ])
     ?>    
   <div class="form-group">
        <?= Html::submitButton($areas[0]->isNewRecord ? 'Create' : 'Update', ['class' => $areas[0]->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>  
     
   </div>