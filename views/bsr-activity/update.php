<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BsrHeader */

$this->title = 'Update Bsr Header: ' . ' ' . $model->bsr_id;
$this->params['breadcrumbs'][] = ['label' => 'Bsr Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bsr_id, 'url' => ['view', 'id' => $model->bsr_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bsr-header-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_updateform', [
        'model' => $model,
        //'modelsBsrActivity' => (empty($modelsBsrActivity)) ? [new Address] : $modelsBsrActivity,
    ]) ?>

</div>
