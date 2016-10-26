
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Employees;
use app\models\Equipment;
use app\models\EstimatedAreas;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\BsrHeader */
/* @var $form yii\widgets\ActiveForm */

?>

<?php if(!empty($deployments)):?>
<div class="bsr-header-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'layout' => 'horizontal']); ?>

    <?= $form->field($model, 'bsr_docnum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bsr_approvedby')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bsr_verifiedby')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, "estimated_area_id")->dropDownList(
        ArrayHelper::map( EstimatedAreas::find()->joinWith('area')->all(),'estimated_area_id','area.area_name'));?>

    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-list-alt"></i> Activity Sheet</h4></div>
       <div class="panel-body">
     <?php foreach($deployments as $i => $deploy):?>
          <div class="item panel panel-default"><!-- widgetBody -->
            <div class="panel-heading">
                <h3 class="panel-title pull-left"></h3>
                <div class="clearfix"></div>
            </div>
         <div class="panel-body">
                <?php
                    // necessary for update action.
                    if (! $modelsBsrActivity[0]->isNewRecord) {
                        echo Html::activeHiddenInput($modelsBsrActivity[0], "[{$i}]id");
                    }
                    else{
                       $modelsBsrActivity[0]->equipment_id = Equipment::findOne($deploy->equipment_id)->equipment_id; 
                       $modelsBsrActivity[0]->number_seen = 0; 
                    }
                ?>
                <div class="row">
                    <div class="col-sm-4">
                        <?php ?>
                        <?= $form->field($modelsBsrActivity[0], "[{$i}]equipment_id")->dropDownList(
                                        ArrayHelper::map(Equipment::find()->all(),'equipment_id','equipment_name')
                                        
                        );?>
                    </div>
                    <div class="col-sm-4">
                        <?php echo $form->field($modelsBsrActivity[0], "[{$i}]bs_status")->dropDownList(['0' => 'In-active', '1' => 'Active']); ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($modelsBsrActivity[0], "[{$i}]bs_qty")->dropDownList(['0' => 'none', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5']); ?>
                    </div>
                    
                </div><!-- .row -->
                <div class="row">
              
                    <div class="col-sm-4">
                        <?php echo $form->field($modelsBsrActivity[0], "[{$i}]number_seen")->textInput(['type'=>'number']); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php echo $form->field($modelsBsrActivity[0], "[{$i}]bs_condition")->dropDownList(['0' => 'good', '1' => 'Damaged', '3' => 'Mildew', '4' => 'Dirty', '5' => 'Other']); ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($modelsBsrActivity[0], "[{$i}]bs_comments")->textInput(['maxlength' => true]) ?>
                    </div>
                </div><!-- .row -->
            </div>
         </div>
 <?php endforeach?>
   
  </div></div></div> 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php else:?>
   <h4>No equipments were deployed to this area...</h4>
<?php endif;?>

