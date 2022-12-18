<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tasks $model */

$this->title = 'Изменить задачу: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tasks-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
