<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DeploySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Deployed Baitstations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deploy-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Deploy', ['value'=>Url::to('index.php?r=deployment/create'),'class' => 'btn btn-success', 'id'=>'modalButton']) ?>
        
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'deploy_id',
             [
                 'attribute' => 'equipment_id',
                 'value' => function ($model) {
                    return ''.Equipment::findOne(['equipment_id'=>$model->equipment_id])->equipment_name;
                 },
            ],
            'deploy_date',
            'deploy_notes:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
     <?php
        Modal::begin([
          'header'=>'<h4>Deploy</h4>',
          'id'=>'modal',
          'size'=>'modal-lg',
          ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
      ?>

</div>

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