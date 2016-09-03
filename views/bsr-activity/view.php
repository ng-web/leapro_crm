<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BsrHeader */

$this->title = $model->bsr_id;
$this->params['breadcrumbs'][] = ['label' => 'Bsr Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bsr-header-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->bsr_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->bsr_id], [
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
            //'bsr_id',
            'bsr_docnum',
            'bsr_approvedby',
            'bsr_verifiedby',
            'bsr_date',
            'job_id',
        ],
    ]) ?>

</div>
