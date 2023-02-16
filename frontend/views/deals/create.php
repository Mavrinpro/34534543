<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Deals $model */
/** @var app\models\Deals $service */

$this->title = 'Создать сделку';
$this->params['breadcrumbs'][] = ['label' => 'Deals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deals-create">

    <?= $this->render('_form', [
        'model' => $model,
        'service' => $service
    ]) ?>

</div>
