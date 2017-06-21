<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BsrActivity */

$this->title = 'Create Bsr Activity';
$this->params['breadcrumbs'][] = ['label' => 'Bsr Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bsr-activity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
