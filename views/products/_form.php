<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Services;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin([
           'id'=>$model->formName(),
          
         ]); ?>

    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, "service_id")->dropDownList(
        ArrayHelper::map( Services::find()->all(),'service_id','service_name'));?>

    <?= $form->field($model, 'product_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'product_cost')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'product_quantity')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'ingredients')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'dilution')->textInput(['type'=>'number']) ?>

    <?= $form->field($model, 'application')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
   ///submit form via ajax
   $this->registerJs("

       $('form#{$model->formName()}').on('beforeSubmit', function(e){
           var form = $(this);
           $.post(
               form.attr('action'),
                form.serialize()
            )
           
            .done(function(result){
                 
                 $.post('index.php?r=products/create', function( data ) {
                      $.pjax.reload({container:'form#{$model->formName()}'});
                  });
                 $(form).trigger('reset');
               

            }).fail(function(){
                console.log('server error');
            });
          return false;
       });
");
?>