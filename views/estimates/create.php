<?php

use yii\helpers\Html;
use app\models\EstimatedAreas;
use app\models\ProductsUsedPerArea;

/* @var $this yii\web\View */
/* @var $model app\models\Estimates */

$this->title = 'Create Estimates';
$this->params['breadcrumbs'][] = ['label' => 'Estimates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estimates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    	'customer'=> $customer,
        'model' => $model,
        'productServices' => (empty($productServices)) ? [new productServices] : $productServices,
		'estimatedAreas' => (empty($estimatedAreas)) ? [new EstimatedAreas] : $estimatedAreas,
		'productUsedPerAreas' => (empty($productUsedPerAreas)) ? [new ProductsUsedPerArea] : $productUsedPerAreas,
    ]) ?>

</div>
