<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Addresses;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\dialog\Dialog;

?>

<?php
this->title = 'Edit Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin(); ?>
	 <input type="hidden" name="estimate_id" value="<?=$estimate_id?>"/>
	<?php foreach($technicians as $tech): ?>
	  <label>
	   <input type="checkbox" name="tech[]"value="<?= $tech['emp_no']?>"
        
        <?=(!empty($tech['schedule_date_time']) && $tech['estimate_id'] == $estimate_id)?'checked="checked"':'' ?>
	   />
	    <?= $tech['first_name'].' '.$tech['last_name']?>
	  </label>
	  <br />
	<?php endforeach?>
    <br />
    <br />
    <button type="submit" class="btn btn-primary">Save Changes</button>
<?php ActiveForm::end(); ?> $



