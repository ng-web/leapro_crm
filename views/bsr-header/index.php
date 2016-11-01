<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BsrHeaderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jobs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bsr-header-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p></p>
   
    <div class="active tab-pane" id="job-orders">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $jobOrders,
            'filterModel' => $searchModel,
            'columns' => [
                'estimate_id',
                'name',
                
                [  
                   'class' => 'yii\grid\ActionColumn',
                   'template' => '{view} &nbsp {more}',
                   'buttons' => [
                        'view' => function ($url, $model, $key) {
                               return '<a class="btn btn-success" href="index.php?r=estimates/preview&id='
                                       .$model['estimate_id'].'">View</a>';
                        },
                        'more' => function ($url, $model, $key) {
                               return '<a class="btn btn-primary" href="index.php?r=bsr-header/est-area-index&id='
                                       .$model['estimate_id'].'">Inspection & Deployment</a>';
                        },
                        
                    ],
                ],
                
            ],
        ]); 
        ?>
<?php Pjax::end(); ?>