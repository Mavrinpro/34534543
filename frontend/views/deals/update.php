<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Deals $model */

$this->title = 'Изменить сделку: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Сделки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="deals-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
