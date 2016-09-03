<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BsrHeaderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bait Station Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bsr-header-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Report', ['create'], ['class' => 'btn btn-success']) ?>
        <!--Html::a('View Activity', ['bsr-activity'], ['class' => 'btn btn-warning'])--> 
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'bsr_id',
            //trying to link docnum to relevant activity records by id
            [
                'attribute' => 'bsr_docnum',
                'format' => 'raw',
                'value' => function ($model){
                    $bsrid = $model['bsr_id'];
                    $bsrdoc = $model['bsr_docnum'];
                    return Html::a(Html::encode($bsrdoc), ['bsr-header/bait', 'bsr_id' => $bsrid]);
                }
            ],
            'bsr_approvedby',
            'bsr_verifiedby',
            'bsr_date',
            // 'job_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
