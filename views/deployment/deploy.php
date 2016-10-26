
<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Addresses;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\dialog\Dialog;

?>
<?php $form = ActiveForm::begin(); ?>
   <input type="hidden" name="estimate_id" value=""/>
  <?php foreach($equipments as $equip): ?>
    <label>
     <input type="checkbox" name="eqiupment[]"value="<?= $equip['equipment_id']?>" />
      <?=$equip['equipment_name']?>
    </label>
    <br />
  <?php endforeach?>
    <br />
    <br />
    <button type="submit" class="btn btn-primary">Save Changes</button>
<?php ActiveForm::end(); ?> 
