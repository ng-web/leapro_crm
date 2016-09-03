<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Deploy */

$this->title = 'Update Deploy: ' . ' ' . $model->deploy_id;
$this->params['breadcrumbs'][] = ['label' => 'Deploys', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->deploy_id, 'url' => ['view', 'id' => $model->deploy_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="deploy-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
