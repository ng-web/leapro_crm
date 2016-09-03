<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CompanyLocations */

$this->title = 'Update Company Locations: ' . $model->company_location_id;
$this->params['breadcrumbs'][] = ['label' => 'Company Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->company_location_id, 'url' => ['view', 'id' => $model->company_location_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="company-locations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
