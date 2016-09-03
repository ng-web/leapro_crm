<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Deploy */

$this->title = 'Deploy Bait Station to a Location';
$this->params['breadcrumbs'][] = ['label' => 'Deploys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deploy-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'estimate_id'=>$estimate_id
    ]) ?>

</div>
