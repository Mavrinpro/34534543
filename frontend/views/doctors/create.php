<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Doctors $model */

$this->title = 'Create Doctors';
$this->params['breadcrumbs'][] = ['label' => 'Doctors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doctors-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
