<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>



  <h1><?= Html::encode('Product List') ?></h1>
   <?= Html::submitButton('<span class="glyphicon glyphicon-edit"></span> Add Product', ['value'=>Url::to('index.php?r=products/create&id='),'class' =>'btn btn-primary', 'id'=>'modalButton'])?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
     <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'product_id',
            'product_name',
            'product_description:ntext',
               ['attribute'=>'Product Cost',
                 'value' => function ($data) {
                        return; //Yii::$app->formatter->asCurrency($data['product_cost'], "$"); 
                    },
                ],
            'product_quantity',

            ['class' => 'yii\grid\ActionColumn',
              'template' => '{update}',
               'buttons' => [
                    'update' => function ($url, $model, $key) {
                           return Html::submitButton('<span class="glyphicon glyphicon-edit"></span>', ['value'=>Url::to('index.php?r=products/update&id='.$model['product_id']),'class' =>'', 'id'=>'modalButton']);
                    }

            ],
        ],
        ],
    ]); 
    ?>
    <?php Pjax::end(); ?>


 
