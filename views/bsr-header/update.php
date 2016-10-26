<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BsrHeader */

$this->title = 'Update Bsr Header: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bsr Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bsr-header-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsBsrActivity' => $modelsBsrActivity,
        'deployments' => $deployments
    ]) ?>

</div>
