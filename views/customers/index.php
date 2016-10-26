<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;



      Modal::begin([
        'header'=>'<h5>Select Customer Type</h5>',
        'id'=>'modal',
        'size'=>'modal-sm']);
      echo "<div id='modalContent'></div>";
    Modal::end();
?>
<!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-hashtag"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Clients</span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-ban"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">In Active Clients</span>
              <span class="info-box-number"> </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-line-chart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Conversion Rate</span>
              <span class="info-box-number"> </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
        <!-- /.col -->
      </div>
      <!-- /.row -->
<?php 
$this->title = 'Clients';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customers-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
       <?= Html::submitButton('Add Client', ['value'=>Url::to('index.php?r=customers/customer-type'),'class' =>'btn btn-primary', 'id'=>'modalButton']) ?>
        
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'customer_firstname',
            'customer_lastname',
            'customer_type',
            'status',
                    ['class' => 'yii\grid\ActionColumn',
                      'template' => '{profile} &nbsp {areas}',
                'buttons' => [
                     'profile' => function ($url, $model, $key) {
                           return 
                           '<a class="btn btn-primary" href="index.php?r=customers/view&id='.$model['customer_id'].'">Profile</a>';
                    },
                  ]
                   
            ],
            ['class' => 'yii\grid\ActionColumn',
               'template' => '{estimate}',
                'buttons' => [
                    'estimate' => function ($url, $model, $key) {
                           return '<a class="btn btn-success" href="index.php?r=estimates/create&custId='
                                   .$model['customer_id'].'">Create Estimate</a>';
                    },
                ],
            ],
            ['class' => 'yii\grid\ActionColumn',
               'template' => '{job-order}',
                'buttons' => [
                    'job-order' => function ($url, $model, $key) {
                           return '<a class="btn btn-danger" href="index.php?r=estimates/create-job-order&custId='
                                   .$model['customer_id'].'">Create Job Order</a>';
                    }
                ],
            ], 
        ],
    ]); ?>
</div>

<?php
   $this->registerJs("
    $(function(){
         $('#modalButton').click(function (){
          $('#modal').modal('show')
                     .find('#modalContent')
                 .load($(this).attr('value'));
             });
    });

   

");
?>