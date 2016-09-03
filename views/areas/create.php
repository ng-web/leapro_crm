<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Areas */

//$this->title = 'Create Areas';
$this->params['breadcrumbs'][] = ['label' => 'Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="areas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    			'company_location_id' => $company_location_id,
                'areas' =>  (empty($areas)) ? [new Areas] : $areas,
                'companyLocations'=>(empty($companyLocations)) ? [new CompanyLocations] : $companyLocations,
            ])
    ?>

</div>
