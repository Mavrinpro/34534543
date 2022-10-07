<?php

use yii\helpers\Html;
use yii\bootstrap4\Widget;
use dosamigos\datepicker\DatePicker;
/** @var yii\web\View $this */
/** @var app\models\Tasks $model */

$this->title = 'Создать задачу';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
