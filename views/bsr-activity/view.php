<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BsrActivity */

$this->title = $model->bs_id;
$this->params['breadcrumbs'][] = ['label' => 'Bsr Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bsr-activity-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->bs_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->bs_id], [
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
            'bs_id',
            'bs_status',
            'bs_qty',
            'weight',
            'number_seen',
            'employee_id',
            'bs_condition',
            'bs_comments:ntext',
            'equipment_id',
            'bsr_id',
        ],
    ]) ?>

</div>
