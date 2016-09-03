<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customers-index">
    <h1><?= Html::encode($this->title) ?></h1>
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
                      'template' => '{job-order}',
                'buttons' => [
                     'job-order' => function ($url, $model, $key) {
                           return '<a class="btn btn-primary" href="index.php?r=customers/view&id='
                                   .$model['customer_id'].'">Profile</a>';
                    }
                ],
            ],
            ['class' => 'yii\grid\ActionColumn',
               'template' => '{job-order}',
                'buttons' => [
                     'job-order' => function ($url, $model, $key) {
                           return '<a class="btn btn-danger" href="index.php?r=estimates/create&custId='
                                   .$model['customer_id'].'">Create Estimate</a>';
                    }
                ],
            ],
        ],
    ]); ?>
</div>
