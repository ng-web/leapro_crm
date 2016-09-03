<?php

use yii\helpers\Html;

$this->title = 'Update Estimates: ' . $model->estimate_id;
$this->params['breadcrumbs'][] = ['label' => 'Estimates', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="estimates-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
            'customer'=> $customer,
            'model' => $model,
            'serviceEstimates' => (empty($serviceEstimates)) ? [new ServiceEstimates] : $serviceEstimates,
            'estimatedAreas' => (empty($estimatedAreas)) ? [new EstimatedAreas] : $estimatedAreas,
            'productUsedPerAreas' => (empty($productUsedPerAreas)) ? [new ProductsUsedPerArea] : $productUsedPerAreas,
        
    ]) ?>

</div>
