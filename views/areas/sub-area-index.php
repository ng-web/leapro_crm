<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;


     Modal::begin([
                'header'=>'<h4></h4>',
                'id'=>'modal-units',
                'size'=>'modal-lg']);
                echo "<div id='modalContent'></div>";
      Modal::end();

      Modal::begin([
                'header'=>'<h4></h4>',
                'id'=>'modal-area',
                'size'=>'modal-lg']);
                echo "<div id='modalContent'></div>";
      Modal::end();


$this->title = 'Sub Areas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="areas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
       <?= Html::submitButton('Add Sub Area', ['value'=>Url::to('index.php?r=areas/create&id='.$area_id.''),'class' =>'btn btn-primary', 'id'=>'modalAreaButton']) ?>
    </p>
   <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'area_name',
            'area_description:ntext',
            [
                'header'=>'Units Info',
                'value'=> function($data)
                          { 
                            return  Html::a(Yii::t('app', ' {modelClass}', [
                            'modelClass' => 'Units',]), ['areas/area-units','id'=>$data->area_id], ['class' => 'btn btn-success', 'id' => 'popupModal']);      
                          },
                'format' => 'raw'
            ],
            ['class' => 'yii\grid\ActionColumn',
               'header'=>'Sub Area Info',
              'template' => '{sub-areas} &nbsp {units}',
               'buttons' => [
                    'sub-areas' => function ($url, $model, $key) {
                           return '<a class="btn btn-primary" href="index.php?r=areas/sub-areas-index&id="><i class="glyphicon glyphicon-edit"></i>Sub Areas</a>';
                    },

            ],

               
            ],
        ]
    ]); ?>
</div>

<?php 
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

?>