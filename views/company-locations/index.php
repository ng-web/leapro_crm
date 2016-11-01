<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Companies;
use app\models\Customers;
use app\models\Addresses;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CompanyLocationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Companies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-locations-index">
 <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#comp" data-toggle="tab">Company List</a></li>
          <li><a href="#res" data-toggle="tab">Residential List</a></li>
        </ul>
        <div class="tab-content">

           <div class="active tab-pane" id="comp">
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
                          'template' => '{areas}',
                         'buttons' => [
                              'areas' => function ($url, $model, $key) {
                                     return '<a class="btn btn-primary" href="index.php?r=areas/index&id='.$model->company_location_id.'&type=1" ><i class="glyphicon glyphicon-edit"></i>Areas</a>';
                              }
                          ],
                      ],
                  ],
              ]); ?>
          </div> 
         <div class="tab-pane" id="res">
              <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            <?= GridView::widget([
                  'dataProvider' => $residentialDataProvider,
                  'filterModel' => $searchModel,
                  'columns' => [
                      ['class' => 'yii\grid\SerialColumn'],
                      [
                         'attribute' => 'Client',
                         'value' => function ($model) {
                            return ''.Customers::findOne(['customer_id'=>$model->customer_id])->fullName;
                         },
                      ],
                      
                      [
                         'attribute' => 'Address',
                         'value' => function ($model) {
                            return ''.Addresses::findOne(['address_id'=>Customers::findOne(['customer_id'=>$model->customer_id])->address_id])->fullAddress;
                         },
                      ],
                      ['class' => 'yii\grid\ActionColumn',
                          'template' => '{areas}',
                         'buttons' => [
                              'areas' => function ($url, $model, $key) {
                                     return '<a class="btn btn-primary" href="index.php?r=areas/index&id='.$model->customer_id.'&type=2" ><i class="glyphicon glyphicon-edit"></i>Areas</a>';
                              }
                          ],
                      ],
                  ],
              ]); ?>
          </div>
</div>
