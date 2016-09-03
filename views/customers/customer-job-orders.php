<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\EstimatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<div class="estimates-index">

    <h1><?= Html::encode('Current Job Orders') ?></h1>
    <p>
        <?= Html::a('All Job Orders', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>  
    <?php if($jobOrdersProvider->totalCount > 0){
      echo GridView::widget([
        'dataProvider' => $jobOrdersProvider,
        'columns' => [
           

            'company_name',
            'status',
             [
                 'attribute' => 'Date Accepted',
                 'value' => function ($data) {
                    return $data['company_name'] != null ?date("M d, Y", strtotime($data['schedule_date_time'])):'';                 },
            ],

            ['class' => 'yii\grid\ActionColumn',],
        ],
    ]);
    }
    else{
       echo '<div class="alert alert-info">
              <strong>Info!</strong> No Job orders are in progress for this customer.
            </div>';
    }?> 
<?php Pjax::end(); ?></div>
