<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Jnd */

$this->title = 'Update Jnd: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Jnds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jnd-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
