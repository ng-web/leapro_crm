<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Companies;
use app\models\Addresses;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CompanyLocationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Companies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-locations-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'branch_name',
            [
               'attribute' => 'Address',
               'value' => function ($model) {
                  return ''.Addresses::findOne(['address_id'=>$model->address_id])->fullAddress;
               },
            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{sub-areas}',
               'buttons' => [
                    'sub-areas' => function ($url, $model, $key) {
                           return '<a class="btn btn-primary" href="index.php?r=areas/index&id='.$model->company_location_id.'" ><i class="glyphicon glyphicon-edit"></i>Areas</a>';
                    }
                ],
            ],
        ],
    ]); ?>
</div>
