<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use kartik\editable\Editable;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>

 <?php
    Modal::begin([
      'header'=>'<h4>Deploy</h4>',
      'id'=>'modal',
      'size'=>'modal-lg',
      ]);

    echo "<div id='modalContent'></div>";

    Modal::end();
  ?>

  <h1><?= Html::encode('Product List') ?></h1>
  
  <?= Html::button('Add Product', ['value'=>Url::to('index.php?r=products/create'),'class' => 'btn btn-success', 'id'=>'modalButton']) ?>
     
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=> true,
        'columns' => [
              [
              'class' => 'kartik\grid\EditableColumn',
               'attribute' => 'product_name',
               ],
               [
                  'class' => 'kartik\grid\EditableColumn',
                 'attribute' => 'product_description',
               ],
               [
                  'class' => 'kartik\grid\EditableColumn',
                 'attribute' => 'product_cost',
                 'value' => function ($data) {
                        return $data['product_cost']; 
                    },
               ],
               [
                  'class' => 'kartik\grid\EditableColumn',
                 'attribute' => 'product_quantity',
               ]


        ],
    ]); 
?>
 <?php
$script = "$(function() {
       
        $('#modalButton').click(function(){
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        });
    
    
})";

$this->registerJs($script);

?>