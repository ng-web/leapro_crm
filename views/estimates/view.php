<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = $model->estimate_id;
$this->params['breadcrumbs'][] = ['label' => 'Estimates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estimates-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->estimate_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->estimate_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'estimate_id',
            'area_id',
            'product_id',
            'campaign_id',
            'status_id',
            'received_date',
            'confirmed_date',
            'schedule_date_time',
            'customer_id',
            'product_cost_at_time',
        ],
    ]) ?>

</div>
