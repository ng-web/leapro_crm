<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Jnd */

$this->title = 'Create Job not done';
$this->params['breadcrumbs'][] = ['label' => 'Jnds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jnd-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
