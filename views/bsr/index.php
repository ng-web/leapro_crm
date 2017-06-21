<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BsrActivitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bsr Activities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bsr-activity-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Bsr Activity', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'bs_id',
            'bs_status',
            'bs_qty',
            'weight',
            'number_seen',
            // 'employee_id',
            // 'bs_condition',
            // 'bs_comments:ntext',
            // 'equipment_id',
            // 'bsr_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
