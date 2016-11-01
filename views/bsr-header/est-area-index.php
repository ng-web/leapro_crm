<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\editable\Editable;
use app\models\Deployments;


$this->title = 'Areas';
$this->params['breadcrumbs'][] = $this->title;
?>

 <?= GridView::widget([

        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
       
        'columns' => [
             'estimated_area_id',
             'area.area_name',

            [  
               'class' => 'yii\grid\ActionColumn',
               'header'=>'',
               'template' => '{deploy} &nbsp {inspect} ',
               'buttons' => [
                    
                    'deploy' => function ($url, $model, $key) {
                           return '<a class="btn btn-primary" href="index.php?r=bsr-header/deploy&id='.$model['estimated_area_id'].'">
                                    Deploy Equipments</a>';
                    },
                    'inspect' => function ($url, $model, $key) {
                    	   //check if any equipment is deployed to this area
                    	   if(!empty(Deployments::find()->where(['estimated_area_id'=>$model['estimated_area_id']])->all())){
                           return '<a class="btn btn-warning" href="index.php?r=bsr-header/create&id='.$model['estimated_area_id'].'">
                                   <i class="glyphicon glyphicon-edit"></i> Inspect Equipments</a>';
                           }
                    },

                ],
            ],
             [
                 'header'=>'No. of Equipments Deployed',
                  'value' => function ($data) {
                           return count(Deployments::find()->where(['estimated_area_id'=>$data['estimated_area_id']])->all());
                    },
            ],
    
        ]
    ]); ?>