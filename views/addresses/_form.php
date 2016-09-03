<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Addresses */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="addresses-form">

    <?php $form = ActiveForm::begin(
         [
           'id'=>$model->formName(),
         ]
    ); ?>

    <?= $form->field($model, 'address_line1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_line2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_province')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_zip')->textInput() ?>

    <?= $form->field($model, 'address_type')->textInput() ?>

    <?= $form->field($model, 'address_status')->textInput() ?>

    <?= $form->field($model, 'address_details')->textarea(['rows' => 6]) ?>

    <div class="form-group">

        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

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
                 
                 $.post('index.php?r=addresses/addresses', function( data ) {
                      $('select#customers-address_id' ).html( data );
                  });
                 $(form).trigger('reset');
               }

            }).fail(function(){
                console.log('server error');
            });
          return false;
       });
");
?>