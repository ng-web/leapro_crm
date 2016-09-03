<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AdvertisingCampaign */

$this->title = 'Create Advertising Campaign';
$this->params['breadcrumbs'][] = ['label' => 'Advertising Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="advertising-campaign-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
