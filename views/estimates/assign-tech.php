<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\models\Estimates;
use app\models\Employees;
use app\models\Customers;

$this->title = 'Assignments';
$this->params['breadcrumbs'][] = $this->title;

?>
 <div class="col-md-12">
   <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#assign" data-toggle="tab">Recent Jobs Orders</a></li>
          <li><a href="#past" data-toggle="tab">Past Assignments</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="assign" >
                 <?php Pjax::begin(); ?>    
                     <?= GridView::widget([
                            'dataProvider' => $recentAssignments,
                            'filterModel' => $searchModel,
                            'striped'=>true,
                            'hover'=>true,
                            'columns' => [
                                [
                                     'attribute' => 'Job Order',
                                     'value' => function ($model) {
                                        return ''.Estimates::FindEstimateSql($model->estimate_id)[0]['name'];
                                     },
                                     'group'=>true
                                ],
                                [
                                    'attribute' => '',
                                    'format' => 'raw',
                                    'value' => function ($model) {                      
                                            return '<a class="btn btn-primary" href="index.php?r=estimates/edit-assignment&id='
                                                       .$model['estimate_id'].'">edit</a>';
                                    },
                                   'group'=>true
                                ], 
                                        
                                
                            ],
                        ]); 
                        ?>
                <?php Pjax::end(); ?>
          </div> 
          <div class="tab-pane" id="past">
             <?php Pjax::begin(); ?>    
                    <?= GridView::widget([
                        'dataProvider' => $assignments,
                        'filterModel' => $searchModel,
                        'striped'=>true,
                        'hover'=>true,
                        'columns' => [
                            [
                                 'attribute' => 'Job Order #',
                                 'value' => function ($model) {
                                    return $model->estimate_id;
                                 },
                                 'group'=>true
                            ],
                            [
                                 'attribute' => 'Client',
                                 'value' => function ($model) {
                                    var_dump($model->estimate_id);
                                    return ''.Estimates::FindEstimateSql($model->estimate_id)[0]['name'];
                                 },
                                 'group'=>true
                            ],                                  
                                
                             [
                                 'attribute' => 'Date',
                                 'value' => function ($model,$key, $index, $widget) {
                                    return $model->estimate->schedule_date_time;
                                 },
                                 'format' => ['date', 'php:d/m/Y'],
                                 'group'=>true
                            ],
                            [
                                'attribute' => 'Assigned Employess',
                                'value'=>function ($model, $key, $index, $widget) { 
                                     return ''.Employees::findOne(['emp_no'=>$model->emp_id])->employeeName;
                                },
                                'filterWidgetOptions'=>[
                                    'pluginOptions'=>['allowClear'=>true],
                                ],
                                'filterInputOptions'=>['placeholder'=>'Any category']
                            ],  
                            [
                                    'attribute' => '',
                                    'format' => 'raw',
                                    'value' => function ($model) {                      
                                            return '<a class="btn btn-primary" href="index.php?r=estimates/preview&id='
                                                       .$model['estimate_id'].'">View</a>';
                                    },
                                   'group'=>true
                            ], 

                                                        
                        ],
                    ]); 
                  ?>
                <?php Pjax::end(); ?>
          </div>
         </div>
    </div>
</div>