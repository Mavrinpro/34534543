<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\LayoutsMail $model */

$this->title = 'Создание шаблона';
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны писем', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="layouts-mail-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
