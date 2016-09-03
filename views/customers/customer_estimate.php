<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estimates-index">

    <h1><?= Html::encode('Pending Estimates') ?></h1>
     <p>
        <?= Html::a('All Estimates', ['estimates/index'], ['class' => 'btn btn-primary']) ?> 
        <?= Html::a('Create Estimate', ['estimates/create','custId'=>$id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>    
    <?php if($dataProvider->totalCount > 0){
      echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'company_name',
            [

             'attribute'=>'Overall Cost',
             'value' => function ($data) {
                    //return Yii::$app->formatter->asCurrency($data['cost'], "$"); 
                },
            ],
            'status',
             [
                 'attribute' => 'Date Made',
                'value' => function ($data) {
                    return date("M d, Y", strtotime($data['received_date'])); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],

            [  
               'class' => 'yii\grid\ActionColumn',
               'template' => '{job-order} &nbsp {view} &nbsp {update}',
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
               'template' => '{job-order}',
                'buttons' => [
                     'job-order' => function ($url, $model, $key) {
                           return '<a class="btn btn-danger" href="index.php?r=estimates/create&id='
                                   .$model['estimate_id'].'&status=2">Decline</a>';
                    }
                ],
            ],
        ],
    ]); 
   }
    else{
          echo '<div class="alert alert-info">
              <strong>Info!</strong> No current estimates have been made for this customer.
            </div>';
    }?>
<?php Pjax::end(); ?></div>
