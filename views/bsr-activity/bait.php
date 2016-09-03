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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'panel' => [
            'before' => '',
        ],
    ]); ?>

</div>

<div class="alert alert-danger">
    <?=$sql?>
</div>
