<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\EstimateStatus;
use app\models\AdvertisingCampaign;

$this->title = 'Job Orders';
$this->params['breadcrumbs'][] = $this->title;

?>
 <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#job-orders" data-toggle="tab">Job Orders</a></li>
          <li><a href="#completed-job" data-toggle="tab">Completed Jobs</a></li>
        </ul>
        <div class="tab-content">

       <div class="active tab-pane" id="job-orders">
        <!--Job Order Gridview-->
        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $jobOrders,
            'filterModel' => $searchModel,
            'columns' => [

                'estimate_id',
                [
                     'attribute' => 'Campaign',
                     'value' => function ($model) {
                        return ''.AdvertisingCampaign::findOne(['id'=>$model->campaign_id])->name;
                     },
                ],
                [
                     'attribute' => 'Status',
                     'value' => function ($model) {
                        return ''.EstimateStatus::findOne(['status_id'=>$model->status_id])->status;
                     },
                ],
                [
                     'attribute' => 'Date Made',
                     'value' => function ($model) {
                        return $model->received_date != null ?date("M d, Y", strtotime($model->received_date)):'';                 },
                ],
                
                [  
                   'class' => 'yii\grid\ActionColumn',
                   'template' => '{view} &nbsp {update} ',
                   'buttons' => [
                         'view' => function ($url, $model, $key) {
                               return '<a class="btn btn-success" href="index.php?r=estimates/preview&id='
                                       .$model['estimate_id'].'">View</a>';
                        },
                        'update' => function ($url, $model, $key) {
                            if(date('Y-m-d', strtotime($model->schedule_date_time)) > date('Y-m-d')){
                               return '<a class="btn btn-primary" href="index.php?r=estimates/update&id='
                                       .$model['estimate_id'].'"><i class="glyphicon glyphicon-edit"></i>Edit</a>';
                            }
                            
                        },
                    

                        
                    ],
                ],
                
            ],
        ]); 
        ?>
    <?php Pjax::end(); ?>
  </div>
  <div class="tab-pane" id="completed-job">

  <!---Beginning of Compeleted Job Order Gridview-->
    <?php Pjax::begin(); ?>    
      <?= GridView::widget([
              'dataProvider' => $closedWork,
              'filterModel' => $searchModel,
              'columns' => [

                  'estimate_id',
                  [
                       'attribute' => 'Campaign',
                       'value' => function ($model) {
                          return ''.AdvertisingCampaign::findOne(['id'=>$model->campaign_id])->name;
                       },
                  ],
                  [
                       'attribute' => 'Status',
                       'value' => function ($model) {
                          return ''.EstimateStatus::findOne(['status_id'=>$model->status_id])->status;
                       },
                  ],
                  [
                       'attribute' => 'Date Made',
                       'value' => function ($model) {
                          return $model->received_date != null ?date("M d, Y", strtotime($model->received_date)):'';                 },
                  ],
                  
                  [  
                     'class' => 'yii\grid\ActionColumn',
                     'template' => '{view} &nbsp {update}',
                     'buttons' => [
                           'view' => function ($url, $model, $key) {
                                 return '<a class="btn btn-success" href="index.php?r=estimates/preview&id='
                                         .$model['estimate_id'].'">View</a>';
                          },
                          'update' => function ($url, $model, $key) {
                              if($model['status_id'] == 1){
                                 return '<a class="btn btn-primary" href="index.php?r=estimates/update&id='
                                         .$model['estimate_id'].'"><i class="glyphicon glyphicon-edit"></i>Edit</a>';
                              }
                          }
                      ],
                  ],
                  
              ],
          ]); 
          ?>
      <?php Pjax::end(); ?>  
  <!----------------------End of Compeleted Job Order Gridview-------------------->

    </div>
  </div>
</div>
