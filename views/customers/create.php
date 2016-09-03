<?php

use yii\helpers\Html;

use app\models\Companies;
use app\models\Contacts;
use app\models\CompanyLocations;
use app\models\LocationContacts;

/* @var $this yii\web\View */
/* @var $model app\models\Customers */

$this->title = 'Create Customers';
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'companies' => (empty($companies)) ? [new Companies] : $companies,
		'companyLocations' => (empty($companyLocations)) ? [new CompanyLocations] : $companyLocations,
		'locationContacts' => (empty($locationContacts)) ? [new Contacts] : $locationContacts
    ]) ?>

</div>
