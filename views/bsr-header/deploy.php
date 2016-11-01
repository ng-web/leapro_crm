
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use app\models\Employees;
use app\models\Equipment;
use app\models\EstimatedAreas;
use yii\helpers\ArrayHelper;
use kartik\growl\Growl;
use kartik\dialog\Dialog;

if(isset($err)){
echo Growl::widget([
    'type' => Growl::TYPE_DANGER,
    'title' => 'Error submitting form',
    'icon' => 'glyphicon glyphicon-ok-sign',
    'body' => 'Please ensure that at least one deploy is checked',
    'showSeparator' => true,
    'delay' => 0,
    'pluginOptions' => [
        'showProgressbar' => true,
        'placement' => [
            'from' => 'top',
            'align' => 'center',
        ]
    ]
]);
}

?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'layout' => 'horizontal']); ?>
  <div class="panel panel-default">
     <div class="panel-heading"><h4><i class="glyphicon glyphicon-list-alt"></i> Deployment Sheet</h4></div>
       <div class="panel-body">
     <?php foreach($equipments as $i => $equip):?>
          <div class="item panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title pull-left"></h3>
                <div class="clearfix"></div>
            </div>
         <div class="panel-body">
                <?php
                    // necessary for update action.
                    if (! $models[0]->isNewRecord) {
                        echo Html::activeHiddenInput($models[0], "[{$i}deploy_id");
                    }
                    else{
                       $models[0]->equipment_id = Equipment::findOne($equip->equipment_id)->equipment_id; 
                    }
                ?>
                <div class="row">
                     <div class="col-sm-2">
                        <input type="checkbox" name="check[<?=$i?>]" checked="true" > Deploy
                     </div>
                    <div class="col-sm-4">
                        <?= $form->field($models[0], "[{$i}]equipment_id")->dropDownList(
                                        ArrayHelper::map(Equipment::find()->all(),'equipment_id','equipment_name')
                                        
                        );?>
                    </div>
                    <div class="col-sm-6">
                          <?= $form->field($models[0], "[{$i}]deploy_notes")->textarea(['rows' => 3]) ?>
                    </div>
                    
                </div><!-- .row -->
            </div>
         </div>
 <?php endforeach?>
   
  </div></div>

    <div class="form-group">
        <?= Html::submitButton($models[0]->isNewRecord ? 'Deploy' : 'Update', ['class' => $models[0]->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>