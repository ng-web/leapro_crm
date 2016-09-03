<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Equipment;
use app\models\Areas;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Deploy */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deploy-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName(), 'layout' => 'horizontal']); ?>

    <?= $form->field($model, 'equipment_id')->dropDownList(
            ArrayHelper::map(Equipment::find()->joinWith('deployments', true, 'RIGHT JOIN')->all(),'equipment_id','equipment_name'),
            ['prompt'=>'Select Equipment...' ]
    );?>

    <?= $form->field($model, 'estimated_area_id')->dropDownList(
            ArrayHelper::map(Yii::$app->db->createCommand('SELECT estimated_area_id, area_name from areas inner join estimated_areas
                             on areas.area_id = estimated_Areas.area_id where estimate_id = :id')
                            ->bindValues([':id'=>$estimate_id])->queryAll(),'estimated_area_id','area_name'),
            ['prompt'=>'Select Area...' ]
    )->label('Area');?>

    <?= $form->field($model, 'deploy_notes')->textarea(['rows' => 6]) ?>

      <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>

</div>
<?php
   $this->registerJs("

       $('form#{$model->formName()}').on('beforeSubmit', function(e){
           var form = $(this);

           $.post(
               form.attr('action'),
                form.serialize()
            )

            .done(function(result){
               if(result == 1){
                 
                
                 $(form).trigger('reset');
               }

            }).fail(function(){
                console.log('server error');
            });
          return false;
       });
");
?>