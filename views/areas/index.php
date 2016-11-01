<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\editable\Editable;

#---------------------------Model Pop-up declaration--------------------------#

 Modal::begin([ 'header'=>'<h4></h4>','id'=>'modal-units','size'=>'modal-lg']);
            echo "<div id='modalContent'></div>";
  Modal::end();

  Modal::begin([
            'header'=>'<h4></h4>',
            'id'=>'modal-area',
            'size'=>'modal-lg']);
            echo "<div id='modalContent'></div>";
  Modal::end();

#------------------------------------------------------------------------------#
 
$this->title = 'areas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="areas-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
       <?= Html::submitButton('Add Area', ['value'=>Url::to('index.php?r=areas/create&id='.$company_location_id.''),'class' =>'btn btn-primary', 'id'=>'modalAreaButton']) ?>
    </p>
   <?= GridView::widget([

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        
        'columns' => [
            [
              'class' => 'kartik\grid\EditableColumn',
              
               'attribute' => 'area_name',
            ],
            [
              'class' => 'kartik\grid\EditableColumn',
              'attribute' => 'area_description',
            ],
            [
                'header'=>'Units Info',
                'value'=> function($data)
                          { 
                             return '<a class="btn btn-primary" href="index.php?r=areas/area-units&id='.$data['area_id'].'" ><i class="glyphicon glyphicon-edit"></i>Units</a>';
           
                                },
                'format' => 'raw'
            ],
            ['class' => 'yii\grid\ActionColumn',
               'header'=>'Sub Area Info',
              'template' => '{sub-areas} &nbsp {units}',
               'buttons' => [
                    'sub-areas' => function ($url, $model, $key) {
                           return '<a class="btn btn-primary" href="index.php?r=areas/sub-area-index&id='.$model['area_id'].'"><i class="glyphicon glyphicon-edit"></i>Sub Areas</a>';
                    },

            ],

               
            ],
        ]
    ]); ?>
</div>

<?php 

#----------------------------Modal pop up event trigger--------------------------#

$this->registerJs("
$(function() {
   $('#popupModal').click(function(e) {
     e.preventDefault();
     $('#modal-units').modal('show').find('.modal-body')
     .load($(this).attr('href'));
   });
});
$(function(){
   $('#modalAreaButton').click(function (){
        $('#modal-area').modal('show')
                   .find('#modalContent')
                   .load($(this).attr('value'));
   });
});

   ");
#-----------------------------------------------------------------------#
?>