<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\SearchLayoutsMail $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="layouts-mail-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'mail_id') ?>

    <?= $form->field($model, 'text') ?>

    <?= $form->field($model, 'img') ?>

    <?php // echo $form->field($model, 'file') ?>

    <?php // echo $form->field($model, 'date_create') ?>

    <?php // echo $form->field($model, 'date_update') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
