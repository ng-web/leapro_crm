<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ServicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Services';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="services-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Services', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'service_name',
            'service_cost',
            'service_description:ntext',

            [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{products}',
               'buttons' => [
                    
                    'products' => function ($url, $model, $key) {
                                  return '<a class="btn btn-primary" href="index.php?r=products/index&id='
                                   .$model->service_id.'"><i class="glyphicon glyphicon-edit"></i>Products</a>';
                    }
                ],


            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
