<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\LayoutsMail $model */

$this->title = 'Update Layouts Mail: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Layouts Mails', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="layouts-mail-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
