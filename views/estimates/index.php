<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\EstimateStatus;
use app\models\AdvertisingCampaign;
use kartik\dialog\Dialog;
use yii\bootstrap\Alert;

$this->title = 'Estimates';
$this->params['breadcrumbs'][] = $this->title;

?>
    <p>
      <?= Html::a('Create Estimates', ['customers/index'], ['class' => 'btn btn-success'])?>
    </p>
  <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#estimates" data-toggle="tab">All Estimates</a></li>
              <li><a href="#declined" data-toggle="tab">Declined Estimates</a></li>
            </ul>
            <div class="tab-content">
              <!-- Estimates Info-->
              <div class="active tab-pane" id="estimates">
                  <?php Pjax::begin(); ?>    
                       <?= GridView::widget([
                          'dataProvider' => $potentialWork,
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
                                      },

                                  ],
                              ],
                              ['class' => 'yii\grid\ActionColumn',
                                 'template' => '{job-order}',
                                  'buttons' => [
                                       'job-order' => function ($url, $model, $key) {
                                             return '<a class="btn btn-success" href="index.php?r=customers/estimate-status&id='
                                                     .$model['estimate_id'].'&status=3">Open Job Order</a>';
                                      }
                                  ],
                              ],
                              ['class' => 'yii\grid\ActionColumn',
                                 'template' => '{decline}',
                                  'buttons' => [
                                       'decline' => function ($url, $model, $key) {
                                             return '<a class="btn btn-danger" href="index.php?r=customers/estimate-status&id='
                                                     .$model['estimate_id'].'&status=2">Decline</a>';
                                      }
                                  ],
                              ],
                              
                          ],
                      ]); 
                      ?>
                  <?php Pjax::end(); ?>
                
                </div>
                <!-- /.Estimates Info-->    
                 <!-- Decline Info-->
                <div class="tab-pane" id="declined">
                     <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $declinedWork,
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
                </div>
                <!-- /.Declined Info-->                
         
    
 </div>
</div>