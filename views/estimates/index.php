<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\EstimateStatus;
use app\models\AdvertisingCampaign;

$this->title = 'Estimates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estimates-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
      <?= Html::a('Create Estimates', ['customers/index'], ['class' => 'btn btn-success'])?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
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
                    }
                ],
            ],
            
        ],
    ]); 
    ?>
<?php Pjax::end(); ?>

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
               'template' => '{view} &nbsp {update} &nbsp {reports} &nbsp {deploy}',
               'buttons' => [
                     'view' => function ($url, $model, $key) {
                           return '<a class="btn btn-success" href="index.php?r=estimates/preview&id='
                                   .$model['estimate_id'].'">View</a>';
                    },
                    'update' => function ($url, $model, $key) {
                       
                           return '<a class="btn btn-primary" href="index.php?r=estimates/update&id='
                                   .$model['estimate_id'].'"><i class="glyphicon glyphicon-edit"></i>Edit</a>';
                        
                    },
                    'reports' => function ($url, $model, $key) {
                           return '<a class="btn btn-primary" href="index.php?r=estimates/reports&id='
                                   .$model['estimate_id'].'"><i class="glyphicon "></i>Activity Reports</a>';
                        },
                    'deploy' => function ($url, $model, $key) {
                           return Html::button('Deploy', ['value'=>Url::to('index.php?r=deployment/create-by-estimate&id='.$model['estimate_id']),'class' => 'btn btn-success', 'id'=>'modalButton']) ;
                        
                    }

                    
                ],
            ],
            
        ],
    ]); 
    ?>
<?php Pjax::end(); ?>

<?php Pjax::begin(); ?>    
   <?= GridView::widget([
        'dataProvider' => $workInvoice,
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
               'template' => '{view} &nbsp {update} &nbsp {Deploy}',
               'buttons' => [
                     'view' => function ($url, $model, $key) {
                           return '<a class="btn btn-success" href="index.php?r=estimates/preview&id='
                                   .$model['estimate_id'].'">View</a>';
                    },
                    'update' => function ($url, $model, $key) {
                           return '<a class="btn btn-primary" href="index.php?r=estimates/update&id='
                                   .$model['estimate_id'].'"><i class="glyphicon glyphicon-edit"></i>Edit</a>';
            
                    },
                    
                ],
            ],
            
        ],
    ]); 
    ?>
<?php Pjax::end(); ?>

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
<?php Pjax::end(); ?></div>