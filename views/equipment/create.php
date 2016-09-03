<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Equipment */

$this->title = 'Add Equipment';
$this->params['breadcrumbs'][] = ['label' => 'Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'equipment' => $equipment,
    ]) ?>

</div>
