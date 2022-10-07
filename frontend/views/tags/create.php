<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Tags $model */

$this->title = 'Добавить тег';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
