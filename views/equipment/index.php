<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\editable\Editable;
use app\models\Services;
use yii\helpers\ArrayHelper;

//$this->params['breadcrumbs'][] = $this->title;

$this->title = 'Equipment Management';

?>
<div class="equipment-index">

    <p></p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="col-md-4">

        <?php $form = ActiveForm::begin(['id'=>$model->formName()]); ?>
        
        <?= $form->field($model, 'equipment_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'equipment_barcode')->textInput(['maxlength' => true]) ?>
        
         <?= $form->field($model, "service_id")->dropDownList(
        ArrayHelper::map( Services::find()->all(),'service_id','service_name'));?>

        <?= $form->field($model, 'equipment_description')->textarea(['rows' => 6]) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <div class="col-md-8">
        <?php Pjax::begin(['id'=>'equipmentGrid']);?>
        <?= GridView::widget([
            'pjax'=> true,
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                 [
                  'class' => 'kartik\grid\EditableColumn',
                  'attribute' => 'equipment_name',
                 ],
                 [
                  'class' => 'kartik\grid\EditableColumn',
                  'attribute' => 'equipment_barcode',
                 ],
                  [
                  'class' => 'kartik\grid\EditableColumn',
                  'attribute' => 'equipment_description',
                 ],

               
            ],
        ]); ?>
        <?php Pjax::end();?>
    </div>
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
                 $.pjax.reload({container:'#equipmentGrid'});
               }

            }).fail(function(){
                console.log('server error');
            });
          return false;
       });
");
?>